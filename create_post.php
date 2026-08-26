<?php 
require_once 'includes/header.php'; 
requireLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $tags_input = trim($_POST['tags']);
    $is_public = isset($_POST['is_public']) ? 1 : 0;
    $is_hidden = isset($_POST['is_hidden']) ? 1 : 0;

    if ($title && $content) {
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, content, is_public, is_hidden) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $title, $content, $is_public, $is_hidden]);
            $post_id = $pdo->lastInsertId();

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
            $error = "Ошибка: " . $e->getMessage();
        }
    } else {
        $error = "Заполните заголовок и содержание.";
    }
}
?>

<div class="card">
    <h2>Новый пост</h2>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="POST">
        <div class="form-group">
            <label>Заголовок</label>
            <input type="text" name="title" required>
        </div>
        <div class="form-group">
            <label>Содержание</label>
            <textarea name="content" rows="10" required></textarea>
        </div>
        <div class="form-group">
            <label>Теги (через запятую)</label>
            <input type="text" name="tags" placeholder="php, дизайн, жизнь">
        </div>
        <div class="form-group">
            <label>Настройки видимости</label>
            <div style="margin-top: 10px;">
                <label style="display: flex; align-items: center; margin-bottom: 10px; cursor: pointer;">
                    <input type="checkbox" name="is_public" checked style="width: auto; margin-right: 10px; margin-bottom: 0;">
                    <span>Публичный пост (виден всем)</span>
                </label>
                <label style="display: flex; align-items: center; margin-bottom: 10px; cursor: pointer;">
                    <input type="checkbox" name="is_hidden" style="width: auto; margin-right: 10px; margin-bottom: 0;">
                    <span>Скрытый пост (не показывать в лентах, только по прямой ссылке)</span>
                </label>
            </div>
        </div>
        <button type="submit" class="btn">Опубликовать</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>