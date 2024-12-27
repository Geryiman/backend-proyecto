<?php
include 'db_config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];

    $sql = "UPDATE notifications SET is_read = TRUE WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Notificaciones marcadas como leídas."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar notificaciones."]);
    }

    $stmt->close();
    $conn->close();
}
?>
