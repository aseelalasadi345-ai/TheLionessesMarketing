<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name    = $_POST['client_name'];
    $email   = $_POST['client_email'];
    $service = $_POST['service_type'];
    $msg     = $_POST['message'];
    $status  = "Pending";

    $stmt = $conn->prepare("
        INSERT INTO service_requests 
        (client_name, client_email, service_type, message, status, requested_at)
        VALUES (?, ?, ?, ?, ?, NOW())
    ");

    $stmt->bind_param("sssss", $name, $email, $service, $msg, $status);

    if ($stmt->execute()) {
        echo "SUCCESS";
    } else {
        echo "ERROR: " . $stmt->error;
    }
}
?>