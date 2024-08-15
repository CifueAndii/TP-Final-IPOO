<?php
    class AbmViaje{
        /**
         * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
         * @param array $param
         * @return Viaje
         */
        private function cargarObjeto($param){
            $objViaje = null;

            if (array_key_exists('idviaje',$param) and array_key_exists('vdestino',$param) and array_key_exists('vcantmaxpasajeros',$param) and array_key_exists('idempresa',$param) and array_key_exists('nrodoc',$param) and array_key_exists('vimporte',$param)) {
                $objViaje = new Viaje();
                $objEmpresa = new Empresa();
                $objEmpresa->buscar($param['idempresa']);
                $objResponsable = new Responsable();
                $objResponsable->buscar($param['nrodoc']);
                $objViaje->cargar($param['idviaje'],$param['vdestino'],$param['vcantmaxpasajeros'],$objEmpresa,$objResponsable,$param['vimporte']);
            }
            return $objViaje;
        }

        /**
         * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
         * @param array $param
         * @return Viaje
         */
        private function cargarObjetoConClave($param){
            $objViaje = null;
            if (isset($param['idviaje']) ) {
                $objViaje = new Viaje();
                $objViaje->cargar($param['idviaje'],null,null,null,null,null);
            }
            return $objViaje;
        }

        /**
         * Corrobora que dentro del arreglo asociativo están seteados los campos claves
         * @param array $param
         * @return boolean
         */
        private function seteadosCamposClaves($param){
            $resp = false;
            if (isset($param['idviaje'])) {
                $resp = true;
            }
            return $resp;
        }

        /**
         * Permite ingresar un objeto
         * @param array $param
         */
        public function alta($param){
            $resp['rta'] = false;
            $param['idviaje'] = null;
            $objViaje = $this->cargarObjeto($param);
            if($objViaje != null and $objViaje->insertar()) {
                $resp['rta'] = true;
                $resp['idviaje'] = $objViaje->getIdViaje();
            }
            return $resp;
        }

        /**
         * Permite eliminar un objeto 
         * @param array $param
         * @return boolean
         */
        public function baja($param){
            $resp = false;
            if($this->seteadosCamposClaves($param)) {
                $objViaje = $this->cargarObjetoConClave($param);
                if($objViaje != null and $objViaje->eliminar()) {
                    $resp = true;
                }
            }
            return $resp;
        }

        /**
         * Permite modificar un objeto
         * @param array $param
         * @return boolean
         */
        public function modificacion($param){
            $resp = false;
            if($this->seteadosCamposClaves($param)) {
                $objViaje = $this->cargarObjeto($param);
                if($objViaje != null and $objViaje->modificar()) {
                    $resp = true;
                }
            }
            return $resp;
        }

        /**
         * Busca si un Pasajero ya se encuentra en la BD
         * @param int
         * @param array $param
         * @return int
         */
        public function buscarPasajero($documento,$param){
            $viaje = $this->actualizarPasajerosViaje($param,[]);
            $arrPasajeros = $viaje->getColObjPasajeros();
            $encontrado = false;
            $i = 0;
            if(count($arrPasajeros) > 0){
                while($i<count($arrPasajeros) && !$encontrado){
                    $unPasajero = $arrPasajeros[$i];
                    if($unPasajero->getNrodoc() == $documento){
                        $encontrado = true;
                    }else{
                        $i++;
                    }
                }
            }
            if(!$encontrado){
                $i = -1;
            }
            return $i;
        }

        /**
         * Verifica si un Pasajero ya se encuentra en la BD
         * @param int
         * @param array $param
         * @return boolean
         */
        public function pasajeroYaCargado($doc,$param){
            if($this->buscarPasajero($doc,$param) != -1){
                $pasajCargado = true;
            }else{
                $pasajCargado = false;
            }
            return $pasajCargado;
        }

        /**
         * Verifica si hay pasaje disponible en el viaje
         * @param array $param
         * @return boolean
         */
        public function hayPasaje($param){
            $pasajeros = $this->getColPasajeros($param);
            $viaje = $this->obtenerViaje($param);
            if(count($pasajeros) < $viaje->getCantMaxPasajeros()){
                $hayPasaje = true;
            }else{
                $hayPasaje = false;
            }
            return $hayPasaje;
        }

        /**
         * Actualiza el Viaje con sus respectivos Pasajeros
         * @param array $param
         * @param array
         * @return object Viaje
         */
        public function actualizarPasajerosViaje($param,$pasaj){
            $base = new BaseDatos();
            $colObjPasajeros = $pasaj;
            $viaje = $this->cargarObjetoConClave($param);
            $consultaPasajeros = "idviaje = ". $param['idviaje'];

            if($base->iniciar()){
                $objPasajero = new Pasajero();
                $colObjPasajeros = $objPasajero->listar($consultaPasajeros);
                if(is_array($colObjPasajeros)){
                    $viaje->setColObjPasajeros($colObjPasajeros);
                }else{
                    $viaje->setMensajeOperacion($base->getError());
                }
            }else{
                $viaje->setMensajeOperacion($base->getError());
            }
            return $viaje;
        }

        /**
         * Obtiene los Pasajeros del Viaje
         * @param array $param
         * @return array
         */
        public function getColPasajeros($param){
            $viaje = $this->actualizarPasajerosViaje($param,[]);
            $pasaj = $viaje->getColObjPasajeros();
            return $pasaj;
        }

        /**
         * Obtiene todos los Viajes de la BD
         * @return array
         */        
        public function obtenerViajes(){
            $objViaje = new Viaje();
            $col = $objViaje->listar("");
            return $col;
        }

        /**
         * Obtiene un Viaje buscado por su id
         * @param array $param
         * @return object Viaje
         */        
        public function obtenerViaje($param){
            $objViaje = $this->actualizarPasajerosViaje($param,[]);
            $res = $objViaje->buscar($param['idviaje']);
            //print_r($objViaje);
            if(!$res){
                $objViaje = null;
            }
            return $objViaje;
        }

        /**
         * Busca si un Viaje se encuentra en la BD
         * @param array $param
         * @return boolean
         */        
        public function buscarViaje($param){
            $objViaje = $this->cargarObjetoConClave($param);
            $res = $objViaje->buscar($param['idviaje']);
            return $res;
        }

        /**
         * Agrega un Pasajero al Viaje
         * @param array $param
         * @return boolean
         */
        public function agregarPasajero($param){
            $res = false;
            $pasajeros = $this->getColPasajeros($param);
            $pasajeros[] = $param;
            $viaje = $this->actualizarPasajerosViaje($param,$pasajeros);
            if(count($pasajeros) < count($viaje->getColObjPasajeros())){
                $res = true;
            }
            return $res;
        }

        /**
         * Busca si una Empresa contiene Viajes
         * @param int
         * @return boolean
         */        
        public function encontrarEmpresa($idempresa){
            $viajes = $this->obtenerViajes();
            $i = 0;
            $resp = false;
            
            while(!$resp && $i < count($viajes)){
                $unViaje = $viajes[$i];
                $idEmpresa = $unViaje->getObjEmpresa()->getIdEmpresa();
                if($idEmpresa == $idempresa){
                    $resp = true;
                }
                $i++;
            }
            return $resp;
        }

        /**
         * Busca si un Responsable esta a cargo de Viajes
         * @param int
         * @return boolean
         */ 
        public function encontrarResponsable($doc){
            $viajes = $this->obtenerViajes();
            $i = 0;
            $resp = false;
            
            while(!$resp && $i < count($viajes)){
                $unViaje = $viajes[$i];
                $numDoc = $unViaje->getObjResponsable()->getNrodoc();
                if($numDoc == $doc){
                    $resp = true;
                }
                $i++;
            }
            return $resp;
        }
    }
?>