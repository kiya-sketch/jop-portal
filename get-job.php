<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$servername = "localhost";
$username   = "root";
$password   = "12345678";
$dbname     = "my-website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit();
}

$sql = "SELECT jobs.*, categories.name AS category_name 
        FROM jobs 
        JOIN categories ON jobs.category_id = categories.id 
        ORDER BY jobs.id DESC";

$result = $conn->query($sql);
$jobs = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $jobs[] = $row;
    }
    echo json_encode(["status" => "success", "data" => $jobs]);
} else {
    echo json_encode(["status" => "success", "data" => []]);
}

$conn->close();
?>
