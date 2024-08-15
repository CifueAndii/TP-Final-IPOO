<?php
class Viaje{
    private $idViaje;
    private $destino;
    private $cantMaxPasajeros;
    private $objEmpresa;
    private $objResponsable;
    private $importe;
    private $colObjPasajeros;
    private $mensajeOperacion;

    public function __construct(){
        $this->idViaje = 0;
        $this->destino = "";
        $this->cantMaxPasajeros = "";
        $this->objEmpresa = new Empresa();
        $this->objResponsable = new Responsable();
        $this->importe = "";
        $this->colObjPasajeros = [];
    }

    public function cargar($idViaje,$destino,$cantidadMax,$empresa,$responsable,$importe){
        $this->setIdViaje($idViaje);
        $this->setDestino($destino);
        $this->setCantMaxPasajeros($cantidadMax);
        $this->setObjEmpresa($empresa);
        $this->setObjResponsable($responsable);
        $this->setImporte($importe);
    }

    public function getIdViaje(){
        return $this->idViaje;
    }
    public function getDestino(){
        return $this->destino;
    }
    public function getCantMaxPasajeros(){
        return $this->cantMaxPasajeros;
    }
    public function getObjEmpresa(){
        return $this->objEmpresa;
    }
    public function getObjResponsable(){
        return $this->objResponsable;
    }
    public function getImporte(){
        return $this->importe;
    }
    public function getColObjPasajeros(){
        return $this->colObjPasajeros;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    public function setIdViaje($id){
        $this->idViaje = $id;
    }
    public function setDestino($destino){
        $this->destino = $destino;
    }
    public function setCantMaxPasajeros($cantidadMax){
        $this->cantMaxPasajeros = $cantidadMax;
    }
    public function setObjEmpresa($empresa){
        $this->objEmpresa = $empresa;
    }
    public function setObjResponsable($responsable){
        $this->objResponsable = $responsable;
    }
    public function setImporte($importe){
        $this->importe = $importe;
    }
    public function setColObjPasajeros($pasajeros){
        $this->colObjPasajeros = $pasajeros;
    }
    public function setMensajeOperacion($mensaje){
        $this->mensajeOperacion = $mensaje;
    }

    public function __toString(){
        return " Id Viaje: " . $this->getIdViaje() . "\n" .
               " Destino: " . $this->getDestino() . "\n" .
               " Cant. Maxima de Pasajeros: " . $this->getCantMaxPasajeros() . "\n" .
               " \nEmpresa \n" . $this->getObjEmpresa() . "\n" .
               " Responsable \n" . $this->getObjResponsable() . "\n" .
               " Importe: " . $this->getImporte() . "\n" .
               " \n Pasajeros \n" . $this->mostrarPasajeros();
    }

    public function mostrarPasajeros(){
        $arrPasajeros = $this->getColObjPasajeros();
        $cadena = "";
        $nPasaj = 1;
        for($i=0;$i<$this->cantPasajeros();$i++){
            $unPasajero = $arrPasajeros[$i];
            $cadena = $cadena . "  Pasajero " . $nPasaj . ": \n" . $unPasajero ."\n";
            $nPasaj++;
        }
        return $cadena;
    }

    public function cantPasajeros(){
        $cantPasajeros = count($this->getColObjPasajeros());
        return $cantPasajeros;
    }

    public function buscar($id){
		$base = new BaseDatos();
		$consultaViaje = "SELECT * FROM viaje WHERE idviaje = " . $id;
		$resp = false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaViaje)){
				if($fila = $base->Registro()){
				    $this->setIdViaje($id);
					$this->setDestino($fila['vdestino']);
					$this->setCantMaxPasajeros($fila['vcantmaxpasajeros']);
                    $objEmpresa = new Empresa();
                    $objEmpresa->buscar($fila['idempresa']);
                    $this->setObjEmpresa($objEmpresa);
                    $objResponsable = new Responsable();
                    $objResponsable->buscar($fila['nrodoc']);
                    $this->setObjResponsable($objResponsable);
                    $this->setImporte($fila['vimporte']);
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
	    $colViajes = array();
		$base = new BaseDatos();
		$consultaViaje = "SELECT * FROM viaje ";
		if($condicion != ""){
		    $consultaViaje .= " WHERE " . $condicion;
		}
		$consultaViaje .= " ORDER BY idviaje ";

		if($base->Iniciar()){
			if($base->Ejecutar($consultaViaje)){
				while($fila = $base->Registro()){
					$objViaje = new Viaje();
					$objViaje->buscar($fila['idviaje']);
					$colViajes [] = $objViaje;
				}
		 	}else{
		 		$this->setMensajeOperacion($base->getError());
			}
		}else{
		 	$this->setMensajeOperacion($base->getError());
		}	
		return $colViajes;
    }

    public function insertar(){
		$base = new BaseDatos();
		$resp = false;
		$consultaInsertar = "INSERT INTO viaje(vdestino,vcantmaxpasajeros,idempresa,nrodoc,vimporte) 
				VALUES ('".$this->getDestino()."',".$this->getCantMaxPasajeros().",".$this->getObjEmpresa()->getIdEmpresa().",".$this->getObjResponsable()->getNrodoc().",".$this->getImporte().")";
		
        if($base->Iniciar()){
            if($codigo = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setIdViaje($codigo);
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
		$consultaModificar = "UPDATE viaje SET vdestino = '".$this->getDestino()."',vcantmaxpasajeros = " .$this->getCantMaxPasajeros().",idempresa = " .$this->getObjEmpresa()->getIdEmpresa().",
                           nrodoc = ".$this->getObjResponsable()->getNrodoc().",vimporte = " .$this->getImporte()." WHERE idviaje = " .$this->getIdViaje();
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
			$consultaBorrar = "DELETE FROM viaje WHERE idviaje = ".$this->getIdViaje();
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
?>