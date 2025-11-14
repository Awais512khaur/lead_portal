<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_role([1]); // Admin only
require_once __DIR__ . '/../includes/db.php';
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contact_number     = trim($_POST['contact_number']);
    $first_name         = trim($_POST['first_name']);
    $last_name          = trim($_POST['last_name']);
    $phone              = trim($_POST['phone']);
    $phone2             = trim($_POST['phone2']);
    $client             = trim($_POST['client']);
    $loan_officer       = trim($_POST['loan_officer']);
    $address            = trim($_POST['Address']);
    $zip                = trim($_POST['Zip']);
    $state              = trim($_POST['State']);
    $city               = trim($_POST['City']);
    $total_loan         = trim($_POST['total_loan']);
    $interest_rate      = trim($_POST['interest_rate']);
    $rate_type          = trim($_POST['rate_type']);
    $loan_type          = trim($_POST['loan_type']);
    $house_type         = trim($_POST['house_type']);
    $property_usage     = trim($_POST['property_usage']);
    $employement_status = trim($_POST['employement_status']);
    $comments           = trim($_POST['comments']);
    $sale_date          = trim($_POST['sale_date']);
    $submitted_by       = $_SESSION['user_id'];

    // Check for duplicate contact
    $stmt_check = $mysqli->prepare("SELECT id FROM lead_data WHERE contact_number = ?");
    $stmt_check->bind_param("s", $contact_number);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $error = "Lead with contact number <strong>$contact_number</strong> is already submitted.";
    } else {
        $stmt = $mysqli->prepare("
            INSERT INTO lead_data (
                contact_number, first_name, last_name, phone, phone2, client, loan_officer, 
                Address, Zip, State, City, total_loan, interest_rate, rate_type, loan_type, 
                house_type, property_usage, employement_status, comments, sale_date, submitted_by
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        // Bind all values as string ('s') because all columns are varchar
        $stmt->bind_param(
            str_repeat('s', 21),
            $contact_number, $first_name, $last_name, $phone, $phone2, $client, $loan_officer,
            $address, $zip, $state, $city, $total_loan, $interest_rate, $rate_type, $loan_type,
            $house_type, $property_usage, $employement_status, $comments, $sale_date, $submitted_by
        );
        if ($stmt->execute()) {
            $success = true;
        } else {
            $error = "Failed to submit lead. Try again.";
        }
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
.container1 h2 {
    text-align: center;
    color: #2c3e50;
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 25px;
    border-bottom: 2px solid #00a8ff;
    padding-bottom: 10px;
}
.container1 form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.container1 label {
    font-weight: 600;
    color: #005f99;
}
.container1 input[type="text"], 
.container1 select, 
.container1 textarea {
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    width: 100%;
    font-size: 16px;
    box-sizing: border-box;
    transition: border 0.3s ease;
}
.container1 input:focus, .container1 select:focus, .container1 textarea:focus {
    border-color: #007bff;
    outline: none;
}
.btn1 {
    display: inline-block;
    text-decoration: none;
    background: #007bff;
    color: #fff;
    padding: 10px 25px;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    border: none;
    text-align: center;
}
.btn1:hover { background: #0056b3; }
.alert-success {
    background-color: #d4edda;
    border-left: 6px solid #28a745;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 5px;
    color: #155724;
}
.alert-error {
    background-color: #f8d7da;
    border-left: 6px solid #f44336;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 5px;
    color: #721c24;
}
</style>

<div class="container1">
    <h2>Add New Lead</h2>

    <?php if ($success): ?>
        <div class="alert-success">Lead submitted successfully!</div>
    <?php elseif ($error): ?>
        <div class="alert-error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Contact Number</label>
        <input type="text" name="contact_number" required>

        <label>First Name</label>
        <input type="text" name="first_name">

        <label>Last Name</label>
        <input type="text" name="last_name">

        <label>Phone</label>
        <input type="text" name="phone">

        <label>Phone 2</label>
        <input type="text" name="phone2">

        <label>Client</label>
        <input type="text" name="client">

        <label>Loan Officer</label>
        <input type="text" name="loan_officer">

        <label>Address</label>
        <input type="text" name="Address">

        <label>Zip</label>
        <input type="text" name="Zip">

        <label>State</label>
        <input type="text" name="State">

        <label>City</label>
        <input type="text" name="City">

        <label>Total Loan</label>
        <input type="text" name="total_loan">

        <label>Interest Rate</label>
        <input type="text" name="interest_rate">

        <label>Rate Type</label>
        <select name="rate_type">
            <option value="Fixed">Fixed</option>
            <option value="Variable">Variable</option>
        </select>

        <label>Loan Type</label>
        <input type="text" name="loan_type">

        <label>House Type</label>
        <input type="text" name="house_type">

        <label>Property Usage</label>
        <input type="text" name="property_usage">

        <label>Employment Status</label>
        <input type="text" name="employement_status">

        <label>Comments</label>
        <textarea name="comments" rows="3"></textarea>

        <label>Sale Date</label>
        <input type="text" name="sale_date" placeholder="YYYY-MM-DD HH:MM:SS">

        <button type="submit" class="btn1">Submit Lead</button>
    </form>
</div>
