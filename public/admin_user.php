<?php
// header("Cache-Control: no-cache, no-store, must-revalidate"); // Prevent caching
// header("Pragma: no-cache");
// header("Expires: 0");

// // Optional JS block to stop back button
// echo "<script>
//     if (window.history.replaceState) {
//         window.history.replaceState(null, null, window.location.href);
//     }
//     window.onpopstate = function() {
//         history.go(1);
//     };
// </script>";
// disable_back_button();
// prevent_back_to_login();
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_role([1]);
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header.php';
$msg = '';
// update user
if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $access_level = (int)$_POST['access_level'];
    $is_blocked = isset($_POST['is_blocked']) ? 1 : 0;
    $stmt = $mysqli->prepare("UPDATE tbl_users SET access_level=?, is_blocked=? WHERE id=?");
    $stmt->bind_param('iii', $access_level, $is_blocked, $id);
    $stmt->execute();
    $msg = "User updated successfully.";
}
// remove user
if (isset($_POST['remove'])) {
    $id = (int)$_POST['id'];
    $stmt = $mysqli->prepare("DELETE FROM tbl_users WHERE id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $msg = "User removed successfully.";
}
$users = $mysqli->query("SELECT u.id, u.username, e.name, u.access_level, u.is_blocked 
                         FROM tbl_users u 
                         LEFT JOIN employee_data e ON u.employee_id = e.id
                         ORDER BY u.access_level ASC");
?>
<div class="card">
    <h2>User Management</h2>
    <?php if($msg): ?><div class="alert"><?php echo esc($msg); ?></div><?php endif; ?>
    <table class="table">
        <thead>
            <tr>
                <th>S.no</th>
                <th>Username</th>
                <th>Name</th>
                <th>Access Level</th>
                <th>Block</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $serial = 0; while($u = $users->fetch_assoc()): ?>
            <tr>
                <form method="POST">
                    <td>
                        <?php echo ++$serial; ?>
                        <input type="hidden" name="id" value="<?php echo $u['id']; ?>">
                    </td>
                    <td><?php echo esc($u['username']); ?></td>
                    <td><?php echo esc($u['name']); ?></td>
                    <td>
                        <select name="access_level">
                            <option value="1" <?php if($u['access_level']==1) echo 'selected'; ?>>Admin</option>
                            <option value="2" <?php if($u['access_level']==2) echo 'selected'; ?>>LMS-Manager</option>
                            <option value="3" <?php if($u['access_level']==3) echo 'selected'; ?>>LMS-TeamLead</option>
                            <option value="4" <?php if($u['access_level']==4) echo 'selected'; ?>>CSR</option>
                        </select>
                    </td>
                    <td>
                        <input type="checkbox" name="is_blocked" <?php if($u['is_blocked']) echo 'checked'; ?>>
                    </td>
                    <td>
                        <button type="submit" name="update" class="btn">Update</button>
                        <button type="submit" name="remove" class="btn btn-danger" onclick="return confirm('Are you sure you want to remove this user?');">Remove</button>
                    </td>
                </form>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php //require_once __DIR__ . '/../includes/footer.php'; ?> 