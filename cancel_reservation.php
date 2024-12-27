<?php
include 'db_config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_id = $_POST['reservation_id'];

    // Cambiar el estado de la reserva a "Cancelada"
    $sql = "UPDATE reservations SET status = 'Cancelada' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reservation_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Reserva cancelada exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al cancelar la reserva."]);
    }

    $stmt->close();
    $conn->close();
}
?>
