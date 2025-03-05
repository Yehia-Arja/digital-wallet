<?php 
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");
$conn = new mysqli('localhost','root','','digital_wallet');

