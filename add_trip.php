<?php
include 'db_config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $departure = $_POST['departure'];
    $destination = $_POST['destination'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $seats_available = $_POST['seats_available'];

    $sql = "INSERT INTO trips (departure, destination, date, time, seats_available) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $departure, $destination, $date, $time, $seats_available);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Viaje agregado exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al agregar el viaje."]);
    }

    $stmt->close();
    $conn->close();
}
?>

