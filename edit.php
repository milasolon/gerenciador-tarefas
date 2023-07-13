<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario'])) {
  // Redirecionar o usuário para a página de login
  header("Location: index.php");
  exit(); // Encerrar o script para evitar que o restante da página seja exibido
}


require('conexao.php');

function redirecionar($url) {
    header("Location: $url");
    exit();
}

function consultarTarefa($conn, $id) {
    $query = "SELECT * FROM tasks WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Erro na consulta: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) === 0) {
        die("Tarefa não encontrada.");
    }

    return mysqli_fetch_assoc($result);
}

function atualizarTarefa($conn, $id, $title, $description, $inicio, $fim) {
    $query = "UPDATE tasks SET title='$title', description='$description', inicio='$inicio', fim='$fim' WHERE id=$id";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Erro na consulta: " . mysqli_error($conn));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$conn) {
        die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
    }

    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $inicio = $_POST['inicio'];
    $fim = $_POST['fim'];

    atualizarTarefa($conn, $id, $title, $description, $inicio, $fim);

    mysqli_close($conn);

    redirecionar("indexdois.php");
} else {
    if (!$conn) {
        die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
    }

    if (!isset($_GET['id'])) {
        die("ID da tarefa não fornecido.");
    }

    $id = $_GET['id'];

    $row = consultarTarefa($conn, $id);
    $title = $row['title'];
    $description = $row['description'];
    $inicio = $row['inicio'];
    $fim = $row['fim'];

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <link rel="icon" href="./assets/tasks.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gerenciador de tarefas/Editar tarefa</title>
  <link rel="stylesheet" href="styledois.css" Content-Type="text/css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Pangolin&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Gerenciador de Tarefas</h1>
    </header>
    <main>
        <div class="limitar-secao container">

            <div class="adicionar">
                <h3>Editar Tarefa:</h3>
                <form class="form-adicionar" method="POST" action="">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div>
                        <label for="title">Título:</label>
                        <input type="text" name="title" id='title' value="<?php echo $title; ?>" required>
                    </div>

                    <div class='descricao'>
                        <label for="description">Descrição:</label>
                        <textarea name="description" id='description'><?php echo $description; ?></textarea>
                    </div>

                    <div>
                        <label for="inicio">Início:</label>
                        <input type='datetime-local' name="inicio" id='inicio' value="<?php echo $inicio; ?>"/>
                    </div>

                    <div>
                        <label for="fim">Fim:</label>
                        <input type='datetime-local' name="fim" id='fim' value="<?php echo $fim; ?>"/>
                    </div>

                    <input type="submit" value="Atualizar">
                </form>
            </div>
        </div>
    <main>
    <footer>
        <div class="limitar-secao">
            <div class="container-footer">
                <div class='container-logo'>
                    <img src='./assets/checklist.png' title='Check list'>
                    <h1>Gerenciador de Tarefas</h1>
                </div>
                <div class="container-sair">
                    <img src="./assets/logout.png" alt="logout">
                    <span>Sair</span>
                </div>
            </div>
        </div>
        <div class="direito-autoral">
            <p>© DESENVOLVIDO POR KAMILA SOLON BARROS - 2023 - TODOS OS DIREITOS RESERVADOS</p>
        </div>
    </footer>
    </div>

      <!-- scripts -->
  <script>
    // Função para realizar o logout
    function realizarLogout() {
      window.location.href = "logout.php";
    }

    // Capturando o evento de clique na div de logout
    const containerSair = document.querySelector(".container-sair");
    containerSair.addEventListener("click", realizarLogout);
  </script>

</body>
</html>