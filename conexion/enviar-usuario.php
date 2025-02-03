<?php
// Incluir la conexión a la base de datos
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si los campos han sido enviados
    if (isset($_POST['fullname'], $_POST['email'], $_POST['password'], $_POST['confirm-password'])) {
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm-password'];

        // Verificar si las contraseñas coinciden
        if ($password !== $confirm_password) {
            echo "Las contraseñas no coinciden.";
            exit;
        }

        // Encriptar la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Preparar la consulta SQL para insertar los datos
            $sql = "INSERT INTO usuarios (fullname, email, password) VALUES (:fullname, :email, :password)";
            $stmt = $db->prepare($sql);

            // Asignar los valores a los parámetros
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);

            // Ejecutar la consulta
            $stmt->execute();

            // Mostrar la tarjeta de éxito después de enviar el formulario
            echo "
            <div style='display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f4f4f4;'>
                <div style='background-color: #4CAF50; color: white; padding: 20px; border-radius: 8px; width: 300px; text-align: center; 
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); transform: translateY(-10px); transition: transform 0.3s ease, box-shadow 0.3s ease;'>
                    <h3>Datos enviados con éxito</h3>
                    <button onclick='window.location.href=\"../login.html\"' style='background-color: white; color: #4CAF50; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;'>
                        Aceptar
                    </button>
                </div>
            </div>";

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Por favor, rellena todos los campos.";
    }
}

// Cerrar la conexión
$db = null;
?>
