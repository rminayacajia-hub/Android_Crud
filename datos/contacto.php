<?php 
require_once("../datos/model/cls_conexion.php");
header("Content-Type: text/html; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header ('Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept, X-Requested-With, x-xsrf-token');
header("Access-Control-Allow-Credentials: true");
$post=json_decode(file_get_contents("php://input"),true)?:$_GET;

// metodo y accion para listar contactos

if($post['accion']=='consultar'){
    $conex=new cls_conexion();
    $conex=$conex->conectar();

    $sentencia=sprintf("SELECT * from contacto
    where persona_cod_persona=%s",
    $conex->real_escape_string($post['cod_persona']));
    
    $rs=mysqli_query($conex,$sentencia);

    if(mysqli_num_rows($rs)>0){
        while($row=mysqli_fetch_array($rs)){
       $datos[]=array(
        'codigo'=>$row['cod_contacto'],
        'nombre'=>$row['nom_contacto'],
        'apellido'=>$row['ape_contacto']
       );
    }
    $respuesta=json_encode(array("estado"=>true,"personas"=>$datos));
}
        else{
        $respuesta=json_encode(array("estado"=>false,"mensaje"=>"No existen contactos"));
    }
    echo $respuesta;
}
?>


