<?php 
require_once 'includes/header.php'; 

$whereClause = "WHERE p.is_hidden = 0";
$params = [];

if (isset($_GET['tag'])) {
    $whereClause .= " AND t.name = :tag";
    $params[':tag'] = $_GET['tag'];
}

if (isset($_GET['feed']) && $_GET['feed'] == 'subs' && isset($_SESSION['user_id'])) {
    $whereClause = "WHERE p.user_id IN (SELECT followee_id FROM subscriptions WHERE follower_id = :me)";
    $params[':me'] = $_SESSION['user_id'];
} elseif (isset($_SESSION['user_id'])) {
    $whereClause .= " AND (p.is_public = 1 OR p.user_id = :me)";
    $params[':me'] = $_SESSION['user_id'];
} else {
    $whereClause .= " AND p.is_public = 1";
}

$sql = "SELECT p.*, u.username, GROUP_CONCAT(t.name) as tags 
        FROM posts p 
        JOIN users u ON p.user_id = u.id 
        LEFT JOIN post_tags pt ON p.id = pt.post_id 
        LEFT JOIN tags t ON pt.tag_id = t.id 
        $whereClause 
        GROUP BY p.id 
        ORDER BY p.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$posts = $stmt->fetchAll();

$tagsStmt = $pdo->query("SELECT * FROM tags ORDER BY name");
$allTags = $tagsStmt->fetchAll();
?>

<div style="display: flex; gap: 20px;">
    <div style="flex: 3;">
        <h2>Последние публикации</h2>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <div style="margin-bottom: 20px;">
                <a href="?feed=subs" class="btn btn-small">Моя лента (Подписки)</a>
                <a href="?" class="btn btn-small" style="background:#5D4037">Все публичные</a>
            </div>
        <?php endif; ?>

        <?php foreach ($posts as $post): ?>
            <article class="card">
                <h3><a href="post.php?id=<?php echo $post['id']; ?>" style="color: var(--text-main); text-decoration: none;"><?php echo e($post['title']); ?></a></h3>
                <div class="meta">
                    Автор: <a href="profile.php?id=<?php echo $post['user_id']; ?>"><?php echo e($post['username']); ?></a> | 
                    Дата: <?php echo date('d.m.Y H:i', strtotime($post['created_at'])); ?>
                </div>
                <p><?php echo nl2br(e(substr($post['content'], 0, 200))); ?><?php if(strlen($post['content']) > 200) echo '...'; ?></p>
                
                <?php if ($post['tags']): ?>
                    <div class="tags-list" style="margin-top: 10px;">
                        <?php foreach(explode(',', $post['tags']) as $tag): ?>
                            <a href="?tag=<?php echo e($tag); ?>"><?php echo e($tag); ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
        
        <?php if (empty($posts)): ?>
            <p>Постов не найдено.</p>
        <?php endif; ?>
    </div>

    <div style="flex: 1; background: #fff; padding: 15px; border: 1px solid var(--border); height: fit-content;margin-top: 25px;">
        <h4>Теги</h4>
        <div class="tags-list">
            <?php foreach ($allTags as $tag): ?>
                <a href="?tag=<?php echo e($tag['name']); ?>"><?php echo e($tag['name']); ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>