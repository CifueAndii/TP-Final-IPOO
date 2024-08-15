<?php
    class AbmEmpresa{
        /**
         * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
         * @param array $param
         * @return Empresa
         */
        private function cargarObjeto($param){
            $objEmpresa = null;

            if (array_key_exists('idempresa',$param) and array_key_exists('enombre',$param) and array_key_exists('edireccion',$param)) {
                $objEmpresa = new Empresa();
                $objEmpresa->cargar($param['idempresa'],$param['enombre'],$param['edireccion']);
            }
            return $objEmpresa;
        }

        /**
         * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
         * @param array $param
         * @return Empresa
         */
        private function cargarObjetoConClave($param){
            $objEmpresa = null;

            if (isset($param['idempresa']) ) {
                $objEmpresa = new Empresa();
                $objEmpresa->cargar($param['idempresa'],null,null);
            }
            return $objEmpresa;
        }

        /**
         * Corrobora que dentro del arreglo asociativo están seteados los campos claves
         * @param array $param
         * @return boolean
         */
        private function seteadosCamposClaves($param){
            $resp = false;
            if (isset($param['idempresa'])) {
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
            $param['idempresa'] = null;
            $objEmpresa = $this->cargarObjeto($param);

            if($objEmpresa != null and $objEmpresa->insertar()) {
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
                $objEmpresa = $this->cargarObjetoConClave($param);
                if($objEmpresa != null and $objEmpresa->eliminar()) {
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
                $objEmpresa = $this->cargarObjeto($param);
                if($objEmpresa != null and $objEmpresa->modificar()) {
                    $resp = true;
                }
            }
            return $resp;
        }

        /**
         * Obtiene todas las Empresas de la BD
         * @return array
         */
        public function obtenerEmpresas(){
            $objEmpresa = new Empresa();
            $col = $objEmpresa->listar("");
            return $col;
        }

        /**
         * Obtiene una Empresa buscada por su id
         * @param array $param
         * @return object Empresa
         */
        public function obtenerEmpresa($param){
            $objEmpresa = $this->cargarObjetoConClave($param);
            $res = $objEmpresa->buscar($param['idempresa']);
            if(!$res){
                $objEmpresa = null;
            }
            return $objEmpresa;
        }

        /**
         * Busca si una Empresa se encuentra en la BD
         * @param array $param
         * @return boolean
         */
        public function buscarEmpresa($param){
            $objEmpresa = $this->obtenerEmpresa($param);
            $res = false;

            if($objEmpresa != null){
                $res = true;
            }
            return $res;
        }
    }
?>