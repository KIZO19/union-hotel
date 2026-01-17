<?php
class Database {
    private static $instance = null;
    public static function getConnection() {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO('mysql:host=localhost;dbname=hotel_pro_db;charset=utf8mb4', 'root', '', [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]);
            } catch (Exception $e) { die('Erreur de connexion : ' . $e->getMessage()); }
        }
        return self::$instance;
    }
}
