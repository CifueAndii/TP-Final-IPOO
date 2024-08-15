<?php
class Persona{

	private $nrodoc;
	private $nombre;
	private $apellido;
	private $mensajeoperacion;


	public function __construct(){
		$this->nrodoc = "";
		$this->nombre = "";
		$this->apellido = "";
	}

	public function cargar($datos){		
		$this->setNrodoc($datos['nrodoc']);
		$this->setNombre($datos['nombre']);
		$this->setApellido($datos['apellido']);
    }
	
	public function getNrodoc(){
		return $this->nrodoc;
	}
	public function getNombre(){
		return $this->nombre ;
	}
	public function getApellido(){
		return $this->apellido ;
	}
	public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}

    public function setNroDoc($NroDNI){
		$this->nrodoc=$NroDNI;
	}
	public function setNombre($Nom){
		$this->nombre=$Nom;
	}
	public function setApellido($Ape){
		$this->apellido=$Ape;
	}
	public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}
		
	public function __toString(){
        return "  Numero Documento: " . $this->getNrodoc() . "\n" .
               "  Nombre: " . $this->getNombre() . "\n" .
               "  Apellido: " . $this->getApellido() . "\n"; 
    }
	
    public function Buscar($dni){
		$base = new BaseDatos();
		$consultaPersona = "SELECT * FROM persona WHERE nrodoc = " . $dni;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){
				if($row2=$base->Registro()){					
				    $this->setNrodoc($dni);
					$this->setNombre($row2['nombre']);
					$this->setApellido($row2['apellido']);
					$resp= true;
				}				
		 	}else {
		 		$this->setmensajeoperacion($base->getError());
			}
		}else{
		 	$this->setmensajeoperacion($base->getError());
		 	
		}		
		return $resp;
	}	

	public function listar($condicion=""){
	    $arregloPersonas = array();
		$base = new BaseDatos();
		$consultaPersonas = "SELECT * FROM persona ";
		if($condicion != ""){
		    $consultaPersonas = $consultaPersonas . ' WHERE ' . $condicion;
		}
		$consultaPersonas.=" ORDER by nrodoc ";
		
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersonas)){
				while($row2=$base->Registro()){
					$perso = new Persona();
					$perso->buscar($row2['nrodoc']);
					$arregloPersonas [] = $perso;
				}
		 	}else{
		 		$this->setmensajeoperacion($base->getError());	
			}
		}else{
		 		$this->setmensajeoperacion($base->getError());
		}	
		return $arregloPersonas;
	}
	
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO persona(nrodoc,nombre,apellido) 
				VALUES (".$this->getNrodoc().",'".$this->getNombre()."','".$this->getApellido()."')";
		
		if($base->Iniciar()){
			if($base->Ejecutar($consultaInsertar)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());		
			}
		}else{
			$this->setmensajeoperacion($base->getError());
		}
		return $resp;
	}
	
	public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModifica="UPDATE persona SET nombre='".$this->getNombre()."', apellido='".$this->getApellido()."'
                           WHERE nrodoc=". $this->getNrodoc();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
			}
		}else{
			$this->setmensajeoperacion($base->getError());
		}
		return $resp;
	}
	
	public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM persona WHERE nrodoc=".$this->getNrodoc();
				if($base->Ejecutar($consultaBorra)){
				    $resp=  true;
				}else{
					$this->setmensajeoperacion($base->getError());
				}
		}else{
			$this->setmensajeoperacion($base->getError());
		}
		return $resp; 
	}
}
?>