<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_role([1]); 
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header.php';
session_start();

$search_number = '';
$lead_exists = false;
$file_data = [];
if (isset($_GET['contact_number']) && !empty($_GET['contact_number'])) {
    $search_number = trim($_GET['contact_number']);
    $stmt_check = $mysqli->prepare("SELECT id FROM lead_data WHERE contact_number = ?");
    $stmt_check->bind_param("s", $search_number);
    $stmt_check->execute();
    $stmt_check->store_result();
    if ($stmt_check->num_rows > 0) {
        $lead_exists = true;
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM file_data WHERE contact_number = ?");
        $stmt->bind_param("s", $search_number);
        $stmt->execute();
        $result = $stmt->get_result();
        $file_data = $result->fetch_assoc();
    }
}
?>

<style>
.container1 {
    max-width: 900px;
    margin: 50px auto;
    background: #ffffff;
    border-radius: 10px;
    padding: 30px 50px;
    box-shadow: 0px 4px 20px rgba(0,0,0,0.08);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.container1 h2 { text-align: center; color: #2c3e50; font-size: 28px; font-weight: 600; margin-bottom: 25px; border-bottom: 2px solid #00a8ff; padding-bottom: 10px; }
.container1 form { display: flex; flex-direction: column; gap: 15px; margin-bottom: 30px; }
.container1 label { font-weight: 600; color: #005f99; margin-bottom: 5px; }
.container1 p { background: #f9f9f9; padding: 10px; border-radius: 6px; border: 1px solid #ccc; }
.btn1 { display: inline-block; text-decoration: none; background: #007bff; color: #fff; padding: 10px 25px; border-radius: 6px; font-size: 16px; cursor: pointer; border: none; text-align: center; }
.btn1:hover { background: #0056b3; }
.alert { background-color: #ffdddd; border-left: 6px solid #f44336; padding: 15px; margin-bottom: 20px; border-radius: 5px; color: #a94442; }
</style>
<div class="container1">
    <h2>Search Lead</h2>
    <form method="GET">
        <label>Search Contact Number</label>
        <input type="text" name="contact_number" placeholder="Enter Contact Number" value="<?= htmlspecialchars($search_number) ?>" required>
        <button type="submit" class="btn1">Search</button>
    </form>
    <?php if ($search_number): ?>
        <?php if ($lead_exists): ?>
            <div class="alert">
                Lead with contact number <strong><?= htmlspecialchars($search_number) ?></strong> is already submitted.
            </div>
        <?php elseif ($file_data): ?>
            <h3>Lead Details</h3>
            <p><strong>Contact Number:</strong> <?= htmlspecialchars($file_data['contact_number']) ?></p>
            <p><strong>First Name:</strong> <?= htmlspecialchars($file_data['first_name'] ?? '-') ?></p>
            <p><strong>Last Name:</strong> <?= htmlspecialchars($file_data['last_name'] ?? '-') ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($file_data['phone'] ?? '-') ?></p>
            <p><strong>Phone 2:</strong> <?= htmlspecialchars($file_data['phone2'] ?? '-') ?></p>
            <p><strong>Client:</strong> <?= htmlspecialchars($file_data['client'] ?? '-') ?></p>
            <p><strong>Loan Officer:</strong> <?= htmlspecialchars($file_data['loan_officer'] ?? '-') ?></p>
            <p><strong>Address:</strong> <?= htmlspecialchars($file_data['Address'] ?? '-') ?></p>
            <p><strong>Zip:</strong> <?= htmlspecialchars($file_data['Zip'] ?? '-') ?></p>
            <p><strong>State:</strong> <?= htmlspecialchars($file_data['State'] ?? '-') ?></p>
            <p><strong>City:</strong> <?= htmlspecialchars($file_data['City'] ?? '-') ?></p>
            <p><strong>Total Loan:</strong> <?= htmlspecialchars($file_data['total_loan'] ?? '-') ?></p>
            <p><strong>Interest Rate:</strong> <?= htmlspecialchars($file_data['interest_rate'] ?? '-') ?></p>
            <p><strong>Rate Type:</strong> <?= htmlspecialchars($file_data['rate_type'] ?? '-') ?></p>
            <p><strong>Loan Type:</strong> <?= htmlspecialchars($file_data['loan_type'] ?? '-') ?></p>
            <p><strong>House Type:</strong> <?= htmlspecialchars($file_data['house_type'] ?? '-') ?></p>
            <p><strong>Property Usage:</strong> <?= htmlspecialchars($file_data['property_usage'] ?? '-') ?></p>
            <p><strong>Employment Status:</strong> <?= htmlspecialchars($file_data['employement_status'] ?? '-') ?></p>
            <p><strong>Comments:</strong> <?= htmlspecialchars($file_data['comments'] ?? '-') ?></p>
        <?php else: ?>
            <div class="alert">
                No record found in file data for <strong><?= htmlspecialchars($search_number) ?></strong>.
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
