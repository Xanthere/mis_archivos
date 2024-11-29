<?php
class UsuarioModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function registrarUsuario($nombre, $apellido, $clave, $correo, $fecha_registro) {
        $claveHashed = password_hash($clave, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (Nombre, apellido, clave, correo, fecha_registro, chuchau) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nombre, $apellido, $claveHashed, $correo, $fecha_registro]);
    }

    public function loginUsuario($correo, $clave) {
        $sql = "SELECT * FROM usuarios WHERE correo = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($clave, $usuario['clave'])) {
            return $usuario;
        }
        return false;
    }
}
?>