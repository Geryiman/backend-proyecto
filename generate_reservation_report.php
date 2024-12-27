<?php
include 'db_config.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="reservation_report.csv"');

$output = fopen('php://output', 'w');

// Encabezados del archivo CSV
fputcsv($output, ['ID Reserva', 'Nombre del Usuario', 'Teléfono', 'Salida', 'Destino', 'Fecha', 'Hora', 'Número de Asiento', 'Estado']);

$sql = "SELECT 
            reservations.id AS reservation_id,
            users.name AS user_name,
            users.phone AS user_phone,
            trips.departure,
            trips.destination,
            trips.date,
            trips.time,
            reservations.seat_number,
            reservations.status
        FROM reservations
        JOIN users ON reservations.user_id = users.id
        JOIN trips ON reservations.trip_id = trips.id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
}

fclose($output);
$conn->close();
?>
