<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario'])) {
  // Redirecionar o usuário para a página de login
  header("Location: index.php");
  exit(); // Encerrar o script para evitar que o restante da página seja exibido
}

require('conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se houve um erro na conexão
    if (!$conn) {
        die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
    }

    // Prepara os dados para inserção no banco de dados
    $title = $_POST['title'];
    $description = $_POST['description'];
    $inicio = $_POST['inicio'];
    $fim = $_POST['fim'];

    // Consulta para adicionar a nova tarefa
    $query = "INSERT INTO tasks (title, description, inicio, fim) VALUES ('$title', '$description', '$inicio', '$fim')";
    $result = mysqli_query($conn, $query);

    // Verifica se houve um erro na consulta
    if (!$result) {
        die("Erro na consulta: " . mysqli_error($conn));
    }

    // Redireciona para a página inicial
    header("Location: indexdois.php");
    exit();
}
?>