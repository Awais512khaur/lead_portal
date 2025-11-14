<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_role([4]); 
require_once __DIR__ . '/../includes/db.php';
session_start();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: search.php");
    exit;
}

// Sanitize input
$csr_id = trim($_SESSION['user_id'] ?? '');
$contact_number = trim($_POST['contact_number'] ?? '');
$first_name = trim($_POST['first_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$phone2 = trim($_POST['phone2'] ?? '');
$client = trim($_POST['client'] ?? '');
$loan_officer = trim($_POST['loan_officer'] ?? '');
$address = trim($_POST['Address'] ?? '');
$zip = trim($_POST['Zip'] ?? '');
$state = trim($_POST['State'] ?? '');
$city = trim($_POST['City'] ?? '');
$address2 = trim($_POST['Address2'] ?? '');
$zip2 = trim($_POST['zip2'] ?? '');
$state2 = trim($_POST['State2'] ?? '');
$city2 = trim($_POST['City2'] ?? '');
$total_loan = trim($_POST['total_loan'] ?? '');
$interest_rate = trim($_POST['interest_rate'] ?? '');
$interest2 = trim($_POST['interest2'] ?? '');
$rate_type = trim($_POST['rate_type'] ?? '');
$rate_type2 = trim($_POST['rate_type2'] ?? '');
$loan_type = trim($_POST['loan_type'] ?? '');
$house_type = trim($_POST['house_type'] ?? '');
$property_usage = trim($_POST['property_usage'] ?? '');
$credit_card_dept = trim($_POST['credit_card_dept'] ?? '');
$late_payment = trim($_POST['late_payment'] ?? '');
$cashout = trim($_POST['cashout'] ?? '');
$foreclosure = trim($_POST['foreclosure'] ?? '');
$bankrupcy = trim($_POST['Bankrupcy'] ?? '');
$employement_status = trim($_POST['employement_status'] ?? '');
$comments = trim($_POST['comments'] ?? '');
$disposition = trim($_POST['disposition'] ?? '');

// Validation
if (!$contact_number || !$client || !$loan_officer || !$disposition) {
    $_SESSION['msg'] = "Contact number, client, loan officer, and disposition are required.";
    header("Location: search.php");
    exit;
}

// Duplicate check
$check = $mysqli->prepare("SELECT id FROM lead_data WHERE contact_number=?");
$check->bind_param("s", $contact_number);
$check->execute();
$exists = $check->get_result()->fetch_assoc();
$check->close();

if ($exists) {
    $_SESSION['msg'] = "Lead already exists.";
    header("Location: search.php");
    exit;
}

// Insert lead_data (all strings 's')
$stmt = $mysqli->prepare("
    INSERT INTO lead_data (
        contact_number, first_name, last_name, phone, phone2,
        client, loan_officer,
        Address, Zip, State, City,
        Address2, zip2, State2, City2,
        total_loan, interest_rate, rate_type, Loan_type, house_type,
        property_usage, interest2, rate_type2, credit_card_dept,
        late_payment, cashout, foreclosure, Bankrupcy,
        employement_status, comments, submitted_by
    ) VALUES (
        ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
    )
");

// Bind **all as string**
$stmt->bind_param(
    str_repeat('s', 31),
    $contact_number, $first_name, $last_name, $phone, $phone2,
    $client, $loan_officer,
    $address, $zip, $state, $city,
    $address2, $zip2, $state2, $city2,
    $total_loan, $interest_rate, $rate_type, $loan_type, $house_type,
    $property_usage, $interest2, $rate_type2, $credit_card_dept,
    $late_payment, $cashout, $foreclosure, $bankrupcy,
    $employement_status, $comments, $csr_id
);

if ($stmt->execute()) {
    $lead_id = $stmt->insert_id;
    $stmt->close();

    // Insert disposition
    $stmt2 = $mysqli->prepare("INSERT INTO lead_disposition (lead_id, csr_id, disposition) VALUES (?,?,?)");
    $stmt2->bind_param("iis", $lead_id, $csr_id, $disposition);
    $stmt2->execute();
    $stmt2->close();

    $_SESSION['msg'] = "Lead successfully submitted.";
} else {
    $_SESSION['msg'] = "Error submitting lead: " . $stmt->error;
}

header("Location: search.php");
exit;
?>
