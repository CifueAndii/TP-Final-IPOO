<?php
    class AbmPasajero{
        /**
         * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
         * @param array $param
         * @return Pasajero
         */
        private function cargarObjeto($param){
            $objPasajero = null;

            if (array_key_exists('nrodoc',$param) and array_key_exists('nombre',$param) and array_key_exists('apellido',$param) and array_key_exists('ptelefono',$param) and array_key_exists('idviaje',$param)) {
                $objPasajero = new Pasajero();
                $objViaje = new Viaje();
                $objViaje->buscar($param['idviaje']);
                $param['idviaje'] = $objViaje;
                $objPasajero->cargar($param);
            }
            return $objPasajero;
        }

        /**
         * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
         * @param array $param
         * @return Pasajero
         */
        private function cargarObjetoConClave($param){
            $objPasajero = null;
            $param['nombre'] = null;
            $param['apellido'] = null;
            $param['ptelefono'] = null;
            $param['idviaje'] = null;

            if (isset($param['nrodoc']) ) {
                $objPasajero = new Pasajero();
                $objPasajero->cargar($param);
            }
            return $objPasajero;
        }

        /**
         * Corrobora que dentro del arreglo asociativo están seteados los campos claves
         * @param array $param
         * @return boolean
         */
        private function seteadosCamposClaves($param){
            $resp = false;
            if (isset($param['nrodoc'])) {
                $resp = true;
            }
            return $resp;
        }

        /**
         * Permite ingresar un objeto
         * @param array $param
         */
        public function alta($param){
            $resp = false;
            $objPasajero = $this->cargarObjeto($param);
            if($objPasajero != null and $objPasajero->insertar()) {
                $resp = true;
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
                $objPasajero = $this->cargarObjetoConClave($param);
                if($objPasajero != null and $objPasajero->eliminar()) {
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
                $objPasajero = $this->cargarObjeto($param);
                if($objPasajero != null and $objPasajero->modificar()) {
                    $resp = true;
                }
            }
            return $resp;
        }

        /**
         * Obtiene todos los Pasajeros de la BD
         * @return array
         */
        public function obtenerPasajeros(){
            $objPasajero = new Pasajero();
            $col = $objPasajero->listar("");
            return $col;
        }

        /**
         * Obtiene un Pasajero buscado por su documento
         * @param array $param
         * @return object Pasajero
         */
        public function obtenerPasajero($param){
            $objPasajero = $this->cargarObjetoConClave($param);
            $res = $objPasajero->buscar($param['nrodoc']);
            if(!$res){
                $objPasajero = null;
            }
            return $objPasajero;
        }

        /**
         * Busca si un Pasajero se encuentra en la BD
         * @param array $param
         * @return boolean
         */
        public function buscarPasajero($param){
            $objPasajero = new Pasajero();
            $res = $objPasajero->buscar($param);
            return $res;
        }
    }
?>