<?php
class Responsable extends Persona{
    private $numEmpleado;
    private $numLicencia;
    private $mensajeOperacion;

    public function __construct(){
		parent::__construct();
        $this->numEmpleado = 0;
        $this->numLicencia = "";
    }

    public function cargar($datos){
		parent::cargar($datos);
        $this->setNumEmpleado($datos['rnumeroempleado']);
        $this->setNumLicencia($datos['rnumerolicencia']);
    }

    public function getNumEmpleado(){
        return $this->numEmpleado;
    }
    public function getNumLicencia(){
        return $this->numLicencia;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    public function setNumEmpleado($nEmpleado){
        $this->numEmpleado = $nEmpleado;
    }
    public function setNumLicencia($nLicencia){
        $this->numLicencia = $nLicencia;
    }
    public function setMensajeOperacion($mensaje){
        $this->mensajeOperacion = $mensaje;
    }

    public function __toString(){
        return parent::__toString().
			   "  Numero Empleado: " . $this->getNumEmpleado() . "\n" .
               "  Numero Licencia: " . $this->getNumLicencia() . "\n";
               
    }

    public function buscar($dni){
		$base = new BaseDatos();
		$consultaResponsable = "SELECT * FROM responsable WHERE nrodoc = " . $dni;
		$resp = false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaResponsable)){
				if($fila = $base->Registro()){
					parent::buscar($dni);
				    $this->setNumEmpleado($fila['rnumeroempleado']);
                    $this->setNumLicencia($fila['rnumerolicencia']);
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
	    $colResponsables = array();
		$base = new BaseDatos();
		$consultaResponsable = "SELECT * FROM responsable ";
		if($condicion != ""){
		    $consultaResponsable .= " WHERE " . $condicion;
		}
		$consultaResponsable .= " ORDER BY nrodoc ";
		
		if($base->Iniciar()){
			if($base->Ejecutar($consultaResponsable)){
				while($fila = $base->Registro()){
					$objResponsable = new Responsable();
					$objResponsable->buscar($fila['nrodoc']);
					$colResponsables [] = $objResponsable;
				}
		 	}else{
		 		$this->setMensajeOperacion($base->getError());
			}
		}else{
		 	$this->setMensajeOperacion($base->getError());
		}	
		return $colResponsables;
    }

    public function insertar(){
		$base = new BaseDatos();
		$resp = false;

		if(parent::insertar()){
			$consultaInsertar = "INSERT INTO responsable(nrodoc,rnumeroempleado,rnumerolicencia) 
				VALUES (".$this->getNrodoc().",".$this->getNumEmpleado().",".$this->getNumLicencia().")";
		
        	if($base->Iniciar()){
            	if($base->Ejecutar($consultaInsertar)){
			    	$resp = true;
				}else{
					$this->setMensajeOperacion($base->getError());		
				}
			}else{
				$this->setMensajeOperacion($base->getError());	
			}
		}
		return $resp;
    }

	public function modificar(){
	    $resp = false; 
	    $base = new BaseDatos();

		if(parent::modificar()){
			$consultaModificar = "UPDATE responsable SET rnumeroempleado = ".$this->getNumEmpleado().", rnumerolicencia = ".$this->getNumLicencia()."
                            WHERE nrodoc = ".$this->getNrodoc();
			if($base->Iniciar()){
				if($base->Ejecutar($consultaModificar)){
			    	$resp = true;
				}else{
					$this->setMensajeOperacion($base->getError());
				}
			}else{
				$this->setMensajeOperacion($base->getError());
			}
		}
		return $resp;
	}
	
	public function eliminar(){
		$base = new BaseDatos();
		$resp = false;
		if($base->Iniciar()){
			$consultaBorrar = "DELETE FROM responsable WHERE nrodoc = ".$this->getNrodoc();
			if($base->Ejecutar($consultaBorrar)){
				if(parent::eliminar()){
					$resp = true;
				}
			}else{
				$this->setMensajeOperacion($base->getError());
			}
		}else{
			$this->setMensajeOperacion($base->getError());
		}
		return $resp; 
	}
}
?>