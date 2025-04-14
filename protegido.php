<?php
require_once 'funcoes.php';
require_once 'dados.php';
include 'header.php';

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: login.php');
    exit;
}

$mensagem = '';
$mensagem_tipo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['titulo']) && !empty($_POST['titulo']) &&
        isset($_POST['descricao']) && !empty($_POST['descricao']) &&
        isset($_POST['categorias']) && !empty($_POST['categorias']) &&
        isset($_POST['desenvolvedora']) && !empty($_POST['desenvolvedora']) &&
        isset($_POST['ano']) && !empty($_POST['ano']) &&
        isset($_POST['imagem']) && !empty($_POST['imagem'])
    ) {
        $categorias = explode(',', $_POST['categorias']);
        $categorias = array_map('trim', $categorias);
        
        $max_id = 0;
        foreach ($jogos as $jogo) {
            if ($jogo['id'] > $max_id) {
                $max_id = $jogo['id'];
            }
        }
        
        if (isset($_SESSION['novos_jogos']) && is_array($_SESSION['novos_jogos'])) {
            foreach ($_SESSION['novos_jogos'] as $jogo) {
                if ($jogo['id'] > $max_id) {
                    $max_id = $jogo['id'];
                }
            }
        }
        
        $novo_id = $max_id + 1;
        
        $novo_jogo = [
            'id' => $novo_id,
            'titulo' => $_POST['titulo'],
            'categorias' => $categorias,
            'desenvolvedora' => $_POST['desenvolvedora'],
            'ano' => (int)$_POST['ano'],
            'descricao' => $_POST['descricao'],
            'imagem' => $_POST['imagem']
        ];
        
        if (!isset($_SESSION['novos_jogos']) || !is_array($_SESSION['novos_jogos'])) {
            $_SESSION['novos_jogos'] = [];
        }
        
        $_SESSION['novos_jogos'][] = $novo_jogo;
        
        $mensagem = 'Jogo cadastrado com sucesso!';
        $mensagem_tipo = 'success';
    } else {
        $mensagem = 'Por favor, preencha todos os campos do formulário.';
        $mensagem_tipo = 'danger';
    }
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="mb-4">Área Restrita - Cadastro de Jogos</h1>
        
        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-<?php echo $mensagem_tipo; ?> alert-dismissible fade show" role="alert">
                <?php echo $mensagem; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <div class="card bg-dark mb-4">
            <div class="card-header">
                <h4>Cadastrar Novo Jogo</h4>
            </div>
            <div class="card-body">
                <form action="protegido.php" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="titulo" class="form-label">Título do Jogo:</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="desenvolvedora" class="form-label">Desenvolvedora:</label>
                            <input type="text" class="form-control" id="desenvolvedora" name="desenvolvedora" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="categorias" class="form-label">Categorias (separadas por vírgula):</label>
                            <input type="text" class="form-control" id="categorias" name="categorias" placeholder="Ex: RPG, Ação, Aventura" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="ano" class="form-label">Ano de Lançamento:</label>
                            <input type="number" class="form-control" id="ano" name="ano" min="1970" max="2025" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="imagem" class="form-label">URL da Imagem:</label>
                        <input type="text" class="form-control" id="imagem" name="imagem" placeholder="https://exemplo.com/imagem.jpg" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição:</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="5" required></textarea>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Cadastrar Jogo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h3 class="mb-3">Jogos Cadastrados por Você</h3>
        
        <?php if (isset($_SESSION['novos_jogos']) && is_array($_SESSION['novos_jogos']) && !empty($_SESSION['novos_jogos'])): ?>
            <div class="row">
                <?php foreach ($_SESSION['novos_jogos'] as $jogo): ?>
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
                                
                                <a href="detalhes.php?id=<?php echo $jogo['id']; ?>" class="btn btn-primary">Ver mais</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                Você ainda não cadastrou nenhum jogo.
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>

<style>
    body, .card-body, .form-label, .btn, .alert, a, .badge, .card-title, .card-text {
        color: white !important;
    }

    .btn-primary {
        color: white;
    }
</style>