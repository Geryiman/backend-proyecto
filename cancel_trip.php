<?php
include 'db_config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trip_id = $_POST['trip_id'];

    $sql = "DELETE FROM trips WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $trip_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Viaje cancelado exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al cancelar el viaje."]);
    }

    $stmt->close();
    $conn->close();
}
?>
