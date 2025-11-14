<?php 
require_once __DIR__ . '/../includes/auth.php';
require_role([1,2,3]);
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

$inserted = 0; 
$skipped = 0; 
$messages = [];

// Define all expected columns in correct order
$cols = [
    "contact_number","first_name","last_name","phone","phone2","client","loan_officer",
    "Address","Zip","State","City","Address2","zip2","State2","City2",
    "total_loan","interest_rate","rate_type","Loan_type","house_type","property_usage",
    "interest2","rate_type2","credit_card_dept","late_payment","cashout","foreclosure",
    "Bankrupcy","employement_status"
];

if (isset($_POST['upload']) && isset($_FILES['csv'])) {
    $tmp = $_FILES['csv']['tmp_name'];
    $name = $_FILES['csv']['name'];

    // Check if file name already uploaded
    $check = $mysqli->prepare('SELECT id FROM csv_upload_log WHERE file_name = ?');
    $check->bind_param('s', $name);
    $check->execute();
    $res_check = $check->get_result();

    if ($res_check->num_rows > 0) {
        $messages[] = 'Error: A file with this name has already been uploaded.';
    } elseif (strtolower(pathinfo($name, PATHINFO_EXTENSION)) !== 'csv') {
        $messages[] = 'Upload file must be a CSV.';
    } else {
        if (($handle = fopen($tmp, 'r')) !== false) {

            $header = fgetcsv($handle);
            if (!$header) {
                $messages[] = 'CSV appears empty.';
            } else {
                $lower = array_map('strtolower', $header);
                $contactIndex = array_search('contact_number', $lower);

                if ($contactIndex === false) {
                    $messages[] = 'CSV missing required column: contact_number';
                } else {
                    while (($row = fgetcsv($handle)) !== false) {
                        if (count(array_filter($row)) === 0) continue; // skip empty row

                        $values = [];
                        foreach ($cols as $col) {
                            $pos = array_search(strtolower($col), $lower);
                            $values[] = ($pos !== false && isset($row[$pos])) ? trim($row[$pos]) : null;
                        }

                        list(
                            $contact_number,
                            $first_name,
                            $last_name,
                            $phone,
                            $phone2,
                            $client,
                            $loan_officer,
                            $Address,
                            $Zip,
                            $State,
                            $City,
                            $Address2,
                            $zip2,
                            $State2,
                            $City2,
                            $total_loan,
                            $interest_rate,
                            $rate_type,
                            $Loan_type,
                            $house_type,
                            $property_usage,
                            $interest2,
                            $rate_type2,
                            $credit_card_dept,
                            $late_payment,
                            $cashout,
                            $foreclosure,
                            $Bankrupcy,
                            $employement_status
                        ) = $values;

                        // Skip row if contact_number is missing
                        if (empty($contact_number)) {
                            $skipped++;
                            continue;
                        }

                        // Ensure numeric values
                        $total_loan = is_numeric($total_loan) ? $total_loan : 0;
                        $interest_rate = is_numeric($interest_rate) ? $interest_rate : 0;
                        $interest2 = is_numeric($interest2) ? $interest2 : 0;
                        $late_payment = is_numeric($late_payment) ? $late_payment : 0;
                        $cashout = is_numeric($cashout) ? $cashout : 0;
                        $foreclosure = is_numeric($foreclosure) ? $foreclosure : 0;
                        $Bankrupcy = is_numeric($Bankrupcy) ? $Bankrupcy : 0;

                        $ins = $mysqli->prepare("
                            INSERT INTO file_data (
                                contact_number, first_name, last_name, phone, phone2,
                                client, loan_officer, Address, Zip, State, City,
                                Address2, zip2, State2, City2,
                                total_loan, interest_rate, rate_type, Loan_type, house_type,
                                property_usage, interest2, rate_type2, credit_card_dept,
                                late_payment, cashout, foreclosure, Bankrupcy, employement_status
                            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
                        ");

                        $ins->bind_param(
                            'sssssssssssssssddssssddddddds',
                            $contact_number,
                            $first_name,
                            $last_name,
                            $phone,
                            $phone2,
                            $client,
                            $loan_officer,
                            $Address,
                            $Zip,
                            $State,
                            $City,
                            $Address2,
                            $zip2,
                            $State2,
                            $City2,
                            $total_loan,
                            $interest_rate,
                            $rate_type,
                            $Loan_type,
                            $house_type,
                            $property_usage,
                            $interest2,
                            $rate_type2,
                            $credit_card_dept,
                            $late_payment,
                            $cashout,
                            $foreclosure,
                            $Bankrupcy,
                            $employement_status
                        );

                        $ins->execute() ? $inserted++ : $skipped++;
                    }
                }

                fclose($handle);

                // Log upload
                $log = $mysqli->prepare('INSERT INTO csv_upload_log (file_name, uploaded_by, inserted_rows, skipped_rows) VALUES (?,?,?,?)');
                $log->bind_param('siii', $name, $_SESSION['user_id'], $inserted, $skipped);
                $log->execute();

                $messages[] = "Upload complete. Inserted: $inserted, Skipped: $skipped";
            }
        } else {
            $messages[] = 'Unable to open uploaded file.';
        }
    }
}
?>

<div class="card card2" style="margin-left: 30%; width: fit-content;">
    <h2>CSV Upload</h2>
    <?php foreach($messages as $m) echo '<div class="alert">'.htmlspecialchars($m).'</div>'; ?>
    <form method="post" enctype="multipart/form-data" class="form">
        <label>Upload CSV</label>
        <input type="file" name="csv" accept=".csv" required>
        <div class="form-actions"><button type="submit" name="upload" class="btn">Upload</button></div>
    </form>
</div>

<div class="card card2" style="margin-left: 17%; width:fit-content">
    <h2>Uploaded Files</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>File Name</th>
                <th>Inserted Rows</th>
                <th>Skipped Rows</th>
                <th>Uploaded By</th>
                <th>Uploaded At</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $log_res = $mysqli->query("
                SELECT l.*, u.username 
                FROM csv_upload_log l 
                JOIN tbl_users u ON u.id = l.uploaded_by
                ORDER BY l.uploaded_at DESC
            ");
            if ($log_res->num_rows > 0) {
                while ($row = $log_res->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>" . htmlspecialchars($row['file_name']) . "</td>
                        <td>{$row['inserted_rows']}</td>
                        <td>{$row['skipped_rows']}</td>
                        <td>" . htmlspecialchars($row['username']) . "</td>
                        <td>{$row['uploaded_at']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No uploads yet.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
