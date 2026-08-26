<?php 
require_once 'includes/header.php'; 

$user_id = $_GET['id'] ?? $_SESSION['user_id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "Пользователь не найден";
    require_once 'footer.php';
    exit;
}

if (isset($_POST['action']) && isset($_SESSION['user_id']) && $_SESSION['user_id'] != $user_id) {
    if ($_POST['action'] == 'subscribe') {
        $stmt = $pdo->prepare("INSERT IGNORE INTO subscriptions (follower_id, followee_id) VALUES (?, ?)");
        $stmt->execute([$_SESSION['user_id'], $user_id]);
    } elseif ($_POST['action'] == 'unsubscribe') {
        $stmt = $pdo->prepare("DELETE FROM subscriptions WHERE follower_id = ? AND followee_id = ?");
        $stmt->execute([$_SESSION['user_id'], $user_id]);
    }
    header("Location: profile.php?id=$user_id");
    exit;
}

$is_subscribed = false;
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT 1 FROM subscriptions WHERE follower_id = ? AND followee_id = ?");
    $stmt->execute([$_SESSION['user_id'], $user_id]);
    $is_subscribed = $stmt->fetch();
}

$postsStmt = $pdo->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
$postsStmt->execute([$user_id]);
$posts = $postsStmt->fetchAll();
?>

<div class="card">
    <h2>Профиль: <?php echo e($user['username']); ?></h2>
    <p>Дата регистрации: <?php echo date('d.m.Y', strtotime($user['created_at'])); ?></p>
    
    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $user_id): ?>
        <form method="POST" style="display:inline;">
            <?php if ($is_subscribed): ?>
                <input type="hidden" name="action" value="unsubscribe">
                <button type="submit" class="btn" style="background:#5D4037">Отписаться</button>
            <?php else: ?>
                <input type="hidden" name="action" value="subscribe">
                <button type="submit" class="btn">Подписаться</button>
            <?php endif; ?>
        </form>
    <?php endif; ?>
</div>

<h3>Посты пользователя</h3>
<?php foreach ($posts as $post): ?>
    <div class="card">
        <h4><a href="post.php?id=<?php echo $post['id']; ?>"><?php echo e($post['title']); ?></a></h4>
        <small><?php echo date('d.m.Y', strtotime($post['created_at'])); ?></small>
    </div>
<?php endforeach; ?>

<?php require_once 'includes/footer.php'; ?>