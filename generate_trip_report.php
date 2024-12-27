<?php
include 'db_config.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="trip_report.csv"');

$output = fopen('php://output', 'w');

// Encabezados del archivo CSV
fputcsv($output, ['ID', 'Salida', 'Destino', 'Fecha', 'Hora', 'Asientos Disponibles', 'Asientos Ocupados']);

$sql = "SELECT id, departure, destination, date, time, seats_available, seats_occupied FROM trips";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['seats_occupied'] = $row['seats_occupied'] ?: '0';
        fputcsv($output, $row);
    }
}

fclose($output);
$conn->close();
?>
