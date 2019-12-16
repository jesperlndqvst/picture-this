<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_GET['search'])) {
    $search = filter_var($_GET['search'], FILTER_SANITIZE_STRING);
    $statement = $pdo->prepare('SELECT username FROM users WHERE username LIKE :search');
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $search = '%' . $search . '%';
    $statement->bindParam(':search', $search, PDO::PARAM_STR);
    $statement->execute();
    $searchResults = $statement->fetchAll(PDO::FETCH_ASSOC);

    if(!$searchResults) {
        displayMessage('No users found');
    }
    
    $_SESSION['searchResults'] = $searchResults;

}

redirect('/');
