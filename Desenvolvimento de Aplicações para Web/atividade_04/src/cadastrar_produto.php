<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/style_categoria.css">
  <title>Cadastrar Produto</title>
</head>

<?php 
  session_start();
  if (!$_SESSION['logado']) header('location:./login.php');
  include_once('/opt/lampp/htdocs/AW/src/conexao.php');
  include_once('/opt/lampp/htdocs/AW/src/logica/logica_categorias.php');
  $categorias = getCategorias($conexao);
?>

<body>
  <section class="container">
    <h3>Cadastrar Produto</h3>
    <form action="./logica/logica_produtos.php" method="POST">
      <select name="idcategoria" id="idcategoria">
        <option selected disabled>Selecione uma categoria</option>
        <?php
          foreach($categorias as $categoria) { ?>
          <option value="<?php echo $categoria['idcategoria']; ?>"><?php echo $categoria['nomecategoria']; ?></option>
        <?php } ?>

      </select>
      <input type="text" id="nome" name="nome" placeholder="Nome do produto">
      <input type="text" id="descricao" name="descricao" placeholder="Descrição do produto">
      <input type="number" id="quantidade" name="quantidade" placeholder="Quantidade">
      <button type="submit" name="cadastrar">Cadastrar</button>
    </form>
    <a href="./index.php">Voltar</a>
  </section>
</body>
</html>