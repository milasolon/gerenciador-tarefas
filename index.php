<?php
	//Inicializado primeira a sessão para posteriormente recuperar valores das variáveis globais. 
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="./assets/tasks.png" />
    <title>Gerenciador de tarefas</title>
    <link rel="stylesheet" href="style.css" type="text/css">
  </head>
  <body>

  <div class="login-card">
    <div class="card-header">
        <div class="log">Login</div>
    </div>
    <form method="post" action="valida.php" id="formlogin" name="formlogin" >
        <div class="form-group">
            <label for="username">Usuário:</label>
            <input required="" name="email" id="username" type="text">
        </div>
        <div class="form-group">
            <label for="password">Senha:</label>
            <input required="" name="senha" id="password" type="password">
        </div>
        <div class="form-group">
            <input class="senha" value="Entrar" type="submit">
        </div>

        <p class="erro">
            <?php 
			  //Recuperando o valor da variável global, os erro de login.
		      if(isset($_SESSION['loginErro'])){
                echo $_SESSION['loginErro'];
                unset($_SESSION['loginErro']);
            }?>
        </p>
        <p>
            <?php 
			  //Recuperando o valor da variável global, deslogado com sucesso.
              if(isset($_SESSION['logindeslogado'])){
                echo $_SESSION['logindeslogado'];
              unset($_SESSION['logindeslogado']);
              }
            ?>
        </p>
    </form>
  </div>
  </body>
</html>