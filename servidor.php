<?php
	$verbo = $_SERVER["REQUEST_METHOD"];
	$token = "123456";
	

	switch ($verbo) {
		case 'GET':
			if(!empty($_GET["hash"])){
				$hash = $_GET["hash"];
				if($hash == $token){

					$estudiantes = traerDatos();
					$fila = array(2);
					$contador = 0;
					foreach ($estudiantes as $estudiante) {
						$fila[$contador] = array(
						"codigo"=>$estudiante["codigo"],
						"nombres"=>$estudiante["nombres"],
						"apellidos"=>$estudiante["apellidos"],
						"PA"=>$estudiante["id_pa"]
						);
						$contador++;
					}

			/*		$datos = array(
						"codigo"=>2015112236,
						"nombres"=>"Pedro",
						"apellidos"=>"Puelles",
						"PA"=>"Ingenieria de Sistemas e Informatica"
					); */

					echo json_encode(array("datos"=>$fila));	
				}
				else{
					echo json_encode(array("datos"=>"hash incorrecto"));
				}
			}
			else{
				echo json_encode(array("datos"=>"Incluya el campo hash"));
			}
			
			break;

		case 'POST':
			$codigo = $_POST["codigo"];
			$nombres = $_POST["nombres"];
			$apellidos = $_POST["apellidos"];
			$pa = $_POST["pa"];
			guardarDatos($codigo, $nombres, $apellidos, $pa);
			echo json_encode(array("respuesta"=>"Guardado"));
			break;
		
		default:
			echo "imprimir otra cosa";
			break;
	}	

function guardarDatos($codigo, $nombres, $apellidos, $pa){
	$usuariodb = "root";
	$passdb ="";
	$nombredb = "universidad";
	try{
	$conn = new PDO("mysql:host=localhost;dbname=".$nombredb, $usuariodb, $passdb);
		$sql = "INSERT INTO estudiante VALUES($codigo, '$nombres', '$apellidos', $pa)";
		$conn->exec($sql);
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
}


function traerDatos(){
	$usuariodb = "root";
	$passdb ="";
	$nombredb = "universidad";
	$datos = null;
	try{
	$conn = new PDO("mysql:host=localhost;dbname=".$nombredb, $usuariodb, $passdb);
		$sql = "SELECT * FROM estudiante";
		$datos = $conn->query($sql);
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
	return $datos;
}
?>






