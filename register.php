<?php 
require_once 'includes/header.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($username && $email && $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hash]);
            header("Location: login.php");
            exit;
        } catch (PDOException $e) {
            $error = "Пользователь с таким именем или email уже существует.";
        }
    } else {
        $error = "Заполните все поля.";
    }
}
?>

<div class="card" style="max-width: 400px; margin: 0 auto;">
    <h2>Регистрация</h2>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="POST">
        <div class="form-group">
            <label>Имя пользователя</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Пароль</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn">Зарегистрироваться</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>