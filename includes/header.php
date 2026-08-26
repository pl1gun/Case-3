<?php require_once './config/config.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Блог Platform</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<header>
    <div class="container">
        <div class="logo"><a href="index.php" style="font-size: 1.5em; font-family: 'Georgia', serif;">MyBlog</a></div>
        <nav>
            <a href="index.php">Лента</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="create_post.php">Написать пост</a>
                <a href="profile.php?id=<?php echo $_SESSION['user_id']; ?>">Профиль</a>
                <a href="logout.php">Выход (<?php echo e($_SESSION['username']); ?>)</a>
            <?php else: ?>
                <a href="login.php">Вход</a>
                <a href="register.php">Регистрация</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<div class="container">