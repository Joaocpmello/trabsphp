<?php
require_once 'funcoes.php';
require_once 'dados.php';
include 'header.php';

$categorias = obterCategorias($jogos);
$desenvolvedoras = obterDesenvolvedoras($jogos);
$anos = obterAnos($jogos);

$jogos_filtrados = $jogos;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && 
    (isset($_GET['categoria']) || isset($_GET['desenvolvedora']) || isset($_GET['ano']) || isset($_GET['busca']))) {
    
    if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
        $jogos_filtrados = filtrarJogosPorCategoria($jogos_filtrados, $_GET['categoria']);
    }
    
    if (isset($_GET['desenvolvedora']) && !empty($_GET['desenvolvedora'])) {
        $jogos_filtrados = filtrarJogosPorDesenvolvedora($jogos_filtrados, $_GET['desenvolvedora']);
    }
    
    if (isset($_GET['ano']) && !empty($_GET['ano'])) {
        $jogos_filtrados = filtrarJogosPorAno($jogos_filtrados, $_GET['ano']);
    }
    
    if (isset($_GET['busca']) && !empty($_GET['busca'])) {
        $jogos_filtrados = pesquisarJogos($jogos_filtrados, $_GET['busca']);
    }
}
?>

<div class="row">
    <div class="col-lg-3 mb-4">
        <div class="card bg-dark">
            <div class="card-header">
                <h4>Filtrar Jogos</h4>
            </div>
            <div class="card-body">
                <form action="filtrar.php" method="GET">
                    <div class="mb-3">
                        <label for="busca" class="form-label">Busca:</label>
                        <input type="text" class="form-control" id="busca" name="busca" 
                               value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>"
                               placeholder="Digite um termo...">
                    </div>
                    
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoria:</label>
                        <select class="form-select" id="categoria" name="categoria">
                            <option value="">Todas as categorias</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?php echo htmlspecialchars($categoria); ?>" 
                                        <?php echo (isset($_GET['categoria']) && $_GET['categoria'] === $categoria) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($categoria); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="desenvolvedora" class="form-label">Desenvolvedora:</label>
                        <select class="form-select" id="desenvolvedora" name="desenvolvedora">
                            <option value="">Todas as desenvolvedoras</option>
                            <?php foreach ($desenvolvedoras as $desenvolvedora): ?>
                                <option value="<?php echo htmlspecialchars($desenvolvedora); ?>" 
                                        <?php echo (isset($_GET['desenvolvedora']) && $_GET['desenvolvedora'] === $desenvolvedora) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($desenvolvedora); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="ano" class="form-label">Ano:</label>
                        <select class="form-select" id="ano" name="ano">
                            <option value="">Todos os anos</option>
                            <?php foreach ($anos as $ano): ?>
                                <option value="<?php echo $ano; ?>" 
                                        <?php echo (isset($_GET['ano']) && $_GET['ano'] == $ano) ? 'selected' : ''; ?>>
                                    <?php echo $ano; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                        <a href="filtrar.php" class="btn btn-secondary">Limpar Filtros</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-9">
        <h2 class="mb-4">Resultados</h2>
        
        <?php if (empty($jogos_filtrados)): ?>
            <div class="alert alert-warning">
                Nenhum jogo encontrado com os filtros aplicados.
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($jogos_filtrados as $jogo): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <img src="<?php echo $jogo['imagem']; ?>" class="card-img-top jogo-img" alt="<?php echo htmlspecialchars($jogo['titulo']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($jogo['titulo']); ?></h5>
                                <p class="card-text"><?php echo limitarTexto($jogo['descricao'], 100); ?></p>
                                
                                <div class="mb-3">
                                    <?php foreach ($jogo['categorias'] as $categoria): ?>
                                        <a href="filtrar.php?categoria=<?php echo urlencode($categoria); ?>" class="badge bg-primary categoria-badge text-decoration-none">
                                            <?php echo htmlspecialchars($categoria); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                                
                                <div class="mb-3">
                                    <a href="filtrar.php?desenvolvedora=<?php echo urlencode($jogo['desenvolvedora']); ?>" class="badge bg-danger desenvolvedora-badge text-decoration-none">
                                        <?php echo htmlspecialchars($jogo['desenvolvedora']); ?>
                                    </a>
                                    <a href="filtrar.php?ano=<?php echo $jogo['ano']; ?>" class="badge bg-success ano-badge text-decoration-none">
                                        <?php echo $jogo['ano']; ?>
                                    </a>
                                </div>
                                
                                <a href="detalhes.php?id=<?php echo $jogo['id']; ?>" class="btn btn-primary">Ver mais</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
