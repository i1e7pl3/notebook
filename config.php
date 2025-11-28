<?php
$db_file = 'contacts.db';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=mospol_olga', 'mospol_olga', 'OY5oXok4!o}D9P(m');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS contacts (
        id INTEGER PRIMARY KEY AUTO_INCREMENT,
        surname TEXT NOT NULL,
        name TEXT NOT NULL,
        patronymic TEXT,
        gender TEXT,
        date_of_birth DATE,
        phone TEXT,
        address TEXT,
        email TEXT,
        comment TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
} catch(PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
?>

