<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario'])) {
  // Redirecionar o usuário para a página de login
  header("Location: index.php");
  exit(); // Encerrar o script para evitar que o restante da página seja exibido
}

// Conexão com o banco de dados
require('conexao.php');

// Verifica se houve um erro na conexão
if (!$conn) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}

// Verifica se o ID da tarefa foi fornecido
if (!isset($_GET['id'])) {
    die("ID da tarefa não fornecido.");
}

// Prepara o ID da tarefa para exclusão
$id = $_GET['id'];

// Consulta para excluir a tarefa
$query = "DELETE FROM tasks WHERE id=$id";
$result = mysqli_query($conn, $query);

// Verifica se houve um erro na consulta
if (!$result) {
    die("Erro na consulta: " . mysqli_error($conn));
}

// Redireciona para a página inicial
header("Location: indexdois.php");
exit();
?>
