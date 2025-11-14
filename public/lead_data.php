<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_role([1,2,3,4]); 
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header.php';
session_start();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['contact_number'])) {
    $contact_number = trim($_GET['contact_number']);
    $stmt = $mysqli->prepare("
        SELECT ld.*, u.username AS submitted_by_name
        FROM lead_data ld
        LEFT JOIN tbl_users u ON ld.submitted_by = u.id
        WHERE ld.contact_number = ?
    ");
    $stmt->bind_param("s", $contact_number);
    $stmt->execute();
    $result = $stmt->get_result();
    $lead = $result->fetch_assoc();

    if ($lead) {
        ?>
        <style>
.container1 { 
    max-width: 900px; 
    margin: 50px auto; 
    background: #ffffff; 
    border-radius: 10px;
    padding: 30px 50px; 
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.08); 
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
} 
.container1 h2 { 
    text-align: center; 
    color: #2c3e50; 
    font-size: 28px; 
    font-weight: 600; 
    margin-bottom: 25px; 
    border-bottom: 2px solid #00a8ff; 
    padding-bottom: 10px; 
} 
.detail-section {
    gap: 20px;
    display: flex;
    justify-content: space-between;
    margin-bottom: 30px;
}
.detail-section > div {
    width: 30%;
    background: #f9f9f9;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.detail-section h3 {
    text-align: center;
    color: #007bff;
    font-size: 20px;
    margin-bottom: 15px;
}
.detail-section p {
    font-size: 16px; 
    color: #333; 
    margin: 8px 0; 
    display: flex; 
    justify-content: space-between; 
}
.detail-section p strong {
    color: #005f99; 
    font-weight: 600; 
    width: 45%; 
    text-align: left; 
}
.detail-section p span {
    width: 55%; 
    text-align: right; 
    color: #2c3e50; 
}
.btn1 { 
    display: inline-block; 
    text-decoration: none; 
    background: #007bff; 
    color: #fff; 
    padding: 10px 25px; 
    border-radius: 6px; 
    font-size: 16px; 
    transition: all 0.3s ease;
    margin: 25px auto 0; 
    text-align: center; 
} 
.btn1:hover { 
    background: #0056b3; 
    box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.2);
} 
.btn1-secondary { 
    display: block; 
    width: fit-content; 
    margin: 25px auto; 
}
        </style>
        <div class="container1">
             <h2>Lead Details</h2>
    <div class="detail-section">
        <!-- Personal Data -->
        <div>
            <h3>Personal Data</h3>
            <p><strong>First Name:</strong> <span><?= htmlspecialchars($lead['first_name'] ?? '-') ?></span></p>
            <p><strong>Last Name:</strong> <span><?= htmlspecialchars($lead['last_name'] ?? '-') ?></span></p>
            <p><strong>Contact Number:</strong> <span><?= htmlspecialchars($lead['contact_number'] ?? '-') ?></span></p>
            <p><strong>Phone 2:</strong> <span><?= htmlspecialchars($lead['phone2'] ?? '-') ?></span></p>
            <p><strong>Address:</strong> <span><?= htmlspecialchars($lead['Address'] ?? '-') ?></span></p>
            <p><strong>Address 2:</strong> <span><?= htmlspecialchars($lead['Address2'] ?? '-') ?></span></p>
            <p><strong>State:</strong> <span><?= htmlspecialchars($lead['State'] ?? '-') ?></span></p>
            <p><strong>City:</strong> <span><?= htmlspecialchars($lead['City'] ?? '-') ?></span></p>
            <p><strong>State 2:</strong> <span><?= htmlspecialchars($lead['State2'] ?? '-') ?></span></p>
            <p><strong>City 2:</strong> <span><?= htmlspecialchars($lead['City2'] ?? '-') ?></span></p>
            <p><strong>Zip:</strong> <span><?= htmlspecialchars($lead['Zip'] ?? '-') ?></span></p>
            <p><strong>Zip 2:</strong> <span><?= htmlspecialchars($lead['zip2'] ?? '-') ?></span></p>
        </div>
        <!-- Financial Data -->
        <div>
            <h3>Financial Data</h3>
            <p><strong>Total Loan:</strong> <span><?= htmlspecialchars($lead['total_loan'] ?? '-') ?></span></p>
            <p><strong>Interest Rate:</strong> <span><?= htmlspecialchars($lead['interest_rate'] ?? '-') ?></span></p>
            <p><strong>Rate Type:</strong> <span><?= htmlspecialchars($lead['rate_type'] ?? '-') ?></span></p>
            <p><strong>Loan Type:</strong> <span><?= htmlspecialchars($lead['loan_type'] ?? '-') ?></span></p>
            <p><strong>House Type:</strong> <span><?= htmlspecialchars($lead['house_type'] ?? '-') ?></span></p>
            <p><strong>Property Usage:</strong> <span><?= htmlspecialchars($lead['property_usage'] ?? '-') ?></span></p>
            <p><strong>Interest 2:</strong> <span><?= htmlspecialchars($lead['interest2'] ?? '-') ?></span></p>
            <p><strong>Rate Type 2:</strong> <span><?= htmlspecialchars($lead['rate_type2'] ?? '-') ?></span></p>
            <p><strong>Credit Card Dept:</strong> <span><?= htmlspecialchars($lead['credit_card_dept'] ?? '-') ?></span></p>
            <p><strong>Late Payment:</strong> <span><?= htmlspecialchars($lead['late_payment'] ?? '-') ?></span></p>
            <p><strong>Cashout:</strong> <span><?= htmlspecialchars($lead['cashout'] ?? '-') ?></span></p>
            <p><strong>Foreclosure:</strong> <span><?= htmlspecialchars($lead['foreclosure'] ?? '-') ?></span></p>
            <p><strong>Bankruptcy:</strong> <span><?= htmlspecialchars($lead['Bankrupcy'] ?? '-') ?></span></p>
            <p><strong>Employment Status:</strong> <span><?= htmlspecialchars($lead['employement_status'] ?? '-') ?></span></p>
            <p><strong>Submitted By:</strong> <span><?= htmlspecialchars($lead['submitted_by_name'] ?? 'Unknown CSR') ?></span></p>
        </div>
         <!-- Client Data -->
        <div>
            <h3>Client Data</h3>
            <p><strong>Client Name:</strong> <span><?= htmlspecialchars($lead['client'] ?? '-') ?></span></p>
            <p><strong>Loan Officer:</strong> <span><?= htmlspecialchars($lead['loan_officer'] ?? '-') ?></span></p>
            <p><strong>Comments:</strong> <span><?= htmlspecialchars($lead['comments'] ?? '-') ?></span></p>
            <p><strong>Sale Date:</strong> <span><?= htmlspecialchars($lead['sale_date'] ?? '-') ?></span></p>
            <p><strong>Created At:</strong> <span><?= htmlspecialchars($lead['created_at'] ?? '-') ?></span></p>
        </div>
    </div>
            <a href="lead_data" class="btn1 btn1-secondary">← Back to All Leads</a>
        </div>
        <?php
    } else {
        echo "<div class='container'><p>No lead found for this contact number.</p><a href='lead_data.php'>Back</a></div>";
    }
    exit;
}

$search_number = '';
$filter_date = date('Y-m-d'); 
$result = false;
if (isset($_GET['search_number']) && !empty($_GET['search_number'])) {
    $search_number = trim($_GET['search_number']);
}
if (isset($_GET['filter_date']) && !empty($_GET['filter_date'])) {
    $filter_date = trim($_GET['filter_date']);
}
if (!empty($search_number)) 
{
    $stmt = $mysqli->prepare("
        SELECT id, contact_number, fisrt_name, last_name, client, loan_officer, sale_date 
        FROM lead_data 
        WHERE contact_number LIKE ? 
        ORDER BY id DESC
    ");
    $param = "%$search_number%";
    $stmt->bind_param("s", $param);
} 
else 
    {
    $stmt = $mysqli->prepare("
        SELECT id, contact_number, first_name, last_name, client, loan_officer, sale_date 
        FROM lead_data 
        WHERE DATE(sale_date) = ? 
        ORDER BY id DESC
    ");
    $stmt->bind_param("s", $filter_date);
}
$stmt->execute();
$result = $stmt->get_result();

$total_result = $mysqli->query("SELECT COUNT(*) AS total FROM lead_data");
$total_leads = $total_result->fetch_assoc()['total'];
?>
<style>
.stats-card {
    max-width: 300px;
    background: linear-gradient(135deg, #007bff, #00a8ff);
    color: white;
    text-align: center;
    padding: 20px;
    border-radius: 10px;
    margin: 30px auto;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    transition: transform 0.3s ease;
}
.stats-card:hover { transform: translateY(-5px); }
.stats-card h3 { font-size: 24px; margin: 0; font-weight: 600; }
.stats-card p { font-size: 36px; font-weight: bold; margin: 10px 0 0; }
</style>

<div class="stats-card">
    <h3>Total Leads</h3>
    <p><?= htmlspecialchars($total_leads) ?></p>
</div>

<div class="container" style="justify-items: center;">
    <h2>All Leads</h2>
    <form method="GET" action="lead_data" style="margin-bottom:20px; text-align:center;">
        <input type="text" name="search_number" placeholder="Search by Contact Number" 
            value="<?= htmlspecialchars($search_number) ?>" style="padding:8px; width:250px;">
        <input type="date" name="filter_date" value="<?= htmlspecialchars($filter_date) ?>" style="padding:8px; width:180px; margin-left:10px;">
        <button type="submit" style="padding:8px 16px; background:#007bff; color:white; border:none; border-radius:5px; cursor:pointer;">
            Search
        </button>
        <?php if (!empty($search_number) || !empty($filter_date)): ?>
            <a href="lead_data" style="margin-left:10px; color:#007bff;">Reset</a>
        <?php endif; ?>
    </form>

    <?php if ($result !== false): ?>
    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr style="background: #1a6f99; color:white;">
                <th>S.no</th>
                <th>Contact Number</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Client</th>
                <th>Loan Officer</th>
                <th>Sale Date</th>
                <?php if(in_array($user['access_level'], [1,2,3])): ?><th>Actions</th><?php endif; ?>
            </tr>
        </thead>
        <tbody>
        <?php
        $serial = 1;
        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $serial++; ?></td>
                    <td><a href="lead_data?contact_number=<?= urlencode($row['contact_number']) ?>"><?= htmlspecialchars($row['contact_number']) ?></a></td>
                    <td><?= htmlspecialchars($row['first_name']) ?></td>
                    <td><?= htmlspecialchars($row['last_name']) ?></td>
                    <td><?= htmlspecialchars($row['client']) ?></td>
                    <td><?= htmlspecialchars($row['loan_officer']) ?></td>
                    <td><?= htmlspecialchars($row['sale_date']) ?></td>
                    <td>
                        <?php if(in_array($user['access_level'], [1,2,3])): ?>
                            <a href="edit_lead?id=<?= $row['id'] ?>" style="color:#007bff;">Edit</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile;
        else: ?>
            <tr><td colspan="7" style="text-align:center;">No leads found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<script>
  if (window.location.search) {
    const url = window.location.origin + window.location.pathname;
    window.history.replaceState({}, document.title, url);
  }
</script>

<?php
// require_once __DIR__ . '/../includes/footer.php';
?>
