<?php
include 'layout/top_layout.php';
include 'core/alerts.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>FinApp - Perfil</title>
</head>

<body>
    <div class='container-fluid' style='margin-top: 40px;'>
        <div class='card mb-4'>
            <div class="card-body">
                <h1 class="card-title text-primary">
                    <?php echo $_SESSION['usuario']->getNome(); ?>
                </h1>
                <div>
                    <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#altera_senha'>Alterar Senha</button>    
                </div><br>
                <h4 class="card-title text-primary">Login</h4>
                <form method="post">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input disabled class='form-control' aria-describedby='basic-addon1' type="email" id="email"
                                name="email" value="<?php echo $_SESSION['usuario']->getEmail(); ?>" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <h4 class="card-title text-primary">Dados Pessoais</h4>
                        <div class="mb-3">
                            <label style="width: 100px" class="form-label" id="nome" for="nome">Nome</label>
                            <input class='form-control' aria-describedby='basic-addon1' type="text" name="nome"
                                value="<?php echo $_SESSION['usuario']->getNome(); ?>" />
                        </div>
                        <div class="mb-3">
                            <label style="width: 100px" class="form-label" id="nomeempresa"
                                for="nomeempresa">Empresa</label>
                            <input class='form-control' aria-describedby='basic-addon1' type="text" name="nomeempresa"
                                value="<?php echo $_SESSION['usuario']->getNomeEmpresa(); ?>" />
                        </div>
                        <div class="mb-3">
                            <label style="width: 100px" class="form-label" for="cpf">CPF</label>
                            <input pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" disabled class='form-control'
                                aria-describedby='basic-addon1' type="text" placeholder="000.000.000-00" name="cpf" id="cpf"
                                value="<?php echo $_SESSION['usuario']->getCpf(); ?>" />
                            <label style="width: 100px" class="form-label" for="cnpj">CNPJ</label>
                            <input disabled pattern="\d{2}\.\d{3}\.\d{3}/\d{4}-\d{2}" class='form-control'
                                aria-describedby='basic-addon1' type="text" placeholder="00.000.000/0000-00" name="cnpj" id="cnpj"
                                value="<?php echo $_SESSION['usuario']->getCnpj(); ?>" />
                        </div>
                        <div class="mb-3">
                            <label style="width: 100px" class="form-label" for="telefone">Telefone</label>
                            <input class='form-control' aria-describedby='basic-addon1' type="text" name="telefone" id="telefone"
                                value="<?php echo $_SESSION['usuario']->getTelefone(); ?>" />
                        </div>
                        <h4 class="card-title text-primary">Endereço</h4>
                    </div>
                    <div class="mb-3">
                        <div class="mb-3">
                            <label style="width: 100px" class="form-label" id="logradouro" for="logradouro">Rua</label>
                            <input class='form-control' aria-describedby='basic-addon1' type="text" name="logradouro"
                                value="<?php echo $_SESSION['usuario']->getRua(); ?>" />
                            <label style="width: 100px" class="form-label" id="numlogradouro"
                                for="numlogradouro">Numero</label>
                            <input class='form-control' aria-describedby='basic-addon1' type="text" name="numlogradouro"
                                value="<?php echo $_SESSION['usuario']->getNumeroRua(); ?>" />
                        </div>
                        <div class="mb-3">
                            <label style="width: 100px" class="form-label" for="cep">CEP</label>
                            <input class='form-control' aria-describedby='basic-addon1' placeholder="00000-000" id="cep"
                                type="text" name="cep" value="<?php echo $_SESSION['usuario']->getCep(); ?>" />
                            <label style="width: 100px" class="form-label" id="cidade" for="cidade">Cidade</label>
                            <input class='form-control' aria-describedby='basic-addon1' type="text" name="cidade"
                                value="<?php echo $_SESSION['usuario']->getCidade(); ?>" />
                        </div>
                        <div class="mb-3">
                            <label style="width: 100px" class="form-label" id="bairro" for="bairro">Bairro</label>
                            <input class='form-control' aria-describedby='basic-addon1' type="text" name="bairro"
                                value="<?php echo $_SESSION['usuario']->getBairro(); ?>" />
                        </div>
                    </div>
                    <div style='text-align: right'>
                        <button type='submit' class='btn btn-sm btn-success btn-lg'>Salvar</button>
                        <input class='btn btn-sm btn-danger' type='button' value='Cancelar'
                            onclick="window.location.href = 'index.php';">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="altera_senha" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class='container-fluid'>
                    <div class="card-body">
                        <form action="core/alterasenha.php" method="post">
                            <div class="mb-3">
                                <label for="senhaatual" class="form-label">Senha Atual</label>
                                <input class='form-control' aria-describedby='basic-addon1' type="password" name="senhaatual" id="senhaatual" />

                                <label for="senha" class="form-label">Nova Senha</label>
                                <input minlength="8" class='form-control' aria-describedby='basic-addon1' type="password" name="senha" />

                                <label for="senha2" class="form-label">Repita a nova Senha</label>
                                <input class='form-control' aria-describedby='basic-addon1' type="password" name="senha2" required onblur="validarSenhas()" />
                            </div>
                            <p id="mensagemErro" style="color: red;"></p>
                    </div>
                    <script>
                            function validarSenhas() {
                                var senha1 = document.getElementsByName("senha")[0].value;
                                var senha2 = document.getElementsByName("senha2")[0].value;
                                var mensagemErro = document.getElementById("mensagemErro");
                                

                                // Verifica se as senhas são iguais
                                if (senha1 !== senha2) {
                                    mensagemErro.innerHTML = "As senhas não coincidem. Tente novamente.";
                                    document.getElementById("salvar").disabled = true; 
                                    return false; // Impede o envio do formulário
                                } else {
                                    mensagemErro.innerHTML = "";
                                    document.getElementById("salvar").disabled = false; 
                                    return true; // Permite o envio do formulário
                                }
                            }
                        </script>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type='submit' class="btn btn-success" id="salvar">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/formatters.js"></script>
</body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['usuario']->setNome($_POST['nome']);
    $_SESSION['usuario']->setNomeEmpresa($_POST['nomeempresa']);
    $_SESSION['usuario']->setTelefone($_POST['telefone']);
    $_SESSION['usuario']->setRua($_POST['logradouro']);
    $_SESSION['usuario']->setNumeroRua($_POST['numlogradouro']);
    $_SESSION['usuario']->setCep($_POST['cep']);
    $_SESSION['usuario']->setCidade($_POST['cidade']);
    $_SESSION['usuario']->setBairro($_POST['bairro']);

    $_SESSION['usuario']->updateUsuario($_SESSION['usuarioID']);

    $_SESSION['usuarioNome'] = $_SESSION['usuario']->getNome();

    ?>
    <script src="js/alertas.js"></script>
    <script>
        if (!window.location.hash) {
            window.location = window.location + '#loaded';
            window.location.reload();
        }
    </script>
    <?php
}
?>

</html>