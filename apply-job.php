<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

$servername = "localhost";
$username   = "root";
$password   = "12345678";
$dbname     = "my-website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit();
}

// ከአፑ የሚላከውን JSON መረጃ መቀበል
$data = json_decode(file_get_contents("php://input"), true);

if (
    !empty($data['job_id']) &&
    !empty($data['applicant_name']) &&
    !empty($data['email']) &&
    !empty($data['phone']) &&
    !empty($data['experience_level'])
) {
    $job_id           = intval($data['job_id']);
    $applicant_name   = $conn->real_escape_string($data['applicant_name']);
    $email            = $conn->real_escape_string($data['email']);
    $phone            = $conn->real_escape_string($data['phone']);
    $experience_level = $conn->real_escape_string($data['experience_level']);

    $sql = "INSERT INTO applications (job_id, applicant_name, email, phone, experience_level) 
            VALUES ('$job_id', '$applicant_name', '$email', '$phone', '$experience_level')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Application submitted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Incomplete data provided"]);
}

$conn->close();
?>
