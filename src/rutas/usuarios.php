<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// GET Todos los usuatios 
$app->get('/api/usuarios', function(Request $request, Response $response){
  $sql = "SELECT * FROM users";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0){
      $usuarios = $resultado->fetchAll(PDO::FETCH_OBJ);
      echo json_encode($usuarios);
    }else {
      echo json_encode("No existen usuarios en la BBDD.");
    }
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 

// GET Recueperar los usuario por ID 
$app->get('/api/user/{id}', function(Request $request, Response $response){
  $id_usuario = $request->getAttribute('id');
  $sql = "SELECT * FROM users WHERE id = $id_user";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0){
      $usuario = $resultado->fetchAll(PDO::FETCH_OBJ);
      echo json_encode($usuario);
    }else {
      echo json_encode("No existen Usuarios en la BBDD con este ID.");
    }
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 


// POST Crear nuevo cliente 
$app->post('/api/user/nuevo', function(Request $request, Response $response){
   $nome = $request->getParam('nome');
   $email = $request->getParam('email');
   $telefone = $request->getParam('telefone');
  
  $sql = "INSERT INTO users (nome, email, telefone) VALUES 
          (:nome, :email, :telefone)";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->prepare($sql);

    $resultado->bindParam(':nome', $nome);
    $resultado->bindParam(':email', $email);
    $resultado->bindParam(':telefone', $telefone);
    $resultado->execute();
    echo json_encode("Nuevo cliente guardado.");  

    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 



// PUT Modificar Usuario
$app->put('/api/clientes/modificar/{id}', function(Request $request, Response $response){
   $id_usuario = $request->getAttribute('id');
   $nome = $request->getParam('nome');
   $telefone = $request->getParam('telefone');
   $email = $request->getParam('email');
  
  $sql = "UPDATE usuers SET
          nome = :nome,
          email = :email,
          telefone = :telefone
        WHERE id = $id_usuario";
     
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->prepare($sql);

    $resultado->bindParam(':nome', $nome);
    $resultado->bindParam(':email', $email);
    $resultado->bindParam(':telefono', $telefono);

    $resultado->execute();
    echo json_encode("Usuario modificado.");  

    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 


// DELETE borar cliente 
$app->delete('/api/user/delete/{id}', function(Request $request, Response $response){
   $id_usuario = $request->getAttribute('id');
   $sql = "DELETE FROM users WHERE id = $id_usuario";
     
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->prepare($sql);
     $resultado->execute();

    if ($resultado->rowCount() > 0) {
      echo json_encode("Usuario eliminado.");  
    }else {
      echo json_encode("No existe usuario con este ID.");
    }

    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 