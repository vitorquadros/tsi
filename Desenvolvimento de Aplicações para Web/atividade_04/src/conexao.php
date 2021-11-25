<?php
function fazConexao(){
  $stringDeConexao = "mysql:host=127.0.0.1; dbname=aula; user=root; password=8642";
  
  try{
    $link = new PDO($stringDeConexao);
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return($link);
  } 
  catch(PDOException $ex){
    die($ex->getMessage());
  }
  
}
?>