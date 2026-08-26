<?php 
require_once 'includes/header.php'; 
requireLogin();

$post_id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch();

if (!$post || $post['user_id'] != $_SESSION['user_id']) {
    echo "<h2>Пост не найден или у вас нет прав на редактирование</h2>";
    require_once 'footer.php';
    exit;
}

$tagsStmt = $pdo->prepare("SELECT t.name FROM tags t JOIN post_tags pt ON t.id = pt.tag_id WHERE pt.post_id = ?");
$tagsStmt->execute([$post_id]);
$current_tags = $tagsStmt->fetchAll(PDO::FETCH_COLUMN);
$tags_string = implode(', ', $current_tags);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $tags_input = trim($_POST['tags']);
    $is_public = isset($_POST['is_public']) ? 1 : 0;
    $is_hidden = isset($_POST['is_hidden']) ? 1 : 0;

    if ($title && $content) {
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ?, is_public = ?, is_hidden = ? WHERE id = ?");
            $stmt->execute([$title, $content, $is_public, $is_hidden, $post_id]);

            $stmt = $pdo->prepare("DELETE FROM post_tags WHERE post_id = ?");
            $stmt->execute([$post_id]);

            if (!empty($tags_input)) {
                $tags_array = array_map('trim', explode(',', $tags_input));
                foreach ($tags_array as $tag_name) {
                    if (empty($tag_name)) continue;
                    
                    $stmtTag = $pdo->prepare("SELECT id FROM tags WHERE name = ?");
                    $stmtTag->execute([$tag_name]);
                    $tag = $stmtTag->fetch();
                    
                    if (!$tag) {
                        $stmtInsertTag = $pdo->prepare("INSERT INTO tags (name) VALUES (?)");
                        $stmtInsertTag->execute([$tag_name]);
                        $tag_id = $pdo->lastInsertId();
                    } else {
                        $tag_id = $tag['id'];
                    }
                    
                    $stmtLink = $pdo->prepare("INSERT IGNORE INTO post_tags (post_id, tag_id) VALUES (?, ?)");
                    $stmtLink->execute([$post_id, $tag_id]);
                }
            }
            
            $pdo->commit();
            header("Location: post.php?id=" . $post_id);
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Ошибка при обновлении: " . $e->getMessage();
        }
    } else {
        $error = "Заполните заголовок и содержание.";
    }
}
?>

<div class="card">
    <h2>Редактирование поста</h2>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="POST">
        <div class="form-group">
            <label>Заголовок</label>
            <input type="text" name="title" value="<?php echo e($post['title']); ?>" required>
        </div>
        <div class="form-group">
            <label>Содержание</label>
            <textarea name="content" rows="10" required><?php echo e($post['content']); ?></textarea>
        </div>
        <div class="form-group">
            <label>Теги (через запятую)</label>
            <input type="text" name="tags" value="<?php echo e($tags_string); ?>" placeholder="php, дизайн, жизнь">
        </div>
        <div class="form-group">
            <label>Настройки видимости</label>
            <div style="margin-top: 10px;">
                <label style="display: flex; align-items: center; margin-bottom: 10px; cursor: pointer;">
                    <input type="checkbox" name="is_public" <?php echo $post['is_public'] ? 'checked' : ''; ?> style="width: auto; margin-right: 10px; margin-bottom: 0;">
                    <span>Публичный пост (виден всем)</span>
                </label>
                <label style="display: flex; align-items: center; margin-bottom: 10px; cursor: pointer;">
                    <input type="checkbox" name="is_hidden" <?php echo $post['is_hidden'] ? 'checked' : ''; ?> style="width: auto; margin-right: 10px; margin-bottom: 0;">
                    <span>Скрытый пост (не показывать в лентах, только по прямой ссылке)</span>
                </label>
            </div>
        </div>
        <div style="margin-top: 20px;">
            <button type="submit" class="btn">Сохранить изменения</button>
            <a href="post.php?id=<?php echo $post_id; ?>" class="btn" style="background:#5D4037; margin-left: 10px;">Отмена</a>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>