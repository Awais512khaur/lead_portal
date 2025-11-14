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
require_once __DIR__ . '/../includes/auth.php';
require_role([2,3]); // Team lead access
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header.php';
$csr_query = $mysqli->query("SELECT id, username FROM tbl_users WHERE access_level = 4");
if (!$csr_query) {
    echo "<div class='alert alert-error'>Error fetching CSRs: " . $mysqli->error . "</div>";
    exit;
}
$team_lead_query = $mysqli->query("SELECT id, username FROM tbl_users WHERE access_level IN (3)");
if (!$team_lead_query) {
    echo "<div class='alert alert-error'>Error fetching Team Leads: " . $mysqli->error . "</div>";
    exit;
}
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csr_id'], $_POST['team_lead_id'])) {
    $csr_id = intval($_POST['csr_id']);
    $team_lead_id = intval($_POST['team_lead_id']);
    //check csr is assigned or not 
    $check = $mysqli->prepare("SELECT * FROM csr_team WHERE csr_id = ?");
    $check->bind_param('i', $csr_id);
    $check->execute();
    $result = $check->get_result();
    if ($result->num_rows > 0) {
        $message = "<div class='alert alert-error'>This CSR is already assigned to a team lead.</div>";
    } else {
        $stmt = $mysqli->prepare("INSERT INTO csr_team (csr_id, team_lead_id) VALUES (?, ?)");
        $stmt->bind_param('ii', $csr_id, $team_lead_id);
        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>CSR assigned successfully.</div>";
        } else {
            $message = "<div class='alert alert-error'>Error assigning CSR: " . $stmt->error . "</div>";
        }
    }
}
?>
<div class="card card1">
    <h2>Assign CSR to Team Lead</h2>
    <?php echo $message; ?>
    <form method="post" class="form">
        <label>Select CSR:</label>
        <select name="csr_id" required>
            <option value="">-- Select CSR --</option>
            <?php while ($row = $csr_query->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['username']); ?></option>
            <?php endwhile; ?>
        </select>
        <label>Select Team Lead:</label>
        <select name="team_lead_id" required>
            <option value="">-- Select Team Lead --</option>
            <?php while ($row = $team_lead_query->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['username']); ?></option>
            <?php endwhile; ?>
        </select>
        <div class="form-actions">
            <button type="submit" class="btn">Assign</button>
        </div>
    </form>
    <hr>
    <h3>Assigned CSRs</h3>
    <table class="table">
        <thead>
            <tr>
                <th>S.No</th>
                <th>CSR Name</th>
                <th>Team Lead</th>
                <th>Assigned Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $assigned_stmt = $mysqli->prepare("
                SELECT u.username AS csr_name, t.assigned_at, tl.username AS team_lead_name
                FROM csr_team t
                JOIN tbl_users u ON u.id = t.csr_id
                JOIN tbl_users tl ON tl.id = t.team_lead_id
                ORDER BY t.assigned_at DESC
            ");
            $assigned_stmt->execute();
            $assigned_result = $assigned_stmt->get_result();
            $sn = 1;
            if ($assigned_result->num_rows > 0) {
                while ($r = $assigned_result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$sn}</td>
                        <td>" . htmlspecialchars($r['csr_name']) . "</td>
                        <td>" . htmlspecialchars($r['team_lead_name']) . "</td>
                        <td>{$r['assigned_at']}</td>
                    </tr>";
                    $sn++;
                }
            } 
                else 
                {
                    echo "<tr><td colspan='4'>No CSRs assigned yet.</td></tr>";
                }
            ?>
        </tbody>
    </table>
</div>
<?php //require_once __DIR__ . '/../includes/footer.php'; ?>