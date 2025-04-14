<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['novos_jogos']) && is_array($_SESSION['novos_jogos'])) {
    require_once 'dados.php';
    $jogos = array_merge($jogos, $_SESSION['novos_jogos']);
}

?>
<?php
if (isset($_GET['busca']) && !empty(trim($_GET['busca']))) {
    $termoBusca = strtolower(trim($_GET['busca']));
    
    $jogos = array_filter($jogos, function($jogo) use ($termoBusca) {
        $titulo = strtolower($jogo['titulo']);
        $categorias = array_map('strtolower', $jogo['categorias']);
        
        return strpos($titulo, $termoBusca) !== false || in_array($termoBusca, $categorias);
    });
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Jogos Favoritos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background-color: #1e1e1e !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }
        
        .card {
            background-color: #2d2d2d;
            border: none;
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 20px;
            height: 100%;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }
        
        .card-title {
            color: #fff;
            font-weight: 600;
        }
        
        .card-text {
            color: #adb5bd;
        }
        
        .btn-primary {
            background-color: #6c5ce7;
            border: none;
            transition: background-color 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #5649c0;
        }
        
        .badge {
            margin-right: 5px;
            transition: transform 0.2s;
            cursor: pointer;
        }
        
        .badge:hover {
            transform: scale(1.1);
        }
        
        footer {
            background-color: #1e1e1e;
            padding: 20px 0;
            margin-top: 30px;
        }
        
        .jogo-img {
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        
        .form-control, .form-select {
            background-color: #333;
            border: 1px solid #444;
            color: #fff;
        }
        
        .form-control:focus, .form-select:focus {
            background-color: #3a3a3a;
            color: #fff;
            border-color: #6c5ce7;
            box-shadow: 0 0 0 0.25rem rgba(108, 92, 231, 0.25);
        }
        
        .categoria-badge {
            background-color: #6c5ce7;
        }
        
        .desenvolvedora-badge {
            background-color: #e74c3c;
        }
        
        .ano-badge {
            background-color: #2ecc71;
        }
        html, body {
    min-height: 100vh;
    margin: 0;
    display: flex;
    flex-direction: column;
}

.container {
    flex: 1;
}

footer {
    background-color: #1e1e1e;
    padding: 20px 0;
    width: 100%;
    margin-top: auto;
}
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">Catálogo de Jogos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="filtrar.php">Filtrar</a>
                    </li>
                    <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="protegido.php">Área Restrita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Sair</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <?php endif; ?>
                </ul>
                <form class="d-flex" action="index.php" method="GET">
                    <input class="form-control me-2" type="search" placeholder="Buscar jogos..." name="busca" aria-label="Search">
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </form>
            </div>
        </div>
    </nav>
    
    <div class="container">