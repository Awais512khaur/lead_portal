<?php
// header("Cache-Control: no-cache, no-store, must-revalidate");
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
require_login();
require_role([1,2,3,4]);
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header.php';
// session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index"); 
    exit;
}
$filter_date = $_GET['date'] ?? date('Y-m-d');
$search_number = $_GET['contact_number'] ?? '';
$query = "SELECT ld.contact_number, ld.first_name, ld.last_name, ld.client, ld.loan_officer, ld.Address, ld.sale_date, disp.disposition, disp.created_at AS disposition_date
          FROM lead_data ld
          JOIN lead_disposition disp ON ld.id = disp.lead_id
          WHERE DATE(ld.created_at) = ?";
if ($search_number) 
{
    $query .= " AND ld.contact_number LIKE ?";
    $stmt = $mysqli->prepare($query);
    $like_number = "%$search_number%";
    $stmt->bind_param('ss', $filter_date, $like_number);
} 
 else 
  {
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $filter_date);
  }
$stmt->execute();
$res = $stmt->get_result();
if ($stmt->error) echo "<div style='color:red'>Query error: {$stmt->error}</div>";
?>
<div class="card card1">
  <h2>Lead List</h2>
  <form method="get" class="form-inline">
    <label>Select Date:</label>
    <input type="date" name="date" value="<?php echo esc($filter_date); ?>">
    <!-- <label>Contact Number:</label>
    <input type="text" name="contact_number" placeholder="Enter number" value="<?php echo esc($search_number); ?>"> -->
    <button type="submit" class="btn">Search</button>
    <?php if ($_SESSION['access_level'] == 1): ?>
     <a href="download_leads.php?date=<?php echo urlencode($filter_date); ?>&contact_number=<?php echo urlencode($search_number); ?>" class="btn btn-secondary">Download CSV</a>
    <?php endif; ?>
  </form>
  <table class="table">
    <thead>
      <tr>
        <th>S.no</th>
        <th>Contact</th>
        <th>Fisrt Name</th>
        <th>Lasr Name</th>
        <th>Client</th>
        <th>Loan Officer</th>
        <th>Disposition</th>
        <th>Sale Date</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($res->num_rows === 0): ?>
        <tr><td colspan="7">No leads found for <?php echo esc($filter_date); ?></td></tr>
      <?php endif; ?>
      <?php
       $serial = 1;
       while ($r = $res->fetch_assoc()): ?>
        <tr>
          <td><?php echo $serial++; ?></td>
          <td><?php echo esc($r['contact_number']); ?></td>
          <td><?php echo esc($r['first_name']); ?></td>
          <td><?php echo esc($r['last_name']); ?></td>
          <td><?php echo esc($r['client']); ?></td>
          <td><?php echo esc($r['loan_officer']); ?></td>
          <td><?php echo esc($r['disposition']); ?></td>
          <td><?php echo esc($r['disposition_date']); ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<!-- <?php //require_once __DIR__ . '/../includes/footer.php'; ?> -->