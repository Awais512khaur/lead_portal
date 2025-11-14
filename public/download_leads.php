<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_role([1]); // Only Admin can download
require_once __DIR__ . '/../includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index");
    exit;
}

$filter_date = isset($_GET['date']) && !empty($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$search_number = isset($_GET['contact_number']) ? trim($_GET['contact_number']) : '';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="lead_data_' . $filter_date . '.csv"');

$output = fopen('php://output', 'w');

// CSV header
fputcsv($output, [
    'S.No',
    'Contact Number',
    'First Name',
    'Last Name',
    'Phone',
    'Phone2',
    'Client',
    'Loan Officer',
    'Address',
    'Zip',
    'State',
    'City',
    'Address2',
    'Zip2',
    'State2',
    'City2',
    'Total Loan',
    'Interest Rate',
    'Rate Type',
    'Rate Type 2',
    'Loan Type',
    'House Type',
    'Property Usage',
    'Interest 2',
    'Credit Card Dept',
    'Late Payment',
    'Cashout',
    'Foreclosure',
    'Bankrupcy',
    'Employment Status',
    'Comments',
    'Disposition',
    'Sale Date',
    'Disposition Date'
]);

// Base query
$query = "
    SELECT 
        ld.contact_number,
        ld.first_name,
        ld.last_name,
        ld.phone,
        ld.phone2,
        ld.client,
        ld.loan_officer,
        ld.Address,
        ld.Zip,
        ld.State,
        ld.City,
        ld.Address2,
        ld.zip2,
        ld.State2,
        ld.City2,
        ld.total_loan,
        ld.interest_rate,
        ld.rate_type,
        ld.rate_type2,
        ld.loan_type,
        ld.house_type,
        ld.property_usage,
        ld.interest2,
        ld.credit_card_dept,
        ld.late_payment,
        ld.cashout,
        ld.foreclosure,
        ld.Bankrupcy,
        ld.employement_status,
        ld.comments,
        disp.disposition,
        ld.sale_date,
        disp.created_at AS disposition_date
    FROM lead_data ld
    JOIN lead_disposition disp ON ld.id = disp.lead_id
    WHERE DATE(ld.created_at) = ?
";

if (!empty($search_number)) {
    $query .= " AND ld.contact_number LIKE ?";
    $stmt = $mysqli->prepare($query);
    $like_number = "%$search_number%";
    $stmt->bind_param('ss', $filter_date, $like_number);
} else {
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $filter_date);
}

$stmt->execute();
$res = $stmt->get_result();
$serial = 1;

while ($row = $res->fetch_assoc()) {
    fputcsv($output, [
        $serial++,
        $row['contact_number'],
        $row['first_name'],
        $row['last_name'],
        $row['phone'],
        $row['phone2'],
        $row['client'],
        $row['loan_officer'],
        $row['Address'],
        $row['Zip'],
        $row['State'],
        $row['City'],
        $row['Address2'],
        $row['zip2'],
        $row['State2'],
        $row['City2'],
        $row['total_loan'],
        $row['interest_rate'],
        $row['rate_type'],
        $row['rate_type2'],
        $row['loan_type'],
        $row['house_type'],
        $row['property_usage'],
        $row['interest2'],
        $row['credit_card_dept'],
        $row['late_payment'],
        $row['cashout'],
        $row['foreclosure'],
        $row['Bankrupcy'],
        $row['employement_status'],
        $row['comments'],
        $row['disposition'],
        $row['sale_date'],
        $row['disposition_date']
    ]);
}

fclose($output);
exit;
?>
