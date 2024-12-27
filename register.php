<?php
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $photo = 'default.jpg';

    if (!empty($_FILES['photo']['name'])) {
        $photo = uniqid() . '_' . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/" . $photo);
    }

    $sql = "INSERT INTO users (name, phone, password, photo) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $phone, $password, $photo);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Registro exitoso."]);
    } else {
        echo json_encode(["message" => "Error en el registro: " . $conn->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
