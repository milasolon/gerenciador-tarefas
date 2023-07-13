<?php
session_start();
// Incluindo a conexão com banco de dados
include_once("conexao.php");
// O campo usuário e senha preenchido entra no if para validar
if (isset($_POST['email']) && isset($_POST['senha'])) {
    $usuario = mysqli_real_escape_string($conn, $_POST['email']); // Escapar de caracteres especiais, como aspas, prevenindo SQL injection
    $senha = mysqli_real_escape_string($conn, $_POST['senha']);
    
    // Buscar na tabela usuário o usuário que corresponde com os dados digitados no formulário
    
    $result_usuario = "SELECT * FROM usuarios WHERE login = '$usuario' && senha = PASSWORD('$senha') LIMIT 1";
    $resultado_usuario = mysqli_query($conn, $result_usuario);
    $resultado = mysqli_fetch_assoc($resultado_usuario);
    
    // Encontrado um usuário na tabela usuário com os mesmos dados digitados no formulário
    if (isset($resultado)) {
        // Armazenar o nome de usuário na variável de sessão
        $_SESSION['usuario'] = $resultado['nome'];
        header("Location: indexdois.php");
    } else {
        $_SESSION['loginErro'] = "Usuário ou senha inválido";
        header("Location: index.php");
    }
} else {
    echo "Erro";
}
?>
