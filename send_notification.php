<?php
include 'db_config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $message = $_POST['message'];

    $sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $message);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Notificación enviada."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al enviar la notificación."]);
    }

    $stmt->close();
    $conn->close();
}
?>
 