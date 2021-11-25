<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/style_categoria.css">
  <title>Document</title>
</head>

<?php
session_start();
if (!$_SESSION['logado']) header('location:./login.php');
?>

<body>
  <section class="container">
    <h3>Cadastrar Categoria</h3>
    <form action="./logica/logica_categorias.php" method="POST">
      <input type="text" id="nome" name="nome" placeholder="Nome da categoria">
      <button type="submit" name="cadastrar">Cadastrar</button>
    </form>
    <a href="./index.php">Voltar</a>
  </section>
</body>
</html>