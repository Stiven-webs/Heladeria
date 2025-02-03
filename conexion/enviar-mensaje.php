<?php
// Incluir la conexión
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si los campos 'email' y 'mensaje' fueron enviados
    if (isset($_POST['email']) && isset($_POST['mensaje'])) {
        // Capturar los datos del formulario
        $email = $_POST['email'];
        $mensaje = $_POST['mensaje'];

        // Escapar los datos para evitar inyecciones SQL
        $email = htmlspecialchars($email);
        $mensaje = htmlspecialchars($mensaje);

        try {
            // Preparar la consulta SQL para insertar los datos
            $sql = "INSERT INTO mensajes (email, mensaje) VALUES (:email, :mensaje)";
            $stmt = $db->prepare($sql);
            
            // Asignar los valores a los parámetros
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':mensaje', $mensaje);

            // Ejecutar la consulta
            $stmt->execute();

            // Mostrar la mini tarjeta con el mensaje de éxito
            echo '
                <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
                    <div style="background-color: #4CAF50; color: white; padding: 20px; border-radius: 8px; width: 300px; text-align: center;">
                        <h3>Datos enviados con éxito</h3>
                        <button onclick="window.location.href=\'../index.html\'" style="background-color: white; color: #4CAF50; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">Aceptar</button>
                    </div>
                </div>
            ';
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
