<?php
class Pasajero{
    private $numDocumento;
    private $nombre;
    private $apellido;
    private $telefono;
    private $objViaje;
    private $mensajeOperacion;

    public function __construct(){
        $this->numDocumento = "";
        $this->nombre = "";
        $this->apellido = "";
        $this->telefono = "";
        $this->objViaje = new Viaje();
    }

    public function cargar($dni,$nombre,$apellido,$telefono,$viaje){
        $this->setNumDocumento($dni);
        $this->setNombre($nombre);
        $this->setApellido($apellido);
        $this->setTelefono($telefono);
        $this->setObjViaje($viaje);
    }

    public function getNumDocumento(){
        return $this->numDocumento;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getApellido(){
        return $this->apellido;
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

    public function setNumDocumento($dni){
        $this->numDocumento = $dni;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function setApellido($apellido){
        $this->apellido = $apellido;
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
        return "   Nro Documento: " . $this->getNumDocumento() . "\n" .
               "   Nombre: " . $this->getNombre() . "\n" .
               "   Apellido: " . $this->getApellido() . "\n" .
               "   Telefono: " . $this->getTelefono() . "\n" .
               "   Codigo Viaje: " . $this->getObjViaje()->getIdViaje() . "\n";
    }

    /** Recupera los datos de un pasajero por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */
    public function buscar($dni){
		$base = new BaseDatos();
		$consultaPasajero = "SELECT * FROM pasajero WHERE pdocumento = " . $dni;
		$resp = false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPasajero)){
				if($fila = $base->Registro()){
				    $this->setNumDocumento($dni);
					$this->setNombre($fila['pnombre']);
					$this->setApellido($fila['papellido']);
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
	    $colPasajeros = null;
		$base = new BaseDatos();
		$consultaPasajero = "SELECT * FROM pasajero ";
		if($condicion != ""){
		    $consultaPasajero .= " WHERE " . $condicion;
		}
		$consultaPasajero .= " ORDER BY papellido ";
		//echo $consultaPasajero;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPasajero)){				
				$colPasajeros = array();
				while($fila = $base->Registro()){
					$objPasajero = new Pasajero();
					$objPasajero->buscar($fila['pdocumento']);
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
		$consultaInsertar = "INSERT INTO pasajero(pdocumento,pnombre,papellido,ptelefono,idviaje) 
				VALUES (".$this->getNumDocumento().",'".$this->getNombre()."','".$this->getApellido()."',".$this->getTelefono().",".$this->getObjViaje()->getIdViaje().")";
		
        if($base->Iniciar()){
            if($base->Ejecutar($consultaInsertar)){
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
		$consultaModificar = "UPDATE pasajero SET pdocumento = ".$this->getNumDocumento().",pnombre = '".$this->getNombre()."',papellido = '" .$this->getApellido()."',
                           ptelefono = ".$this->getTelefono().",idviaje = ".$this->getObjViaje()->getIdViaje()." WHERE pdocumento = ".$this->getNumDocumento();
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
			$consultaBorrar = "DELETE FROM pasajero WHERE pdocumento = ".$this->getNumDocumento();
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