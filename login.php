<?php
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Preparar respuesta inicial
    $response = ["success" => false, "message" => "Usuario no encontrado."];

    // Verificar en tabla de usuarios
    $sql = "SELECT * FROM users WHERE phone = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $response = [
                "success" => true,
                "role" => "user",
                "message" => "Inicio de sesión exitoso como usuario.",
                "name" => $user['name'] // Se añade el nombre del usuario en la respuesta
            ];
        } else {
            $response["message"] = "Contraseña incorrecta.";
        }
    } else {
        // Verificar en tabla de administradores
        $sql = "SELECT * FROM admins WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $phone); // En este caso, el "name" de admin se usa como identificador.
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            if (password_verify($password, $admin['password'])) {
                $response = [
                    "success" => true,
                    "role" => "admin",
                    "message" => "Inicio de sesión exitoso como administrador.",
                    "name" => $admin['name'] // Se añade el nombre del administrador en la respuesta
                ];
            } else {
                $response["message"] = "Contraseña incorrecta.";
            }
        }
    }

    $stmt->close();
    $conn->close();

    // Retornar respuesta como JSON
    echo json_encode($response);
}
?>
