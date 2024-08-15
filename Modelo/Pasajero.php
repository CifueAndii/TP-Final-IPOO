<?php
class Pasajero extends Persona{
    private $telefono;
    private $objViaje;
    private $mensajeOperacion;

    public function __construct(){
        parent::__construct();
        $this->telefono = "";
        $this->objViaje = new Viaje();
    }

    public function cargar($datos){
        parent::cargar($datos);
        $this->setTelefono($datos['ptelefono']);
        $this->setObjViaje($datos['idviaje']);
    }

    public function getTelefono(){
        return $this->telefono;
    }
    public function getObjViaje(){
        return $this->objViaje;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    public function setTelefono($telefono){
        $this->telefono = $telefono;
    }
    public function setObjViaje($id){
        $this->objViaje = $id;
    }
    public function setMensajeOperacion($mensaje){
        $this->mensajeOperacion = $mensaje;
    }

    public function __toString(){
        return parent::__toString().
               "  Telefono: " . $this->getTelefono() . "\n" .
               "  Codigo Viaje: " . $this->getObjViaje()->getIdViaje() . "\n";
    }

    public function buscar($dni){
		$base = new BaseDatos();
		$consultaPasajero = "SELECT * FROM pasajero WHERE nrodoc = " . $dni;
		$resp = false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPasajero)){
				if($fila = $base->Registro()){
				    parent::buscar($dni);
					$this->setTelefono($fila['ptelefono']);

                    $objViaje = new Viaje();
                    $objViaje->buscar($fila['idviaje']);
                    $this->setObjViaje($objViaje);
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
	    $colPasajeros = array();
		$base = new BaseDatos();
		$consultaPasajero = "SELECT * FROM pasajero ";
		if($condicion != ""){
		    $consultaPasajero .= " WHERE " . $condicion;
		}
		$consultaPasajero .= " ORDER BY nrodoc ";
		
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPasajero)){
				while($fila = $base->Registro()){
					$objPasajero = new Pasajero();
					$objPasajero->buscar($fila['nrodoc']);
					$colPasajeros [] = $objPasajero;
				}
		 	}else{
		 		$this->setMensajeOperacion($base->getError());
			}
		}else{
		 	$this->setMensajeOperacion($base->getError());
		}	
		return $colPasajeros;
    }

    public function insertar(){
		$base = new BaseDatos();
		$resp = false;

        if(parent::insertar()){
		    $consultaInsertar = "INSERT INTO pasajero(nrodoc,ptelefono,idviaje) 
				VALUES (".$this->getNroDoc().",".$this->getTelefono().",".$this->getObjViaje()->getIdViaje().")";
		
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
		    $consultaModificar = "UPDATE pasajero SET ptelefono = ".$this->getTelefono().",idviaje = ".$this->getObjViaje()->getIdViaje()."
                        WHERE nrodoc = ".$this->getNroDoc();
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
			$consultaBorrar = "DELETE FROM pasajero WHERE nrodoc = ".$this->getNroDoc();
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