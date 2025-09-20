<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Database.php';

class LoginController extends Controller {
    public function index() {
    include __DIR__ . '/../views/login.php';
    }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $db = new Database();
            $conn = $db->getConnection();
            $stmt = $conn->prepare('SELECT * FROM user WHERE nombres = :username');
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($password, $user['contrasena'])) {
                session_start();
                $_SESSION['user'] = $user;
                header('Location: /raci/?url=LoginController/dashboard');
                exit;
            } else {
                $error = 'Usuario o contraseña incorrectos';
                include __DIR__ . '/../views/login.php';
            }
        }
    }
    public function dashboard() {
        include __DIR__ . '/../views/dashboard.php';
    }
}
