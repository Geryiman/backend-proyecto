<?php
include 'db_config.php';

header('Content-Type: application/json');

$sql = "SELECT id, departure, destination, date, time, seats_available FROM trips ORDER BY date, time";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $trips = [];
    while ($row = $result->fetch_assoc()) {
        $trips[] = $row;
    }
    echo json_encode($trips);
} else {
    echo json_encode([]);
}

$conn->close();
?>
