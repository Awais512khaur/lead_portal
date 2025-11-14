<?php
// header("Cache-Control: no-cache, no-store, must-revalidate"); // Prevent caching
// header("Pragma: no-cache");
// header("Expires: 0");

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
// disable_back_button();
require_once __DIR__ . '/../includes/auth.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: public/index.php");
    exit;
}
// require_login();
$u = current_user();
if ($u['access_level'] == 1) header('Location: add_user');
else if (in_array($u['access_level'], [2,3])) header('Location: upload_csv.php');
else header('Location: search.php');
exit;