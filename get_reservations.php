<?php
include 'db_config.php';

header('Content-Type: application/json');

$user_id = $_GET['user_id']; // Asegúrate de obtener el ID del usuario desde el frontend

$sql = "SELECT 
            reservations.id, 
            reservations.seat_number, 
            reservations.status, 
            trips.departure, 
            trips.destination, 
            trips.date, 
            trips.time 
        FROM reservations 
        JOIN trips ON reservations.trip_id = trips.id 
        WHERE reservations.user_id = ? 
        ORDER BY reservations.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$reservations = [];
while ($row = $result->fetch_assoc()) {
    $reservations[] = $row;
}

echo json_encode($reservations);

$stmt->close();
$conn->close();
?>
