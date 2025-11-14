<?php
require_once __DIR__ . '/../includes/db.php';
session_start();
require_once __DIR__ . '/../includes/auth.php';
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $stmt = $mysqli->prepare("
        SELECT u.id, u.username, u.password, u.access_level, u.is_blocked 
        FROM tbl_users u
        LEFT JOIN employee_data e ON u.employee_id = e.id
        WHERE e.email = ?
    ");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
    if ($user) 
        {
        if ($user['is_blocked']) 
            {
            $error = 'Account is blocked by admin.';
        } 
        else 
        {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['access_level'] = (int)$user['access_level'];
                header("Location: dashboard.php");
                exit;
            } 
            else 
            {
                $error = 'Invalid email or password.';
            }
        }
    } 
    else 
    {
        $error = 'Invalid email or password.';
    }
}
?>
<link rel="icon" type="image/x-icon" href="/lead_portal/public/assets/images/logo.png">
<div class="home-div">
    <?php require_once __DIR__ . '/../includes/header.php'; ?>
    <link rel="stylesheet" href="./assets/css/index.css">
    <div class="card center-card">
        <h2>Sign In</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        <form method="post" class="form">
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <div class="form-actions">
                <button type="submit" name="login" class="btn">Login</button>
            </div>
        </form>
    </div>
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</div>
