<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userForm = $_POST["usuario"];
    $passForm = $_POST["password"];
    $archivo = __DIR__ . "/../data.json"; 

    if (file_exists($archivo)) {
        $usuarios = json_decode(file_get_contents($archivo), true) ?? [];

        foreach ($usuarios as $usuario) {
            if (($usuario["nombre"] === $userForm || $usuario["email"] === $userForm) && 
                password_verify($passForm, $usuario["password"])) {
                
                $_SESSION["usuario_logueado"] = $usuario["nombre"];
                $_SESSION["rol"] = $usuario["rol"] ?? "usuario";

                if ($_SESSION["rol"] === "admin" || $_SESSION["rol"] === "Administrador") {
                    header("Location: /index_ajax.html");
                } else {
                    header("Location: /index.php");
                }
                exit;
            }
        }
    }
    echo "<p style='color:red'>Usuario o contraseña incorrectos.</p>";
}
?>

<form method="POST">
    <label>Usuario o Email:</label>
    <input type="text" name="usuario" required>
    <br><br>
    <label>Contraseña:</label>
    <input type="password" name="password" required>
    <br><br>
    <button type="submit">Entrar</button>
</form>