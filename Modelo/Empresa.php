<?php
class Empresa{
    private $idEmpresa;
    private $nombre;
    private $direccion;
    private $mensajeOperacion;

    public function __construct(){
        $this->idEmpresa = 0;
        $this->nombre = "";
        $this->direccion = "";
    }

    public function cargar($id,$nombre,$direccion){
        $this->setIdEmpresa($id);
        $this->setNombre($nombre);
        $this->setDireccion($direccion);
    }

    public function getIdEmpresa() {
        return $this->idEmpresa;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getDireccion(){
        return $this->direccion;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    public function setIdEmpresa($id) {
        $this->idEmpresa = $id;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function setDireccion($direccion){
        $this->direccion = $direccion;
    }
    public function setMensajeOperacion($mensaje){
        $this->mensajeOperacion = $mensaje;
    }

    public function __toString(){
        return "  Id: " . $this->getIdEmpresa() . "\n" .
               "  Nombre: " . $this->getNombre() . "\n" .
               "  Direccion: " . $this->getDireccion() . "\n";
    }

    public function buscar($id){
		$base = new BaseDatos();
		$consultaEmpresa = "SELECT * FROM empresa WHERE idempresa = " . $id;
		$resp = false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaEmpresa)){
				if($fila = $base->Registro()){
				    $this->setIdEmpresa($id);
					$this->setNombre($fila['enombre']);
					$this->setDireccion($fila['edireccion']);
					$resp= true;
				}				
		 	}else{
		 		$this->setMensajeOperacion($base->getError());
			}
		}else{
		 	$this->setMensajeOperacion($base->getError()); 	
		}		
		return $resp;
	}

	public function listar($condicion = ""){
	    $colEmpresas = array();
		$base = new BaseDatos();
		$consultaEmpresa = "SELECT * FROM empresa ";
		if($condicion != ""){
		    $consultaEmpresa .= " WHERE " . $condicion;
		}
		$consultaEmpresa .= " ORDER BY idempresa ";
		
		if($base->Iniciar()){
			if($base->Ejecutar($consultaEmpresa)){
				while($fila = $base->Registro()){
					$objEmpresa = new Empresa();
					$objEmpresa->buscar($fila['idempresa']);
					$colEmpresas [] = $objEmpresa;
				}
		 	}else{
		 		$this->setMensajeOperacion($base->getError());
			}
		}else{
		 	$this->setMensajeOperacion($base->getError());
		}	
		return $colEmpresas;
    }

    public function insertar(){
		$base = new BaseDatos();
		$resp = false;
		$consultaInsertar = "INSERT INTO empresa(enombre,edireccion) 
				VALUES ('".$this->getNombre()."','".$this->getDireccion()."')";
		
        if($base->Iniciar()){
            if($id = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setIdEmpresa($id);
			    $resp = true;
			}else{
				$this->setMensajeOperacion($base->getError());		
			}
		}else{
			$this->setMensajeOperacion($base->getError());	
		}
		return $resp;
    }

	public function modificar(){
	    $resp = false; 
	    $base = new BaseDatos();
		$consultaModificar = "UPDATE empresa SET enombre = '".$this->getNombre()."',edireccion = '" .$this->getDireccion()."' WHERE idempresa = ".$this->getIdEmpresa();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModificar)){
			    $resp = true;
			}else{
				$this->setMensajeOperacion($base->getError());
			}
		}else{
			$this->setMensajeOperacion($base->getError());
		}
		return $resp;
	}
	
	public function eliminar(){
		$base = new BaseDatos();
		$resp = false;
		if($base->Iniciar()){
			$consultaBorrar = "DELETE FROM empresa WHERE  idempresa = ".$this->getIdEmpresa();
			if($base->Ejecutar($consultaBorrar)){
				$resp=  true;
			}else{
				$this->setMensajeOperacion($base->getError());
			}
		}else{
			$this->setMensajeOperacion($base->getError());
		}
		return $resp; 
	}
}
