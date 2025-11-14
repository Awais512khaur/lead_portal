<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_role([1,2,3,4]);
require_once __DIR__ . '/../includes/db.php';

if (!isset($_GET['id'])) {
    die("Lead ID is required.");
}

$id = (int)$_GET['id'];

// Fetch lead
$stmt = $mysqli->prepare("SELECT * FROM lead_data WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$lead = $result->fetch_assoc();
if (!$lead) die("Lead not found.");

// Fetch latest disposition
$disp_stmt = $mysqli->prepare("SELECT id, disposition FROM lead_disposition WHERE lead_id = ? ORDER BY id DESC LIMIT 1");
$disp_stmt->bind_param("i", $id);
$disp_stmt->execute();
$disp_result = $disp_stmt->get_result();
$disp_row = $disp_result->fetch_assoc();
$lead_disposition = $disp_row['disposition'] ?? 'transfer'; 
$disp_id = $disp_row['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect all form data
    $contact_number = trim($_POST['contact_number']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    $phone2 = trim($_POST['phone2']);
    $client = trim($_POST['client']);
    $loan_officer = trim($_POST['loan_officer']);
    $address = trim($_POST['Address']);
    $zip = trim($_POST['Zip']);
    $state = trim($_POST['State']);
    $city = trim($_POST['City']);
    $address2 = trim($_POST['Address2']);
    $zip2 = trim($_POST['zip2']);
    $state2 = trim($_POST['State2']);
    $city2 = trim($_POST['City2']);
    $total_loan = trim($_POST['total_loan']);
    $interest_rate = trim($_POST['interest_rate']);
    $rate_type = trim($_POST['rate_type']);
    $rate_type2 = trim($_POST['rate_type2']);
    $loan_type = trim($_POST['loan_type']);
    $house_type = trim($_POST['house_type']);
    $property_usage = trim($_POST['property_usage']);
    $interest2 = trim($_POST['interest2']);
    $credit_card_dept = trim($_POST['credit_card_dept']);
    $late_payment = trim($_POST['late_payment']);
    $cashout = trim($_POST['cashout']);
    $foreclosure = trim($_POST['foreclosure']);
    $bankrupcy = trim($_POST['Bankrupcy']);
    $employement_status = trim($_POST['employement_status']);
    $comments = trim($_POST['comments']);
    $disposition = trim($_POST['disposition']);

    // Update lead_data
    $update_stmt = $mysqli->prepare("
        UPDATE lead_data SET
            contact_number=?, first_name=?, last_name=?, phone=?, phone2=?, client=?, loan_officer=?,
            Address=?, Zip=?, State=?, City=?, Address2=?, zip2=?, State2=?, City2=?,
            total_loan=?, interest_rate=?, rate_type=?, rate_type2=?, loan_type=?, house_type=?,
            property_usage=?, interest2=?, credit_card_dept=?, late_payment=?, cashout=?, foreclosure=?, Bankrupcy=?,
            employement_status=?, comments=?
        WHERE id=?
    ");

    $update_stmt->bind_param(
        str_repeat("s", 30) . "i",
        $contact_number, $first_name, $last_name, $phone, $phone2, $client, $loan_officer,
        $address, $zip, $state, $city, $address2, $zip2, $state2, $city2,
        $total_loan, $interest_rate, $rate_type, $rate_type2, $loan_type, $house_type,
        $property_usage, $interest2, $credit_card_dept, $late_payment, $cashout, $foreclosure, $bankrupcy,
        $employement_status, $comments, $id
    );
    $update_stmt->execute();

    // Update disposition
    if ($disp_id) {
        $disp_update_stmt = $mysqli->prepare("UPDATE lead_disposition SET disposition=? WHERE id=?");
        $disp_update_stmt->bind_param("si", $disposition, $disp_id);
        $disp_update_stmt->execute();
    } else {
        $disp_insert_stmt = $mysqli->prepare("INSERT INTO lead_disposition (lead_id, disposition) VALUES (?, ?)");
        $disp_insert_stmt->bind_param("is", $id, $disposition);
        $disp_insert_stmt->execute();
    }

    header("Location: lead_data.php?search_number=" . urlencode($contact_number));
    exit;
}
?>
<style> .container1 { max-width: 900px; margin: 50px auto; background: #ffffff; border-radius: 10px; padding: 30px 50px; box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.08); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; } .container1 h2 { text-align: center; color: #2c3e50; font-size: 28px; font-weight: 600; margin-bottom: 25px; border-bottom: 2px solid #00a8ff; padding-bottom: 10px; } .container1 form { display: flex; flex-direction: column; gap: 15px; } .container1 label { font-weight: 600; color: #005f99; margin-bottom: 5px; } .container1 input[type="text"], .container1 input[type="number"], .container1 input[type="datetime-local"], .container1 select, .container1 textarea { padding: 10px; border-radius: 6px; border: 1px solid #ccc; width: 100%; font-size: 16px; box-sizing: border-box; transition: border 0.3s ease; } .container1 input:focus, .container1 select:focus, .container1 textarea:focus { border-color: #007bff; outline: none; } .btn1, button[type="submit"] { display: inline-block; text-decoration: none; background: #007bff; color: #fff; padding: 10px 25px; border-radius: 6px; font-size: 16px; transition: all 0.3s ease; cursor: pointer; border: none; text-align: center; margin-top: 10px; } .btn1:hover, button[type="submit"]:hover { background: #0056b3; box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.2); } .btn1-secondary { display: inline-block; margin-left: 10px; color: #007bff; text-decoration: none; font-weight: 600; } .btn1-secondary:hover { text-decoration: underline; } </style>
<div class="container1">
    <h2>Edit Lead</h2>
    <form method="POST">
        <label>Contact Number</label>
        <input type="text" name="contact_number" value="<?= htmlspecialchars($lead['contact_number']) ?>" required>

        <label>First Name</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($lead['first_name']) ?>" required>

        <label>Last Name</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($lead['last_name']) ?>" required>

        <label>Phone</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($lead['phone']) ?>">

        <label>Phone 2</label>
        <input type="text" name="phone2" value="<?= htmlspecialchars($lead['phone2']) ?>">

        <label>Client</label>
        <input type="text" name="client" value="<?= htmlspecialchars($lead['client']) ?>">

        <label>Loan Officer</label>
        <input type="text" name="loan_officer" value="<?= htmlspecialchars($lead['loan_officer']) ?>">

        <label>Address</label>
        <input type="text" name="Address" value="<?= htmlspecialchars($lead['Address']) ?>">

        <label>Zip</label>
        <input type="text" name="Zip" value="<?= htmlspecialchars($lead['Zip']) ?>">

        <label>State</label>
        <input type="text" name="State" value="<?= htmlspecialchars($lead['State']) ?>">

        <label>City</label>
        <input type="text" name="City" value="<?= htmlspecialchars($lead['City']) ?>">

        <label>Address 2</label>
        <input type="text" name="Address2" value="<?= htmlspecialchars($lead['Address2']) ?>">

        <label>Zip 2</label>
        <input type="text" name="zip2" value="<?= htmlspecialchars($lead['zip2']) ?>">

        <label>State 2</label>
        <input type="text" name="State2" value="<?= htmlspecialchars($lead['State2']) ?>">

        <label>City 2</label>
        <input type="text" name="City2" value="<?= htmlspecialchars($lead['City2']) ?>">

        <label>Total Loan</label>
        <input type="text" name="total_loan" value="<?= htmlspecialchars($lead['total_loan']) ?>">

        <label>Interest Rate</label>
        <input type="text" name="interest_rate" value="<?= htmlspecialchars($lead['interest_rate']) ?>">

        <label>Rate Type</label>
        <input type="text" name="rate_type" value="<?= htmlspecialchars($lead['rate_type']) ?>">

        <label>Rate Type 2</label>
        <input type="text" name="rate_type2" value="<?= htmlspecialchars($lead['rate_type2']) ?>">

        <label>Loan Type</label>
        <input type="text" name="loan_type" value="<?= htmlspecialchars($lead['loan_type']) ?>">

        <label>House Type</label>
        <input type="text" name="house_type" value="<?= htmlspecialchars($lead['house_type']) ?>">

        <label>Property Usage</label>
        <input type="text" name="property_usage" value="<?= htmlspecialchars($lead['property_usage']) ?>">

        <label>Interest 2</label>
        <input type="text" name="interest2" value="<?= htmlspecialchars($lead['interest2']) ?>">

        <label>Credit Card Dept</label>
        <input type="text" name="credit_card_dept" value="<?= htmlspecialchars($lead['credit_card_dept']) ?>">

        <label>Late Payment</label>
        <input type="text" name="late_payment" value="<?= htmlspecialchars($lead['late_payment']) ?>">

        <label>Cashout</label>
        <input type="text" name="cashout" value="<?= htmlspecialchars($lead['cashout']) ?>">

        <label>Foreclosure</label>
        <input type="text" name="foreclosure" value="<?= htmlspecialchars($lead['foreclosure']) ?>">

        <label>Bankrupcy</label>
        <input type="text" name="Bankrupcy" value="<?= htmlspecialchars($lead['Bankrupcy']) ?>">

        <label>Employment Status</label>
        <input type="text" name="employement_status" value="<?= htmlspecialchars($lead['employement_status']) ?>">

        <label>Comments</label>
        <textarea name="comments"><?= htmlspecialchars($lead['comments']) ?></textarea>

        <label>Disposition</label>
        <select name="disposition">
            <?php
            $options = ['transfer', 'live transfer', 'DNC', 'decline', 'rejected'];
            foreach ($options as $opt) {
                $selected = ($lead_disposition === $opt) ? 'selected' : '';
                echo "<option value='{$opt}' {$selected}>".ucfirst($opt)."</option>";
            }
            ?>
        </select>

        <button type="submit">Update Lead</button>
        <a href="lead_data" class="btn1-secondary">Cancel</a>
    </form>
</div>
<script>
  if (window.location.search) {
    const url = window.location.origin + window.location.pathname;
    window.history.replaceState({}, document.title, url);
  }
</script>
