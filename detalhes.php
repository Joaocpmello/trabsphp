<?php
require_once 'funcoes.php';
require_once 'dados.php';
include 'header.php';

if (isset($_GET['id'])) {
    $id_jogo = $_GET['id'];
    $jogo_encontrado = null;
    foreach ($jogos as $jogo) {
        if ($jogo['id'] == $id_jogo) {
            $jogo_encontrado = $jogo;
            break;
        }
    }
    if (!$jogo_encontrado) {
        header('Location: catalogo.php');
        exit;
    }
} else {
    header('Location: catalogo.php');
    exit;
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="mb-4">Detalhes do Jogo</h1>

        <div class="card bg-dark mb-4">
            <div class="card-header">
                <h4><?php echo htmlspecialchars($jogo_encontrado['titulo']); ?></h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <img src="<?php echo $jogo_encontrado['imagem']; ?>" class="img-fluid" alt="<?php echo htmlspecialchars($jogo_encontrado['titulo']); ?>">
                    </div>
                    <div class="col-md-8 mb-3">
                        <h5>Descrição:</h5>
                        <textarea class="form-control" id="descricao" rows="5" readonly><?php echo htmlspecialchars($jogo_encontrado['descricao']); ?></textarea>
                    </div>
                </div>

                <h5>Categorias:</h5>
                <div class="mb-3">
                    <?php foreach ($jogo_encontrado['categorias'] as $categoria): ?>
                        <span class="badge bg-primary categoria-badge"><?php echo htmlspecialchars($categoria); ?></span>
                    <?php endforeach; ?>
                </div>

                <div class="mb-3">
                    <span class="badge bg-danger desenvolvedora-badge"><?php echo htmlspecialchars($jogo_encontrado['desenvolvedora']); ?></span>
                    <span class="badge bg-success ano-badge"><?php echo $jogo_encontrado['ano']; ?></span>
                </div>

                <a href="catalogo.php" class="btn btn-primary">Voltar ao Catálogo</a>
            </div>
        </div>
    </div>
</div>

<style>
    #descricao {
        resize: vertical;
        overflow-y: auto;
    }
</style>

<?php include 'footer.php'; ?>
