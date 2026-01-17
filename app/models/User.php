<?php
class User {
    public static function authenticate($login, $password) {
        $db = Database::getConnection();
        
        $stmt = $db->prepare("SELECT * FROM utilisateurs WHERE login = ? AND statut = 'actif'");
        $stmt->execute([$login]);
        $user = $stmt->fetch();

        if ($user) {
            // Dans votre dump, les mots de passe sont hachés avec password_hash
            if (password_verify($password, $user['password'])) {
                return $user;
            }
            
            // TEST UNIQUEMENT : Si vous avez des mots de passe en clair (ex: 1234)
            if ($password === $user['password']) {
                return $user;
            }
        }
        return false;
    }
}