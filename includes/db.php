<?php
$DB_HOST = 'localhost';
$DB_NAME = 'lead_portal';
$DB_USER = 'root';
$DB_PASS = '';
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) 
{
die('DB connection failed: ' . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');
function esc($s)
{
global $mysqli;
return htmlspecialchars($mysqli->real_escape_string($s));
}