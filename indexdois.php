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

function consultarTarefas($conn) {
    $query = "SELECT * FROM tasks order by id desc";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Erro na consulta: " . mysqli_error($conn));
    }

    return $result;
}

if (!$conn) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}

$result = consultarTarefas($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="./assets/tasks.png" />
  <title>Gerenciador de tarefas</title>
  <link rel="stylesheet" href="styledois.css" type="text/css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
</head>
<body>
    <div class='content'>
    <header>
        <h1>Gerenciador de Tarefas</h1>
    </header>
    <main>
        <div class="limitar-secao container">

            <div class="adicionar">
                <h3>Adicionar Tarefa</h3>
                <form class="form-adicionar" method="POST" action="add.php">
                    <div>
                        <label for="title">Título:</label>
                        <input type="text" name="title" id='title' required>
                    </div>

                    <div class='descricao'>
                        <label for="description">Descrição:</label>
                        <textarea name="description" id='description'></textarea>
                    </div>

                    <div>
                        <label for="inicio">Início:</label>
                        <input type='datetime-local' name="inicio" id='inicio'/>
                    </div>

                    <div>
                        <label for="fim">Fim:</label>
                        <input type='datetime-local' name="fim" id='fim'/>
                    </div>

                    <input type="submit" value="Adicionar">
                </form>
            </div>

            <table>
                <tr>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Criado em</th>
                    <th>Atualizado em</th>
                    <th>Ações</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['inicio'] !== null && $row['inicio'] !== '0000-00-00 00:00:00' ? date('d/m/Y H:i', strtotime($row['inicio'])) : ''; ?></td>
                        <td><?php echo $row['fim'] !== null && $row['fim'] !== '0000-00-00 00:00:00' ? date('d/m/Y H:i', strtotime($row['fim'])) : ''; ?></td>
                        <td><?php echo date('d/m/Y H:i:s', strtotime($row['created_at'])); ?></td>
                        <td><?php echo date('d/m/Y H:i:s', strtotime($row['updated_at'])); ?></td>
                        <td class='edit'>
                            <a href="edit.php?id=<?php echo $row['id']; ?>"><img class='img-acao' title='Editar' src='assets/pencil.png'/></a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>"><img class='img-acao' title='Excluir' src='assets/x-button.png'/></a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </main>
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
<?php
mysqli_close($conn);
?>
