<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['search'])) {
    $result = getSearchResult($_POST['search'], $pdo);
    header('Content-Type: application/json');

    echo json_encode($result);
}
