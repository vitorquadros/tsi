<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/style.css?v=<?php echo time(); ?>">
  <title>Home</title>
</head>

<?php 
require_once('conexao.php');
require_once('./logica/logica_produtos.php');
require_once('./logica/logica_categorias.php');
session_start();
if (!$_SESSION['logado']) header('location:./login.php');

if (isset($_SESSION['nomeProdutoPesquisar'])) {
  $produtos = pesquisarProdutosComCategoria($conexao, array($_SESSION['nomeProdutoPesquisar']));
  $_SESSION['pesquisar']['status'] = true;
  $_SESSION['pesquisar']['pesquisa'] = trim($_SESSION['nomeProdutoPesquisar'], '%');
  unset($_SESSION['nomeProdutoPesquisar']);
} else {
  $produtos = getProdutosComCategoria($conexao);
  unset($_SESSION['pesquisar']);
}

?>

<body>
  <div id="logado">
    <p>Logado: <strong><?php echo $_SESSION['nome']; ?></strong></p>
    <form action="./logica/logica_usuarios.php" method="POST">
      <button type="submit" name="sair">sair</button>
    </form>
  </div>
  <section class="container">
    
    <form action="./logica/logica_produtos.php" method="GET">
      <input type="text" id="nome" name="nome" placeholder="Pesquisar produtos">
      <button type="submit" name="pesquisar">
        <img src="./img/lupa.png" alt="Pesquisar">
      </button>
    </form>

    <div class="buttons-container">
      <a href="./cadastrar_categoria.php">Cadastrar Categorias</a>
      <a href="./cadastrar_produto.php">Cadastrar Produtos</a>
    </div>

    <hr>

    <div class="produtos">
      <?php if ($_SESSION['pesquisar']['status']) { ?>
        <p>Pesquisando por: <strong><?php echo $_SESSION['pesquisar']['pesquisa'] ?></strong></p>
      <?php } ?>
      <?php if (!$produtos) { ?>
        <p>Nenhum produto encontrado.</p>
      <?php } else { ?>
      <table>
        <tr>
          <td><strong>id</strong></td>
          <td><strong>Nome</strong></td>
          <td><strong>Descrição</strong></td>
          <td><strong>Quantidade</strong></td>
          <td><strong>Categoria</strong></td>
        </tr>
      
      <?php
      foreach(array_reverse($produtos) as $produto) { ?>
        <tr>
          <td><?php echo $produto['idproduto']; ?></td>
          <td><?php echo $produto['nome']; ?></td>
          <td><?php echo $produto['descricao']; ?></td>
          <td><?php echo $produto['quantidade']; ?></td>
          <td><?php echo $produto['nomecategoria']; ?></td>
        </tr>
      <?php } ?>
      </table>
      <?php } ?>
    </div>
  </section>
</body>


</html>