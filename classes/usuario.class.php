<?php

class Usuario
{
    private $nome;
    private $telefone;
    private $rua;
    private $email;
    private $senha;
    private $cep;
    private $numeroRua;
    private $cidade;
    private $bairro;
    private $nomeEmpresa;
    private $cpf;
    private $cnpj;

    // Construtor para inicializar a classe com os valores desejados
    public function __construct($nome, $telefone, $rua, $email, $senha, $cep, $numeroRua, $cidade, $bairro, $nomeEmpresa, $cpf, $cnpj)
    {
        $this->nome = $nome;
        $this->telefone = $telefone;
        $this->rua = $rua;
        $this->email = $email;
        $this->senha = $senha;
        $this->cep = $cep;
        $this->numeroRua = $numeroRua;
        $this->cidade = $cidade;
        $this->bairro = $bairro;
        $this->nomeEmpresa = $nomeEmpresa;
        $this->cpf = $cpf;
        $this->cnpj = $cnpj;
    }
    
    public function getNome() {
        return $this->nome;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getRua() {
        return $this->rua;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getCep() {
        return $this->cep;
    }

    public function getNumeroRua() {
        return $this->numeroRua;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function getNomeEmpresa() {
        return $this->nomeEmpresa;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getCnpj() {
        return $this->cnpj;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function setRua($rua) {
        $this->rua = $rua;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function setCep($cep) {
        $this->cep = $cep;
    }

    public function setNumeroRua($numeroRua) {
        $this->numeroRua = $numeroRua;
    }

    public function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    public function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    public function setNomeEmpresa($nomeEmpresa) {
        $this->nomeEmpresa = $nomeEmpresa;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }
    
    public function cadastrarUsuario()
    {
        try {
            $conn = DB::connect();

            // Verificar se o usuário já existe no banco
            $verificaExistencia = "SELECT COUNT(*) as total FROM ca_usuario WHERE ca_email = :usuario";
            $stmtExistencia = $conn->prepare($verificaExistencia);
            $stmtExistencia->bindParam(':usuario', $this->email);
            $stmtExistencia->execute();

            $resultadoExistencia = $stmtExistencia->fetch(PDO::FETCH_ASSOC);

            if ($resultadoExistencia['total'] > 0) {
                // Usuário já existe, não é possível cadastrar novamente
                return "O e-mail utilizado já está sendo utilizado!";
            }

            // Inserir novo usuário no banco
            $query = "INSERT INTO ca_usuario (ca_nomeusuario, ca_telusuario, ca_rua, ca_email, ca_senha, ca_cep, ca_numerorua, ca_cidade, ca_bairro, ca_nomeempresa, ca_cpf, ca_cnpj, ca_datacadastro)
                      VALUES (:nome, :telefone, :rua, :usuario, :senha, :cep, :numerorua, :cidade, :bairro, :nomeEmpresa, :cpf, :cnpj, NOW())";
            $stmt = $conn->prepare($query);

            // Bind dos parâmetros
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':telefone', $this->telefone);
            $stmt->bindParam(':rua', $this->rua);
            $stmt->bindParam(':usuario', $this->email);
            $stmt->bindParam(':senha', $this->senha);
            $stmt->bindParam(':cep', $this->cep);
            $stmt->bindParam(':numerorua', $this->numeroRua);
            $stmt->bindParam(':cidade', $this->cidade);
            $stmt->bindParam(':bairro', $this->bairro);
            $stmt->bindParam(':nomeEmpresa', $this->nomeEmpresa);
            $stmt->bindParam(':cpf', $this->cpf);
            $stmt->bindParam(':cnpj', $this->cnpj);

            $stmt->execute();
            $errorInfo = $stmt->errorInfo();

            return "Cadastro realizado com sucesso!"; // Sucesso no cadastro
            //return $errorInfo;
            
        } catch (PDOException $e) {
            // Tratar erro de conexão ou consulta
            return "$errorInfo"; // Falha no cadastro
        } finally {
            // Sempre feche a conexão, mesmo em caso de exceção
            $conn = null;
        }
    }

    public function updateUsuario($idusuario)
    {
        $conn = DB::connect();
        $query = "UPDATE ca_usuario SET ca_nomeusuario = :nome, ca_nomeempresa = :nomeempresa, ca_telusuario = :telefone, ca_rua = :logradouro, ca_numerorua = :numlogradouro, ca_cep = :cep, ca_cidade = :cidade, ca_bairro = :bairro
                  WHERE idusuario = $idusuario";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':nomeempresa', $this->nomeEmpresa);
        $stmt->bindParam(':telefone', $this->telefone);
        $stmt->bindParam(':logradouro', $this->rua);
        $stmt->bindParam(':numlogradouro', $this->numeroRua);
        $stmt->bindParam(':cep', $this->cep);
        $stmt->bindParam(':cidade', $this->cidade);
        $stmt->bindParam(':bairro', $this->bairro);

        $stmt->execute();
        $errorInfo = $stmt->errorInfo();
        //echo "<script>window.location.reload();</script>";
    }

    public static function updateSenhaUsuario($idusuario, $senha) {

        try {
            $conn = DB::connect();
            $senhasegura = password_hash($senha, PASSWORD_BCRYPT);
            
            $query = "UPDATE ca_usuario SET ca_senha = :senha WHERE idusuario = :idusuario";

            $stmt = $conn->prepare($query);
            $stmt->bindParam(':idusuario', $idusuario);
            $stmt->bindParam(':senha', $senhasegura);
            $stmt->execute();
            $errorInfo = $stmt->errorInfo();

            return true;

        } catch (PDOException $e) {
            return "$errorInfo";
        } finally {
            $conn = null;
        }
    }
}