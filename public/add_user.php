<?php
require_once __DIR__ . '/../includes/auth.php';
require_role([1]);
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header.php';

$msg = '';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index");
    exit;
}

if (isset($_POST['add_user'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $designation = trim($_POST['designation']);
    $phone = trim($_POST['phone']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $access_level = (int)$_POST['access_level'];

    if ($name && $email && $username && $password) {
        $emp = $mysqli->prepare("INSERT INTO employee_data (name, email, designation, phone) VALUES (?,?,?,?)");
        $emp->bind_param('ssss', $name, $email, $designation, $phone);

        if ($emp->execute()) {
            $employee_id = $emp->insert_id;
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $usr = $mysqli->prepare("INSERT INTO tbl_users (username, password, employee_id, access_level, is_blocked) VALUES (?,?,?,?,0)");
            $usr->bind_param('ssii', $username, $password_hash, $employee_id, $access_level);

            if ($usr->execute()) {
                $msg = "User added successfully.";
            } else {
                $msg = "Error creating user account: " . $mysqli->error;
            }
        } else {
            $msg = "Error saving employee details: " . $mysqli->error;
        }
    } else {
        $msg = " All fields are required.";
    }
}

if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $access_level = (int)$_POST['access_level'];
    $is_blocked = isset($_POST['is_blocked']) ? 1 : 0;

    $stmt = $mysqli->prepare("UPDATE tbl_users SET access_level=?, is_blocked=? WHERE id=?");
    $stmt->bind_param('iii', $access_level, $is_blocked, $id);
    $stmt->execute();

    $msg = "User updated successfully.";
}

$users = $mysqli->query("
    SELECT u.id, u.username, e.name, u.access_level, u.is_blocked 
    FROM tbl_users u 
    LEFT JOIN employee_data e ON u.employee_id = e.id
    ORDER BY u.id ASC
");
?>

<div class="card">
    <h2>Add New User</h2>
    <?php if ($msg): ?><div class="alert"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>

    <form method="POST" class="form-grid">
        <div>
            <label>Name</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Designation</label>
            <input type="text" name="designation" required>
        </div>
        <div>
            <label>Phone</label>
            <input type="text" name="phone" required>
        </div>
        <div>
            <label>Username</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label>Access Level</label>
            <select name="access_level" required>
                <option value="1">Admin</option>
                <option value="2">LMS-Manager</option>
                <option value="3">LMS-TeamLead</option>
                <option value="4">CSR</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit" name="add_user" class="btn">Add User</button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
