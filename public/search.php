<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_role([4]); 
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header.php';

$message = '';
$search_result = null;

/* ------------------------------
   SEARCH BY CONTACT NUMBER ONLY
--------------------------------*/
if (isset($_POST['search_number'])) {

    $contact_number = trim($_POST['contact_number']);

    // Check if lead already exists
    $stmt = $mysqli->prepare("
        SELECT ld.contact_number, ld.first_name, ld.last_name, ld.phone,
               ld.phone2, ld.client, ld.sale_date, ld.comments, ldisp.disposition
        FROM lead_data ld
        JOIN lead_disposition ldisp ON ld.id = ldisp.lead_id
        WHERE ld.contact_number = ?
    ");
    $stmt->bind_param("s", $contact_number);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $search_result = $res->fetch_assoc();
    } else {

        // Check in file_data
        $stmt = $mysqli->prepare("
            SELECT contact_number, first_name, last_name, phone, phone2,
                   client, loan_officer,
                   Address, Zip, State, City,
                   Address2, zip2, State2, City2,
                   total_loan, interest_rate, rate_type, Loan_type,
                   house_type, property_usage, interest2, rate_type2,
                   credit_card_dept, late_payment, cashout, foreclosure,
                   Bankrupcy, employement_status
            FROM file_data
            WHERE contact_number = ?
        ");
        $stmt->bind_param("s", $contact_number);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $search_result = $res->fetch_assoc();
        } else {
            $message = "No record found for this number.";
        }
    }
}

/* ------------------------------
   SUBMIT NEW LEAD
--------------------------------*/
if (isset($_POST['submit_lead'])) {
    $csr_id = $_SESSION['user_id'] ?? 0;

    // Sanitize input
    $contact_number = trim($_POST['contact_number'] ?? '');
    $first_name     = trim($_POST['first_name'] ?? '');
    $last_name      = trim($_POST['last_name'] ?? '');
    $phone          = trim($_POST['phone'] ?? '');
    $phone2         = trim($_POST['phone2'] ?? '');
    $client         = trim($_POST['client'] ?? '');
    $loan_officer   = trim($_POST['loan_officer'] ?? '');
    $address        = trim($_POST['Address'] ?? '');
    $zip            = trim($_POST['Zip'] ?? '');
    $state          = trim($_POST['State'] ?? '');
    $city           = trim($_POST['City'] ?? '');
    $address2       = trim($_POST['Address2'] ?? '');
    $zip2           = trim($_POST['zip2'] ?? '');
    $state2         = trim($_POST['State2'] ?? '');
    $city2          = trim($_POST['City2'] ?? '');
    $total_loan     = $_POST['total_loan'] !== '' ? (float)$_POST['total_loan'] : null;
    $interest_rate  = $_POST['interest_rate'] !== '' ? (float)$_POST['interest_rate'] : null;
    $interest2      = $_POST['interest2'] !== '' ? (float)$_POST['interest2'] : null;
    $rate_type      = trim($_POST['rate_type'] ?? '');
    $rate_type2     = trim($_POST['rate_type2'] ?? '');
    $loan_type      = trim($_POST['loan_type'] ?? '');
    $house_type     = trim($_POST['house_type'] ?? '');
    $property_usage = trim($_POST['property_usage'] ?? '');
    $credit_card_dept = trim($_POST['credit_card_dept'] ?? '');
    $late_payment   = trim($_POST['late_payment'] ?? '');
    $cashout        = trim($_POST['cashout'] ?? '');
    $foreclosure    = trim($_POST['foreclosure'] ?? '');
    $bankrupcy      = trim($_POST['Bankrupcy'] ?? '');
    $employement_status = trim($_POST['employement_status'] ?? '');
    $comments       = trim($_POST['comments'] ?? '');
    $disposition    = trim($_POST['disposition'] ?? '');

    // Validation
    if (!$contact_number || !$client || !$loan_officer || !$disposition) {
        $message = "Contact number, client, loan officer, and disposition are required.";
    } else {
        // Check duplicates
        $check = $mysqli->prepare("SELECT id FROM lead_data WHERE contact_number=?");
        $check->bind_param("s", $contact_number);
        $check->execute();
        $exists = $check->get_result()->fetch_assoc();
        $check->close();

        if ($exists) {
            $message = "Lead already exists.";
        } else {
            // Insert lead_data
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

            $stmt->bind_param(
                "ssssssssssssssddssssddssssssi",
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

                $message = "Lead successfully submitted.";
            } else {
                $message = "Error submitting lead: " . $stmt->error;
            }
        }
    }
}

?>

<link rel="stylesheet" href="/lead_portal/public/assets/css/lead_list/search-form.css">

<div style="justify-items: center;" class="container">
    <h2>Lead Search (CSR)</h2>
    <?php if (!empty($message)): ?>
        <div class="alert"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST" class="search-form">
        <input type="text" name="contact_number" placeholder="Enter Contact Number" required>
        <button type="submit" name="search_number">Search</button>
    </form>

    <?php if (!empty($search_result)): ?>
        <?php if (isset($search_result['disposition'])): ?>
            <div class="card">
                <h3>Lead Already Submitted</h3>
                <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($search_result['contact_number']); ?></p>
                <p><strong>Disposition:</strong> <?php echo htmlspecialchars($search_result['disposition']); ?></p>
                <p><strong>Sale Date:</strong> <?php echo htmlspecialchars($search_result['sale_date']); ?></p>
            </div>

        <?php else: ?>

            <form method="POST" class="lead-form" action="lead_submit.php">
                <input type="hidden" name="contact_number" value="<?php echo htmlspecialchars($search_result['contact_number']); ?>">

                <div class="lead-div">

                    <div class="personal-info">
                        <h2 class="form-heading">Personal Info</h2>

                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name" value="<?php echo htmlspecialchars($search_result['first_name'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name" value="<?php echo htmlspecialchars($search_result['last_name'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" value="<?php echo htmlspecialchars($search_result['phone'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Phone 2</label>
                            <input type="text" name="phone2" value="<?php echo htmlspecialchars($search_result['phone2'] ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="Address" value="<?php echo htmlspecialchars($search_result['Address'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Zip</label>
                            <input type="text" name="Zip" value="<?php echo htmlspecialchars($search_result['Zip'] ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label>State</label>
                            <input type="text" name="State" value="<?php echo htmlspecialchars($search_result['State'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="City" value="<?php echo htmlspecialchars($search_result['City'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Address 2</label>
                            <input type="text" name="Address2" value="<?php echo htmlspecialchars($search_result['Address2'] ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label>Zip 2</label>
                            <input type="text" name="zip2" value="<?php echo htmlspecialchars($search_result['zip2'] ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label>State 2</label>
                            <input type="text" name="State2" value="<?php echo htmlspecialchars($search_result['State2'] ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label>City 2</label>
                            <input type="text" name="City2" value="<?php echo htmlspecialchars($search_result['City2'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="financial-issue">
                        <h2 class="form-heading">Financial Info</h2>

                        <div class="form-group">
                            <label>Total Loan</label>
                            <input type="number" name="total_loan" value="<?php echo htmlspecialchars($search_result['total_loan'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Interest Rate 1</label>
                            <input type="number" step="0.01" name="interest_rate" value="<?php echo htmlspecialchars($search_result['interest_rate'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Rate Type 1</label>
                            <select name="rate_type">
                                <option value="<?php echo htmlspecialchars($search_result['rate_type'] ?? ''); ?>">
                                    <?php echo htmlspecialchars($search_result['rate_type'] ?? 'Select'); ?>
                                </option>
                                <option value="Fixed">Fixed</option>
                                <option value="Variable">Variable</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Interest Rate 2</label>
                            <input type="number" step="0.01" name="interest2" value="<?php echo htmlspecialchars($search_result['interest2'] ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label>Rate Type 2</label>
                            <select name="rate_type2">
                                <option value="<?php echo htmlspecialchars($search_result['rate_type2'] ?? ''); ?>">
                                    <?php echo htmlspecialchars($search_result['rate_type2'] ?? 'Select'); ?>
                                </option>
                                <option value="Fixed">Fixed</option>
                                <option value="Variable">Variable</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Loan Type</label>
                            <select name="loan_type">
                                <option value="<?php echo htmlspecialchars($search_result['Loan_type'] ?? ''); ?>">
                                    <?php echo htmlspecialchars($search_result['Loan_type'] ?? 'Select'); ?>
                                </option>
                                <option value="Auto">Auto</option>
                                <option value="Student">Student</option>
                                <option value="Mortgage">Mortgage</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>House Type</label>
                            <select name="house_type">
                                <option value="<?php echo htmlspecialchars($search_result['house_type'] ?? ''); ?>">
                                    <?php echo htmlspecialchars($search_result['house_type'] ?? 'Select'); ?>
                                </option>
                                <option value="Single">Single</option>
                                <option value="Joint">Joint</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Property Usage</label>
                            <select name="property_usage">
                                <option value="<?php echo htmlspecialchars($search_result['property_usage'] ?? ''); ?>">
                                    <?php echo htmlspecialchars($search_result['property_usage'] ?? 'Select'); ?>
                                </option>
                                <option value="Primary Usage">Primary Usage</option>
                                <option value="Secondary Usage">Secondary Usage</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Credit Card Dept</label>
                            <input type="text" name="credit_card_dept" value="<?php echo htmlspecialchars($search_result['credit_card_dept'] ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label>Late Payment</label>
                            <input type="text" name="late_payment" value="<?php echo htmlspecialchars($search_result['late_payment'] ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label>Cashout</label>
                            <input type="text" name="cashout" value="<?php echo htmlspecialchars($search_result['cashout'] ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label>Foreclosure</label>
                            <input type="text" name="foreclosure" value="<?php echo htmlspecialchars($search_result['foreclosure'] ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label>Bankrupcy</label>
                            <input type="text" name="Bankrupcy" value="<?php echo htmlspecialchars($search_result['Bankrupcy'] ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label>Employment Status</label>
                            <select name="employement_status">
                                <option value="<?php echo htmlspecialchars($search_result['employement_status'] ?? ''); ?>">
                                    <?php echo htmlspecialchars($search_result['employement_status'] ?? 'Select'); ?>
                                </option>
                                <option value="Employed">Employed</option>
                                <option value="Unemployed">Unemployed</option>
                            </select>
                        </div>
                    </div>

                    <div class="client">
                        <h2 class="form-heading">Client Info</h2>

                        <div class="form-group">
                            <label>Client</label>
                            <input type="text" name="client" value="<?php echo htmlspecialchars($search_result['client'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Loan Officer</label>
                            <input type="text" name="loan_officer" value="<?php echo htmlspecialchars($search_result['loan_officer'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Comments</label>
                            <textarea name="comments" rows="3"><?php echo htmlspecialchars($search_result['comments'] ?? ''); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Disposition</label>
                            <select name="disposition" required>
                                <option value="">-- Select Disposition --</option>
                                <option value="Live Transfer">Live Transfer</option>
                                <option value="DNC">DNC</option>
                                <option value="Pending">Pending</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>
                    </div>

                </div>

                <button type="submit" name="submit_lead">Submit Lead</button>
            </form>

        <?php endif; ?>
    <?php endif; ?>
</div>
