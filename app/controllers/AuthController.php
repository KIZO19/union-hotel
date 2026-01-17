<?php
require_once 'app/models/User.php';

class AuthController {
    
    public function login() {
        // Si l'utilisateur est déjà connecté, on l'envoie au dashboard
        if (isset($_SESSION['user'])) {
            header('Location: index.php?action=dashboard');
            exit();
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = User::authenticate($login, $password);

            if ($user) {
                $_SESSION['user'] = $user;
                header('Location: index.php?action=dashboard');
                exit();
            } else {
                $error = "Identifiants incorrects ou compte inactif.";
            }
        }

        // Chargement de la vue de connexion
        require 'app/views/auth/login.php';
    }
}