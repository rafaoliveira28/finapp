<?php
include 'layout/layout_cadastro.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>FinApp - Cadastro</title>
    
</head>

<body>
    <div class='container-fluid' style='margin-top: 40px;'>
        <div class='card mb-4 shadow'>
            <div class="card-body">
                <h3 class="card-title">Cadastro - FinApp</h3>
                <div class="alert alert-primary" role="alert">
                    Caso não possua nome para sua Empresa ou CNPJ, tudo bem, pode deixar em branco!
                </div>
                <h4 class="card-title">Login</h4>
                <form action="core/cadastroclientecore.php" method="post">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input class='form-control' aria-describedby='basic-addon1' type="email" name="email" id="email" />
                            <p id="mensagemErroemail" style="color: red;"></p>
                            <label style="width: 100px" class="form-label" for="senha">Senha</label>
                            <input minlength="8" class='form-control' aria-describedby='basic-addon1' type="password"
                                name="senha" />
                            <label style="width: 130px" class="form-label" for="senha2">Repita a
                                Senha</label>
                            <input class='form-control' aria-describedby='basic-addon1' type="password" name="senha2"
                                required onblur="validarSenhas()" />
                        </div>
                        <p id="mensagemErro" style="color: red;"></p>

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
                    </div>
                    <div class="mb-3">
                        <h4 class="card-title">Dados Pessoais</h4>
                        <div class="mb-3">
                            <label style="width: 100px" class="form-label" for="nome">Nome</label>
                            <input required class='form-control' aria-describedby='basic-addon1' type="text"
                                name="nome" />
                        </div>
                        <div class="mb-3">
                            <label style="width: 100px" class="form-label"
                                for="nomeempresa">Empresa</label>
                            <input class='form-control' aria-describedby='basic-addon1' type="text"
                                name="nomeempresa" />
                        </div>
                        <div class="mb-3">
                            <label style="width: 100px" class="form-label" for="cpf">CPF</label>
                            <input pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" required class='form-control' id="cpf"
                                aria-describedby='basic-addon1' type="text" placeholder="000.000.000-00" name="cpf" />
                            <label style="width: 100px" class="form-label" for="cnpj">CNPJ</label>
                            <input pattern="\d{2}\.\d{3}\.\d{3}/\d{4}-\d{2}" class='form-control' id="cnpj"
                                aria-describedby='basic-addon1' type="text" placeholder="00.000.000/0000-00"
                                name="cnpj" />
                        </div>
                        <div class="mb-3">
                            <label style="width: 100px" class="form-label" for="telefone">Telefone</label>
                            <input required class='form-control' aria-describedby='basic-addon1' type="text" id="telefone" 
                                name="telefone" />
                        </div>
                        <h4 class="card-title">Endereço</h4>
                    </div>
                    <div class="mb-3">
                        <div class="mb-3">
                            <label style="width: 100px" class="form-label" for="logradouro">Rua</label>
                            <input required class='form-control' aria-describedby='basic-addon1' type="text"
                                name="logradouro" />
                            <label style="width: 100px" class="form-label"
                                for="numlogradouro">Numero</label>
                            <input required class='form-control' aria-describedby='basic-addon1' type="text" id="numlogradouro"
                                name="numlogradouro" />
                        </div>
                        <div class="mb-3">
                            <label style="width: 100px" class="form-label" for="cep">CEP</label>
                            <input required class='form-control' aria-describedby='basic-addon1' placeholder="00000-000"
                                type="text" name="cep" id="cep" />
                            <label style="width: 100px" class="form-label" for="cidade">Cidade</label>
                            <input required class='form-control' aria-describedby='basic-addon1' type="text"
                                name="cidade" />
                        </div>
                        <div class="mb-3">
                            <label style="width: 100px" class="form-label" for="bairro">Bairro</label>
                            <input required class='form-control' aria-describedby='basic-addon1' type="text"
                                name="bairro" />
                        </div>
                    </div>
                    <div style='text-align: right'>
                        <button type='submit' class='btn btn-sm btn-success btn-lg' id="salvar">Salvar</button>
                        <input class='btn btn-sm btn-danger' type='button' value='Cancelar' onclick='history.go(-1)'>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/formatters.js"></script>
</body>

</html>