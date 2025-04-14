<?php
session_start();

if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    header('Location: index.php');
    exit;
}

$usuario_correto = 'admin';
$senha_correta_hash = password_hash('admin123', PASSWORD_DEFAULT);

$erro = '';
$sucesso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['usuario']) && isset($_POST['senha'])) {
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];
        
        if ($usuario === $usuario_correto && password_verify($senha, $senha_correta_hash)) {
            $_SESSION['logado'] = true;
            $_SESSION['usuario'] = $usuario;
            header('Location: index.php');
            exit;
        } else {
            $erro = 'Usuário ou senha incorretos.';
        }
    } else {
        $erro = 'Por favor, preencha todos os campos.';
    }
}

include 'header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card bg-dark mt-5">
            <div class="card-header">
                <h3 class="text-center">Login</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($erro)): ?>
                    <div class="alert alert-danger"><?php echo $erro; ?></div>
                <?php endif; ?>
                
                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuário:</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha:</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </div>
                </form>
                
                <div class="mt-3 text-center">
                    <p class="text-muted">Usuário: admin | Senha: admin123</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>