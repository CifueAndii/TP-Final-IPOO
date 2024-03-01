<?php
class ResponsableV{
    private $numEmpleado;
    private $numLicencia;
    private $nombre;
    private $apellido;
    private $mensajeOperacion;

    public function __construct(){
        $this->numEmpleado = 0;
        $this->numLicencia = "";
        $this->nombre = "";
        $this->apellido = "";
    }

    public function cargar($nroE,$nroL,$nombre,$apellido){
        $this->setNumEmpleado($nroE);
        $this->setNumLicencia($nroL);
        $this->setNombre($nombre);
        $this->setApellido($apellido);
    }

    public function getNumEmpleado(){
        return $this->numEmpleado;
    }
    public function getNumLicencia(){
        return $this->numLicencia;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getApellido(){
        return $this->apellido;
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
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function setApellido($apellido){
        $this->apellido = $apellido;
    }
    public function setMensajeOperacion($mensaje){
        $this->mensajeOperacion = $mensaje;
    }

    public function __toString(){
        return "  Numero Empleado: " . $this->getNumEmpleado() . "\n" .
               "  Numero Licencia: " . $this->getNumLicencia() . "\n" .
               "  Nombre: " . $this->getNombre() . "\n" .
               "  Apellido: " . $this->getApellido() . "\n"; 
    }

    /** Recupera los datos de un responsable de viaje por $numEmpleado
	 * @param int $numEmpleado
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */
    public function buscar($numEmpleado){
		$base = new BaseDatos();
		$consultaResponsable = "SELECT * FROM responsable WHERE rnumeroempleado = " . $numEmpleado;
		$resp = false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaResponsable)){
				if($fila = $base->Registro()){
				    $this->setNumEmpleado($numEmpleado);
                    $this->setNumLicencia($fila['rnumerolicencia']);
					$this->setNombre($fila['rnombre']);
					$this->setApellido($fila['rapellido']);
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
	    $colResponsables = null;
		$base = new BaseDatos();
		$consultaResponsable = "SELECT * FROM responsable ";
		if($condicion != ""){
		    $consultaResponsable .= " WHERE " . $condicion;
		}
		$consultaResponsable .= " ORDER BY rapellido ";
		//echo $consultaResponsable;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaResponsable)){				
				$colResponsables = array();
				while($fila = $base->Registro()){
					$objResponsable = new ResponsableV();
					$objResponsable->buscar($fila['rnumeroempleado']);
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
		$consultaInsertar = "INSERT INTO responsable(rnumerolicencia,rnombre,rapellido) 
				VALUES (".$this->getNumLicencia().",'".$this->getNombre()."','".$this->getApellido()."')";
		
        if($base->Iniciar()){
            if($nro = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setNumEmpleado($nro);
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
		$consultaModificar = "UPDATE responsable SET rnumerolicencia = ".$this->getNumLicencia().",rnombre = '".$this->getNombre()."',
                           rapellido = '" .$this->getApellido()."' WHERE rnumeroempleado = ".$this->getNumEmpleado();
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
			$consultaBorrar = "DELETE FROM responsable WHERE  rnumeroempleado = ".$this->getNumEmpleado();
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