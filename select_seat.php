<?php
include 'db_config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trip_id = $_POST['trip_id'];
    $seat_number = $_POST['seat_number'];

    // Verificar si el asiento ya está ocupado
    $sql = "SELECT seats_occupied FROM trips WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $trip_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $trip = $result->fetch_assoc();
        $occupied = explode(',', $trip['seats_occupied']);

        if (in_array($seat_number, $occupied)) {
            echo json_encode(["success" => false, "message" => "El asiento ya está ocupado."]);
            exit();
        }

        // Agregar el asiento a la lista de ocupados
        $occupied[] = $seat_number;
        $new_occupied = implode(',', $occupied);

        $update_sql = "UPDATE trips SET seats_occupied = ?, seats_available = seats_available - 1 WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $new_occupied, $trip_id);

        if ($update_stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Asiento reservado con éxito."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al reservar el asiento."]);
        }

        $update_stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Viaje no encontrado."]);
    }

    $stmt->close();
    $conn->close();
}
?>
