<?php

error_reporting(0);
session_start();
require_once __DIR__ . '/db.php';
function is_logged_in()
{
    return isset($_SESSION['user_id']);
}
function require_login()
{
    if (!is_logged_in())
    {
        header('Location: /index.php');
        exit;
    }
}
function current_user()
{
    if (!is_logged_in()) return null;
    return 
    [
        'id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'access_level' => $_SESSION['access_level']
    ];
}
function require_role($allowed_levels = [])
{
require_login();
    $lvl = $_SESSION['access_level'];
    if (!in_array($lvl, $allowed_levels))
    {
        http_response_code(403);
        echo 'Access denied';
        exit;
    }
}
// function disable_back_button() {
//     header("Cache-Control: no-cache, no-store, must-revalidate"); 
//     header("Pragma: no-cache"); 
//     header("Expires: 0"); 
// }
// function prevent_back_to_login() {
//     if (isset($_SESSION['user_id'])) {
//         header("Location: dashboard.php");
//         exit;
//     }
// }
