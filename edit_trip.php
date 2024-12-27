<?php
include 'db_config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trip_id = $_POST['trip_id'];
    $departure = $_POST['departure'];
    $destination = $_POST['destination'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $seats_available = $_POST['seats_available'];

    $sql = "UPDATE trips SET departure = ?, destination = ?, date = ?, time = ?, seats_available = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $departure, $destination, $date, $time, $seats_available, $trip_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Viaje actualizado exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar el viaje."]);
    }

    $stmt->close();
    $conn->close();
}
?>
