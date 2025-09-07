<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Cadastro</title>
    <link rel="stylesheet" href="../../public/css/auth.css">
</head>
<body>
    <?php
        session_start();
        if (isset($_SESSION['cadastro_sucesso'])) {
            echo '<p style="color:green; text-align:center;">' . htmlspecialchars($_SESSION['cadastro_sucesso']) . '</p>';
            unset($_SESSION['cadastro_sucesso']);
        }
        if (isset($_SESSION['cadastro_erro'])) {
            echo '<p style="color:red; text-align:center;">' . htmlspecialchars($_SESSION['cadastro_erro']) . '</p>';
            unset($_SESSION['cadastro_erro']);
        }
        if (isset($_SESSION['login_sucesso'])) {
            echo '<p style="color:green; text-align:center;">' . htmlspecialchars($_SESSION['login_sucesso']) . '</p>';
            unset($_SESSION['login_sucesso']);
        }
        if (isset($_SESSION['login_erro'])) {
            echo '<p style="color:red; text-align:center;">' . htmlspecialchars($_SESSION['login_erro']) . '</p>';
            unset($_SESSION['login_erro']);
        }
        ?>

    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="../controllers/CadastroController.php" method="POST">
                <h1>Criar Conta</h1>
                <span>ou use seu e-mail para o registro</span>
                <input type="text" placeholder="Nome" name="nome" required />
                <input type="email" placeholder="Email" name="email" required />
                <input type="password" placeholder="Senha" name="senha" required />
                <select name="tipo_usuario" required>
                    <option value="">Selecione o tipo de usuário</option>
                    <option value="candidato">Candidato</option>
                    <option value="empresa">Empresa</option>
                    <option value="admin">Administrador</option>
                </select>
                <button type="submit">Cadastrar</button>
            </form>
        </div>

        <div class="form-container sign-in-container">
            <form action="../controllers/LoginController.php" method="POST">
                <h1>Entrar</h1>
                <span>ou use sua conta</span>
                <input type="email" placeholder="Email" name="email" required />
                <input type="password" placeholder="Senha" name="senha" required />
                <a href="#">Esqueceu sua senha?</a>
                <button type="submit">Entrar</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Bem Vindo de Volta!</h1>
                    <p>Para se manter conectado conosco, faça login com suas informações pessoais</p>
                    <button class="ghost" id="signIn">Entrar</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Olá, Amigo!</h1>
                    <p>Insira seus detalhes pessoais e comece sua jornada conosco</p>
                    <button class="ghost" id="signUp">Cadastrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../public/js/auth.js"></script>
</body>
</html>