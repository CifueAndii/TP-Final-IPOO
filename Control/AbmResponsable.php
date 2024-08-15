<?php
    class AbmResponsable{
        /**
         * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
         * @param array $param
         * @return Responsable
         */
        private function cargarObjeto($param){
            $objResponsable = null;

            if (array_key_exists('nrodoc',$param) and array_key_exists('nombre',$param) and array_key_exists('apellido',$param) and array_key_exists('rnumeroempleado',$param) and array_key_exists('rnumerolicencia',$param)) {
                $objResponsable = new Responsable();
                $objResponsable->cargar($param);
            }
            return $objResponsable;
        }

        /**
         * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
         * @param array $param
         * @return Responsable
         */
        private function cargarObjetoConClave($param){
            $objResponsable = null;
            $param['nombre'] = null;
            $param['apellido'] = null;
            $param['rnumeroempleado'] = null;
            $param['rnumerolicencia'] = null;

            if (isset($param['nrodoc']) ) {
                $objResponsable = new Responsable();
                $objResponsable->cargar($param);
            }
            return $objResponsable;
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
            $objResponsable = $this->cargarObjeto($param);
            if($objResponsable != null and $objResponsable->insertar()) {
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
                $objResponsable = $this->cargarObjetoConClave($param);
                if($objResponsable != null and $objResponsable->eliminar()) {
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
                $objResponsable = $this->cargarObjeto($param);
                if($objResponsable != null and $objResponsable->modificar()) {
                    $resp = true;
                }
            }
            return $resp;
        }

        /**
         * Obtiene todos los Responsables de la BD
         * @return array
         */
        public function obtenerResponsables(){
            $objResponsable = new Responsable();
            $col = $objResponsable->listar("");
            return $col;
        }

        /**
         * Obtiene un Responsable buscado por su documento
         * @param array $param
         * @return object Responsable
         */
        public function obtenerResponsable($param){
            $objResponsable = $this->cargarObjetoConClave($param);
            $res = $objResponsable->buscar($param['nrodoc']);
            if(!$res){
                $objResponsable = null;
            }
            return $objResponsable;
        }

        /**
         * Busca si un Responsable se encuentra en la BD
         * @param array $param
         * @return boolean
         */
        public function buscarResponsable($param){
            $objResponsable = $this->obtenerResponsable($param);
            $res = false;

            if($objResponsable != null){
                $res = true;
            }
            return $res;
        }
    }
?>