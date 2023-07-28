<?php 
    require_once "./helpers/url.php";
    // From url.php = const BASE_URL
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
    <!-- Boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= BASE_URL ?>../css/styles.css">
</head>
<body>
    <!-- header -->
    <div class="container">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <img src="<?= BASE_URL ?>/img/book.svg" alt="book icon" class="pe-2">
            <span class="fs-4 pe-3">Agenda</span>
            </a>

            <ul class="nav nav-pills">
            <li class="nav-item"><a href="./index.php" class="nav-link active" aria-current="page">Home</a></li>
            <li class="nav-item"><a href="<?= BASE_URL ?>/create.php" class="nav-link">Adicionar</a></li>
            </ul>
        </header>
    </div>