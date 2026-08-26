<?php 
require_once 'includes/header.php'; 

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT p.*, u.username FROM posts p JOIN users u ON p.user_id = u.id WHERE p.id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    echo "<h2>Пост не найден</h2>";
    require_once 'footer.php';
    exit;
}

if ($post['is_hidden'] == 1 && (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $post['user_id'])) {
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $content = trim($_POST['comment']);
    if ($content) {
        $stmt = $pdo->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
        $stmt->execute([$id, $_SESSION['user_id'], $content]);
        header("Location: post.php?id=$id");
        exit;
    }
}

$tagsStmt = $pdo->prepare("SELECT t.name FROM tags t JOIN post_tags pt ON t.id = pt.tag_id WHERE pt.post_id = ?");
$tagsStmt->execute([$id]);
$tags = $tagsStmt->fetchAll(PDO::FETCH_COLUMN);

$commStmt = $pdo->prepare("SELECT c.*, u.username FROM comments c JOIN users u ON c.user_id = u.id WHERE c.post_id = ? ORDER BY c.created_at ASC");
$commStmt->execute([$id]);
$comments = $commStmt->fetchAll();
?>

<article class="card">
    <h1><?php echo e($post['title']); ?></h1>
    <div class="meta">
        Автор: <a href="profile.php?id=<?php echo $post['user_id']; ?>"><?php echo e($post['username']); ?></a> | 
        <?php echo date('d.m.Y H:i', strtotime($post['created_at'])); ?>
    </div>
    
    <?php if (!empty($tags)): ?>
        <div class="tags-list">
            <?php foreach($tags as $tag): ?>
                <a href="index.php?tag=<?php echo e($tag); ?>"><?php echo e($tag); ?></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div style="margin: 5px 0;">
        <?php echo e($post['content']); ?>
    </div>

    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id']): ?>
        <div style="margin-top: 20px; border-top: 1px solid var(--border); padding-top: 10px;">
            <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-small">Редактировать</a>
            <a href="delete_post.php?id=<?php echo $post['id']; ?>" class="btn btn-small" style="background: #A1887F;" onclick="return confirm('Удалить пост?')">Удалить</a>
        </div>
    <?php endif; ?>
</article>

<div class="card">
    <h3>Комментарии (<?php echo count($comments); ?>)</h3>
    
    <?php foreach ($comments as $comment): ?>
        <div class="comment">
            <strong><?php echo e($comment['username']); ?></strong> <small><?php echo date('d.m.Y H:i', strtotime($comment['created_at'])); ?></small>
            <p><?php echo nl2br(e($comment['content'])); ?></p>
        </div>
    <?php endforeach; ?>

    <?php if (isset($_SESSION['user_id'])): ?>
        <form method="POST" style="margin-top: 20px;">
            <textarea name="comment" placeholder="Написать комментарий..." required></textarea>
            <button type="submit" class="btn">Отправить</button>
        </form>
    <?php else: ?>
        <p><a href="login.php">Войдите</a>, чтобы комментировать.</p>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>