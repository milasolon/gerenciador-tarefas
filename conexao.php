<?php
  $dbHost = "127.0.0.1";
  $dbUser = "gerTarefas";
  $dbPassword = "Qx(RMZpdBQdOEXa_";
  $dbName = "gerenciador_tarefas";

  try {
    $conn = mysqli_connect($dbHost, $dbUser, $dbPassword);
    if (!$conn) {
      throw new Exception("Erro na conexão com o banco de dados: " . mysqli_connect_error());
    }

    $select = mysqli_select_db($conn, $dbName);
    if (!$select) {
      throw new Exception("Sem acesso ao banco de dados: " . mysqli_error($conn));
    }
  } catch (Exception $e) {
    // Lidar com o erro de conexão de maneira apropriada
    die("Erro: " . $e->getMessage());
  }
?>