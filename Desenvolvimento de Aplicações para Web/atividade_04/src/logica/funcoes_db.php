<?php 

require_once('/opt/lampp/htdocs/AW/src/conexao.php');

function selectAll($sql, $parametros=array()) {
  try {
    //conecta
    $conexao = fazConexao();
    //cria o objeto de consulta
    $consulta = $conexao->prepare($sql);
    //executa a consulta
    if (sizeof($parametros) > 0) { 
      $result = $consulta->execute($parametros);
    } 
    else{
      
      $result = $consulta->execute();
    }  
    
    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
    return($resultados);
  }
  catch (PDOException $e) {
    echo $e;
  }
}
// função utilizada para consulta de um registro (select) 

function select($sql, $parametros=array()) {
  try {
    //conecta
    $conexao = fazConexao();
    //cria o objeto de consulta
    $consulta = $conexao->prepare($sql);
    //executa a consulta
    if (sizeof($parametros) > 0) { 
      $result = $consulta->execute($parametros);
    } 
    else{
      
      $result = $consulta->execute();
    }  
    
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    return($resultado);
  }
  catch (PDOException $e) {
    echo $e;
  }
}

// função utilizada para insert, update ou delete
function consulta($sql,$parametros=array()) {
  try {
    //conecta
    $conexao = fazConexao();
    //cria o objeto de consulta
    $consulta = $conexao->prepare($sql);
    //testa se foram passados parâmetros
    
    if (sizeof($parametros) > 0) { 
      $resultado=$consulta->execute($parametros);
    } 
    else{
      
      $resultado=$consulta->execute();
    }    
    
    return $resultado;
  }
  catch (PDOException $e) {
    echo $e;
  }
}

?>