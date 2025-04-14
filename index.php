<?php
require_once 'funcoes.php';
require_once 'dados.php';
include 'header.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Jogos</title>
    
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="row">
        <?php foreach ($jogos as $jogo): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?php echo $jogo['imagem']; ?>" class="card-img-top jogo-img" alt="<?php echo htmlspecialchars($jogo['titulo']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($jogo['titulo']); ?></h5>
                        <p class="card-text"><?php echo limitarTexto($jogo['descricao'], 100); ?></p>

                        <div class="mb-3">
                            <?php foreach ($jogo['categorias'] as $categoria): ?>
                                <span class="badge bg-primary categoria-badge">
                                    <?php echo htmlspecialchars($categoria); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>

                        <div class="mb-3">
                            <span class="badge bg-danger desenvolvedora-badge">
                                <?php echo htmlspecialchars($jogo['desenvolvedora']); ?>
                            </span>
                            <span class="badge bg-success ano-badge">
                                <?php echo $jogo['ano']; ?>
                            </span>
                        </div>

                        <label for="modal<?php echo $jogo['id']; ?>" class="btn btn-primary">Ver mais</label>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php foreach ($jogos as $jogo): ?>
        <input type="checkbox" id="modal<?php echo $jogo['id']; ?>" class="modal-toggle">
        <div class="modal">
            <div class="modal-content">
                <label for="modal<?php echo $jogo['id']; ?>" class="close">&times;</label>
                <h5><?php echo htmlspecialchars($jogo['titulo']); ?></h5>
                <a href="detalhes.php?id=<?php echo $jogo['id']; ?>"><img src="<?php echo $jogo['imagem']; ?>" class="img-fluid mb-3" alt="<?php echo htmlspecialchars($jogo['titulo']); ?>"></a>
                <p><strong>Descrição:</strong> <?php echo htmlspecialchars($jogo['descricao']); ?></p>
                <p><strong>Desenvolvedora:</strong> <?php echo htmlspecialchars($jogo['desenvolvedora']); ?></p>
                <p><strong>Ano de Lançamento:</strong> <?php echo $jogo['ano']; ?></p>
                <p><strong>Categorias:</strong> 
                    <?php foreach ($jogo['categorias'] as $categoria): ?>
                        <span class="badge bg-primary"><?php echo htmlspecialchars($categoria); ?></span>
                    <?php endforeach; ?>
                </p>
            </div>
        </div>
    <?php endforeach; ?>

    <?php include 'footer.php'; ?>
</body>
</html>