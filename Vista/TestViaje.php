<?php
    include_once '../Modelo/Conector/BaseDatos.php';
    include_once '../Modelo/Viaje.php';
    include_once '../Control/AbmViaje.php';
    include_once '../Modelo/Persona.php';
    include_once '../Modelo/Pasajero.php';
    include_once '../Control/AbmPasajero.php';
    include_once '../Modelo/Empresa.php';
    include_once '../Control/AbmEmpresa.php';
    include_once '../Modelo/Responsable.php';
    include_once '../Control/AbmResponsable.php';

    /**
    * Separa los datos mostrados por pantalla
    */
    function separador(){
        echo "+++++++++++++++++++++++++++++++++++++++++++++++++++++\n";
    }

    /**
    * Muestra el menu para que el usuario elija y retorna la opcion
    * @return int 
    */
    function menuPrincipal(){
        echo " ____________________________________________________________________________\n";
        echo "|                                      MENU:                                 |\n";
        echo "|                              1) Ingresar Viajes                            |\n";
        echo "|                            2) Ingresar una Empresa                         |\n";
        echo "|                           3) Ingresar un Responsable                       |\n";
        echo "|                             4) Modificar un Viaje                          |\n";
        echo "|                            5) Modificar una Empresa                        |\n";
        echo "|                           6) Modificar un Responsable                      |\n";
        echo "|                              7) Eliminar un Viaje                          |\n";
        echo "|                             8) Eliminar una Empresa                        |\n";
        echo "|                           9) Eliminar un Responsable                       |\n";
        echo "|                                   10) Salir                                |\n";
        echo "|____________________________________________________________________________|\n";
        echo "Opcion: ";
        $opc = trim(fgets(STDIN));
        echo "\n";

        return $opc;
    }

    function menuViajes(){
        echo " ____________________________________________________________________________\n";
        echo "|                                 Menu Viajes:                                |\n";
        echo "|                          1) Ver los datos del viaje                         |\n";
        echo "|                       2) Ver la cantidad de pasajeros                       |\n";
        echo "|                        3) Ver los datos de un pasajero                      |\n";
        echo "|                    4) Ver los datos de todos los pasajeros                  |\n";
        echo "|                     5) Modificar los datos de un pasajero                   |\n";
        echo "|                         6) Agregar pasajeros al viaje                       |\n";
        echo "|                       7) Eliminar un pasajero del viaje                     |\n";
        echo "|                          8) Modificar datos del viaje                       |\n";
        echo "|                          9) Volver al Menu Principal                        |\n";
        echo "|____________________________________________________________________________ |\n";
        echo "Opcion: ";
        $opc = trim(fgets(STDIN));
        echo "\n";

        return $opc;
    }

    function menuModifViaje(){
        echo " ____________________________________________________________________________\n";
        echo "|                                  Menu Viaje:                               |\n";
        echo "|                              1) Modificar Destino                          |\n";
        echo "|                     2) Modificar Cant. Maxima de pasajeros                 |\n";
        echo "|                              3) Modificar Empresa                          |\n";
        echo "|                            4) Modificar Responsable                        |\n";
        echo "|                              5) Modificar Importe                          |\n";
        echo "|                         6) Modificar todos sus Datos                       |\n";
        echo "|                               7) Ver sus Datos                             |\n";
        echo "|                                   8) Salir                                 |\n";
        echo "|____________________________________________________________________________|\n";
        echo "Opcion: ";
        $opc = trim(fgets(STDIN));
        echo "\n";

        return $opc;
    }

    function menuModifPasajero(){
        echo " ____________________________________________________________________________\n";
        echo "|                                 Menu Pasajero:                             |\n";
        echo "|                              1) Modificar Nombre                           |\n";
        echo "|                             2) Modificar Apellido                          |\n";
        echo "|                             3) Modificar Telefono                          |\n";
        echo "|                              4) Modificar Viaje                            |\n";
        echo "|                          5) Modificar todos sus Datos                      |\n";
        echo "|                               6) Ver sus Datos                             |\n";
        echo "|                                   7) Salir                                 |\n";
        echo "|____________________________________________________________________________|\n";
        echo "Opcion: ";
        $opc = trim(fgets(STDIN));
        echo "\n";

        return $opc;
    }

    function menuModifEmpresa(){
        echo " ____________________________________________________________________________\n";
        echo "|                                 Menu Empresa:                              |\n";
        echo "|                              1) Modificar Nombre                           |\n";
        echo "|                             2) Modificar Direccion                         |\n";
        echo "|                         3) Modificar todos sus Datos                       |\n";
        echo "|                               4) Ver sus Datos                             |\n";
        echo "|                                   5) Salir                                 |\n";
        echo "|____________________________________________________________________________|\n";
        echo "Opcion: ";
        $opc = trim(fgets(STDIN));
        echo "\n";

        return $opc;
    }

    function menuModifResponsable(){
        echo " ____________________________________________________________________________\n";
        echo "|                               Menu Responsable:                            |\n";
        echo "|                              1) Modificar Nombre                           |\n";
        echo "|                             2) Modificar Apellido                          |\n";
        echo "|                         3) Modificar Num de Empleado                       |\n";
        echo "|                         4) Modificar Num de Licencia                       |\n";
        echo "|                         5) Modificar todos sus Datos                       |\n";
        echo "|                               6) Ver sus Datos                             |\n";
        echo "|                                   7) Salir                                 |\n";
        echo "|____________________________________________________________________________|\n";
        echo "Opcion: ";
        $opc = trim(fgets(STDIN));
        echo "\n";

        return $opc;
    }

    /**
    * Carga toda la informacion de un viaje a la BD
    * @param int
    */
    function cargarViajes($cant){
        $obj = new AbmViaje();
        $resp = false;

        for($i=0;$i<$cant;$i++){
            echo "\nIngrese el destino del viaje ". ($i+1) .": ";
            $datos['vdestino'] = trim(fgets(STDIN));
            echo "Ingrese la capacidad maxima de pasajeros del viaje ". ($i+1) .": ";
            $datos['vcantmaxpasajeros'] = trim(fgets(STDIN));
            $datos['idempresa'] = pedirEmpresa();
            $datos['nrodoc'] = pedirResponsable();
            echo "\nIngrese el importe del viaje ". ($i+1) .": ";
            $datos['vimporte'] = trim(fgets(STDIN));

            if($rta = $obj->alta($datos)){
                $resp = true;
                cargarPasajeros($obj,$rta);
            }

            if($resp) {
                echo "\nSe cargo correctamente la informacion del viaje!! \n";
            }else{ 
                echo "\nNo se pudo cargar la informacion del viaje!! \n";
            }
        }
    }

    /**
    * Carga pasajeros a un viaje
    * @param object AbmViaje
    * @param array
    */
    function cargarPasajeros($viaje,$resp){
        $ingreso = 's';
        $i = 0;
        echo "\nIngrese los pasajeros: \n";
        while($ingreso == 's'){
            echo "\nPasajero Nro ". ($i+1) . "\n";
            $rta = crearPasajero($viaje,$resp);
            if($rta){
                $i++;
            }
            
            echo "Quiere ingresar mas pasajeros? (s/n): ";
            $ingreso = trim(fgets(STDIN));

            if(!$viaje->hayPasaje($resp)){
                echo "Llego a la capacidad maxima de pasajeros!!\n";
                $ingreso = 'n';
            }
        }
    }

    /**
    * Crea un pasajero en la BD
    * @param object AbmViaje
    * @param array
    */
    function crearPasajero($elViaje,$rta){
        $obj = new AbmPasajero();
        $resp = false;

        echo "Ingrese el documento del pasajero: ";
        $pasajero['nrodoc'] = trim(fgets(STDIN));
        echo "Ingrese el nombre del pasajero: ";
        $pasajero['nombre'] = trim(fgets(STDIN));
        echo "Ingrese el apellido del pasajero: ";
        $pasajero['apellido'] = trim(fgets(STDIN));
        echo "Ingrese el telefono del pasajero: ";
        $pasajero['ptelefono'] = trim(fgets(STDIN));

        $pasajero['idviaje'] = $rta['idviaje'];

        if($elViaje->pasajeroYaCargado($pasajero['nrodoc'],$pasajero)){
            echo "\nEl Pasajero ya esta cargado en el viaje!! \n";
        }else{
            if($obj->alta($pasajero)){
                $resp = true;
            }else{
                echo "\nIngreso MAL los datos o el Documento ya esta cargado en la Base de Datos!! \n";
            }
        }

        if($resp) {
            echo "\nSe cargo correctamente el pasajero al viaje!! \n\n";
        }else{ 
            echo "\nNO se pudo cargar la informacion del pasajero!! \n\n";
        }

        return $resp;
    }

    /**
     * Crea una empresa en la BD
     */
    function cargarEmpresa(){
        $obj = new AbmEmpresa();
        $resp = false;

        echo "Ingrese el nombre de la empresa: ";
        $empresa['enombre'] = trim(fgets(STDIN));
        echo "Ingrese la direccion de la empresa: ";
        $empresa['edireccion'] = trim(fgets(STDIN));
        
        if($obj->alta($empresa)){
            $resp = true;
        }

        if($resp) {
            echo "\nSe cargo correctamente la informacion de la empresa!! \n";
        }else{ 
            echo "\nNo se pudo cargar la informacion de la empresa!! \n";
        }
    }

    /**
    * Crea un responsable en la BD
    * @return int
    */
    function cargarResponsable(){
        $obj = new AbmResponsable();
        $resp = false;
        $doc = null;

        echo "Ingrese el documento del responsable: ";
        $responsable['nrodoc'] = trim(fgets(STDIN));
        echo "Ingrese el numero de empleado del responsable: ";
        $responsable['rnumeroempleado'] = trim(fgets(STDIN));
        echo "Ingrese el numero de licencia del responsable: ";
        $responsable['rnumerolicencia'] = trim(fgets(STDIN));
        echo "Ingrese el nombre del responsable: ";
        $responsable['nombre'] = trim(fgets(STDIN));
        echo "Ingrese el apellido del responsable: ";
        $responsable['apellido'] = trim(fgets(STDIN));
        
        if($obj->alta($responsable)){
            $resp = true;
            $doc = $responsable['nrodoc'];
        }else{
            echo "\nIngreso MAL los datos o el Documento ya esta cargado en la Base de Datos!! \n";
        }

        if($resp) {
            echo "\nSe cargo correctamente la informacion del responsable!! \n";
        }else{ 
            echo "\nNo se pudo cargar la informacion del responsable!! \n";
        }

        return $doc;
    }

    /**
    * Pide que el usuario elija una empresa o la crea en la BD segun lo que decida
    * @return int
    */
    function pedirEmpresa(){
        $obj = new AbmEmpresa();
        $res = true;

        do{
            if($res){
                echo "\nIngrese el id de la empresa: \n\n" . separador() . mostrarEmpresas();
                echo separador() . "Empresa: ";
            }else{
                echo "\nEl id de la empresa no existe!! Seleccione alguna o ingrese 0 para crear una: \n\n" . 
                separador();
                echo mostrarEmpresas();
                separador();
                echo "Empresa: ";
            }
            $idEmpresa = trim(fgets(STDIN));

            if($idEmpresa == 0){
                cargarEmpresa();
                $idEmpresa = count($obj->obtenerEmpresas());
            }
            $objEmpresa = $obj->obtenerEmpresa(['idempresa'=>$idEmpresa]);  
            $res = $obj->buscarEmpresa(['idempresa'=>$idEmpresa]);
        }while(!$res);

        return $objEmpresa->getIdEmpresa();
    }

    /**
    * Pide que el usuario elija un responsable o la crea en la BD segun lo que decida
    * @return int
    */
    function pedirResponsable(){
        $obj = new AbmResponsable();
        $res = true;

        do{
            if($res){
                echo "\nIngrese el numero de documento del responsable: \n\n" . separador() . mostrarResponsables();
                echo separador() . "Doc Responsable: ";
            }else{
                echo "\nEl documento del responsable no existe!! Seleccione alguno o ingrese 0 para crear uno: \n\n";
                separador();
                echo mostrarResponsables();
                separador();
                echo "Doc Responsable: ";
            }
            $nroResponsable = trim(fgets(STDIN));

            if($nroResponsable == 0){
                $nroResponsable = cargarResponsable();
            }
            if($nroResponsable != null){
                $objResponsable = $obj->obtenerResponsable(['nrodoc'=>$nroResponsable]);
                $res = $obj->buscarResponsable(['nrodoc'=>$nroResponsable]);
            }
        }while(!$res);

        return $objResponsable->getNrodoc();
    }

    /**
    * Busca en la BD el viaje y devuelve el id
    * @return int
    */
    function buscarViaje(){
        $obj = new AbmViaje();

        echo "Los Viajes son: "."\n";
        separador();
        echo mostrarViajes();
        separador();
        echo "Ingrese el codigo del viaje a buscar (0 para salir): ";
        $codigoViaje['idviaje'] = trim(fgets(STDIN));
        $resp = $obj->buscarViaje($codigoViaje);

        while(!$resp && $codigoViaje['idviaje'] != 0){
            echo "\nCodigo incorrecto, Ingreselo nuevamente!! \n\n";
            separador();
            echo mostrarViajes();
            separador();
            echo "\nCodigo (0 para salir): ";
            $codigoViaje['idviaje'] = trim(fgets(STDIN));
            $resp = $obj->buscarViaje($codigoViaje);
        }

        return $codigoViaje;
    }

    /**
    * Devuelve una cadena de caracteres para ver los datos del viaje
    * @return string
    */
    function mostrarViajes(){
        $obj = new AbmViaje();
        $datosViajes = "";
        $colObjViajes = $obj->obtenerViajes();

        if(count($colObjViajes) > 0){
            foreach($colObjViajes as $unViaje){
                $datosViajes .= " Codigo: ". $unViaje->getIdViaje(). " con destino a: " . $unViaje->getDestino() . "\n";
            }
        }

        return $datosViajes;
    }

    /**
    * Devuelve una cadena de caracteres para ver los datos de la empresa
    * @return string
    */
    function mostrarEmpresas(){
        $obj = new AbmEmpresa();
        $hayEmpresa = false;
        $datosEmpresas = "";

        while(!$hayEmpresa){
            $colObjEmpresas = $obj->obtenerEmpresas();
            if(count($colObjEmpresas) > 0){
                $hayEmpresa = true;
                foreach($colObjEmpresas as $unaEmpresa){
                    $datosEmpresas .= $unaEmpresa . "\n";
                }
            }else{
                echo "\nAun no hay empresas!! Debe crear una\n";
                cargarEmpresa();
            }
        }

        return $datosEmpresas;
    }

    /**
    * Devuelve una cadena de caracteres para ver los datos del responsable
    * @return string
    */
    function mostrarResponsables(){
        $objResponsable = new AbmResponsable();
        $hayResponsable = false;
        $datosResponsables = "";

        while(!$hayResponsable){
            $colObjResponsables = $objResponsable->obtenerResponsables();
            if(count($colObjResponsables) > 0){
                $hayResponsable = true;
                foreach($colObjResponsables as $unResponsable){
                    $datosResponsables .= $unResponsable . "\n";
                }
            }else{
                echo "\nAun no hay responsables!! Debe crear uno\n";
                cargarResponsable();
            }
        }

        return $datosResponsables;
    }

    /**
    * Este modulo cambia los datos del viaje
    * @param object AbmViaje
    * @param int
    */
    function cambiarDatosViaje($objViaje,$idViaje){
        do{
            $opcion = menuModifViaje();
            $viaje['idviaje'] = $idViaje['idviaje'];
            $elViaje = $objViaje->obtenerViaje($viaje);
            switch ($opcion){
                //Modifica el destino del Viaje
                case 1:
                    echo "El destino actual es: " . $elViaje->getDestino() . "\n";
                    echo "Lo cambiara a: ";
                    $viaje['vdestino'] = trim(fgets(STDIN));
                    $viaje['vcantmaxpasajeros'] = $elViaje->getCantMaxPasajeros();
                    $viaje['idempresa'] = $elViaje->getObjEmpresa()->getIdEmpresa();
                    $viaje['nrodoc'] = $elViaje->getObjResponsable()->getNroDoc();
                    $viaje['vimporte'] = $elViaje->getImporte();
                    $resp = $objViaje->modificacion($viaje);

                    if($resp){
                        echo "\nEl destino se ha cambiado correctamente!!\n";
                    }else{
                        echo "\nEl destino NO se ha cambiado correctamente!!\n";
                    }
                break;
                //Modifica la cant maxima del Viaje
                case 2:
                    echo "La cantidad maxima actual es: " . $elViaje->getCantMaxPasajeros() . "\n";
                    echo "La cambiara a: ";
                    $viaje['vdestino'] = $elViaje->getDestino();
                    $viaje['vcantmaxpasajeros'] = trim(fgets(STDIN));
                    $viaje['idempresa'] = $elViaje->getObjEmpresa()->getIdEmpresa();
                    $viaje['nrodoc'] = $elViaje->getObjResponsable()->getNroDoc();
                    $viaje['vimporte'] = $elViaje->getImporte();
                    $resp = $objViaje->modificacion($viaje);

                    if($resp){
                        echo "\nLa capacidad maxima se ha cambiado correctamente!!\n";
                    }else{
                        echo "\nLa capacidad maxima NO se ha cambiado correctamente!!\n";
                    }
                break;
                //Modifica la empresa del Viaje
                case 3: 
                    separador();
                    echo "\nLas empresas son: ". "\n" . mostrarEmpresas() . "\n";
                    separador();
                    echo "El id de la empresa actual es: " . $elViaje->getObjEmpresa()->getIdEmpresa() . "\n";
                    echo "Lo cambiara a: ";
                    $viaje['vdestino'] = $elViaje->getDestino();
                    $viaje['vcantmaxpasajeros'] = $elViaje->getCantMaxPasajeros();
                    $viaje['idempresa'] = trim(fgets(STDIN));
                    $viaje['nrodoc'] = $elViaje->getObjResponsable()->getNroDoc();
                    $viaje['vimporte'] = $elViaje->getImporte();
                    $resp = $objViaje->modificacion($viaje);

                    if($resp){
                        echo "\nLa empresa se ha cambiado correctamente!!\n";
                    }else{
                        echo "\nLa empresa NO se ha cambiado correctamente!!\n";
                    }
                break;
                //Modifica el responsable del Viaje
                case 4:
                    separador();
                    echo "\nLos responsables son: ". "\n" . mostrarResponsables() . "\n";
                    separador();
                    echo "El documento del responsable actual es: " . $elViaje->getObjResponsable()->getNroDoc() . "\n";
                    echo "Lo cambiara a: ";
                    $viaje['vdestino'] = $elViaje->getDestino();
                    $viaje['vcantmaxpasajeros'] = $elViaje->getCantMaxPasajeros();
                    $viaje['idempresa'] = $elViaje->getObjEmpresa()->getIdEmpresa();
                    $viaje['nrodoc'] = trim(fgets(STDIN));
                    $viaje['vimporte'] = $elViaje->getImporte();
                    $resp = $objViaje->modificacion($viaje);

                    if($resp){
                        echo "\nEl responsable se ha cambiado correctamente!!\n";
                    }else{
                        echo "\nEl responsable NO se ha cambiado correctamente!!\n";
                    }
                break;
                //Modifica el importe del Viaje
                case 5: 
                    echo "El importe actual es: " . $elViaje->getImporte() . "\n";
                    echo "Lo cambiara a: ";
                    $viaje['vdestino'] = $elViaje->getDestino();
                    $viaje['vcantmaxpasajeros'] = $elViaje->getCantMaxPasajeros();
                    $viaje['idempresa'] = $elViaje->getObjEmpresa()->getIdEmpresa();
                    $viaje['nrodoc'] = $elViaje->getObjResponsable()->getNroDoc();
                    $viaje['vimporte'] = trim(fgets(STDIN));
                    $resp = $objViaje->modificacion($viaje);

                    if($resp){
                        echo "\nEl importe se ha cambiado correctamente!!\n";
                    }else{
                        echo "\nEl importe NO se ha cambiado correctamente!!\n";
                    }
                break;
                //Modifica todos los datos del Viaje
                case 6: 
                    echo "El destino actual es: " . $elViaje->getDestino() . "\n";
                    echo "Lo cambiara a: ";
                    $viaje['vdestino'] = trim(fgets(STDIN));
                    $resp1 = $objViaje->modificacion($viaje);

                    echo "\nLa cantidad maxima actual es: " . $elViaje->getCantMaxPasajeros() . "\n";
                    echo "La cambiara a: ";
                    $viaje['vcantmaxpasajeros'] = trim(fgets(STDIN));
                    $resp2 = $objViaje->modificacion($viaje);
                    
                    separador();
                    echo "\nLas empresas son: ". "\n" . mostrarEmpresas() . "\n";
                    separador();
                    echo "El id de la empresa actual es: " . $elViaje->getObjEmpresa()->getIdEmpresa() . "\n";
                    echo "Lo cambiara a: ";
                    $viaje['idempresa'] = trim(fgets(STDIN));
                    $resp3 = $objViaje->modificacion($viaje);

                    separador();
                    echo "\nLos responsables son: ". "\n" . mostrarResponsables() . "\n";
                    separador();
                    echo "El documento del responsable actual es: " . $elViaje->getObjResponsable()->getNroDoc() . "\n";
                    echo "Lo cambiara a: ";
                    $viaje['nrodoc'] = trim(fgets(STDIN));
                    $resp4 = $objViaje->modificacion($viaje);

                    echo "\nEl importe actual es: " . $elViaje->getImporte() . "\n";
                    echo "Lo cambiara a: ";
                    $viaje['vimporte'] = trim(fgets(STDIN));
                    $resp5 = $objViaje->modificacion($viaje);

                    if($resp1 && $resp2 && $resp3 && $resp4 && $resp5){
                        echo "\nLos datos se han cambiado correctamente!!\n";
                    }else{
                        echo "\nLos datos NO se han cambiado correctamente!!\n";
                    }
                break;
                //Muestra los datos del Viaje
                case 7: 
                    echo $objViaje->obtenerViaje($viaje);
                    $colObjPasajeros = $objViaje->getColPasajeros($viaje);
                    if(count($colObjPasajeros) == 0){
                        echo "\nNo hay pasajeros en este viaje!!\n\n";
                    }
                break;
                //Sale del Menu
                case 8: 
                    break;
                break;
                default:
                    echo "El numero que ingreso NO es valido, por favor ingrese un numero del 1 al 8\n";
                break;
            }
        }while($opcion != 8);
    }

    /**
    * Este modulo cambia datos del Pasajero
    * @param object AbmPasajero
    * @param object int
    */
    function cambiarDatoPasajero($objPasajero,$doc){
        do{
            $opcion = menuModifPasajero();
            $pasajero['nrodoc'] = $doc;
            $pasaj = $objPasajero->obtenerPasajero($pasajero);
            switch ($opcion){
                //Modifica el nombre del Pasajero
                case 1:
                    echo "El nombre actual es: " . $pasaj->getNombre() . "\n";
                    echo "Lo cambiara a: ";
                    $pasajero['nombre'] = trim(fgets(STDIN));
                    $pasajero['apellido'] = $pasaj->getApellido();
                    $pasajero['ptelefono'] = $pasaj->getTelefono();
                    $pasajero['idviaje'] = $pasaj->getObjViaje()->getIdViaje();
                    $resp = $objPasajero->modificacion($pasajero);

                    if($resp){
                        echo "\nEl nombre se ha cambiado correctamente!!\n";
                    }else{
                        echo "\nEl nombre NO se ha cambiado correctamente!!\n";
                    }
                break;
                //Modifica el apellido del Pasajero
                case 2:
                    echo "El apellido actual es: " . $pasaj->getApellido() . "\n";
                    echo "Lo cambiara a: ";
                    $pasajero['nombre'] = $pasaj->getNombre();
                    $pasajero['apellido'] = trim(fgets(STDIN));
                    $pasajero['ptelefono'] = $pasaj->getTelefono();
                    $pasajero['idviaje'] = $pasaj->getObjViaje()->getIdViaje();
                    $resp = $objPasajero->modificacion($pasajero);

                    if($resp){
                        echo "\nEl apellido se ha cambiado correctamente!!\n";
                    }else{
                        echo "\nEl apellido NO se ha cambiado correctamente!!\n";
                    }
                break;
                //Modifica el telefono del Pasajero
                case 3:
                    echo "El telefono actual es: " . $pasaj->getTelefono() . "\n";
                    echo "Lo cambiara a: ";
                    $pasajero['nombre'] = $pasaj->getNombre();
                    $pasajero['apellido'] = $pasaj->getApellido();
                    $pasajero['ptelefono'] = trim(fgets(STDIN));
                    $pasajero['idviaje'] = $pasaj->getObjViaje()->getIdViaje();
                    $resp = $objPasajero->modificacion($pasajero);

                    if($resp){
                        echo "\nEl telefono se ha cambiado correctamente!!\n";
                    }else{
                        echo "\nEl telefono NO se ha cambiado correctamente!!\n";
                    }
                    break;
                //Modifica el viaje del Pasajero
                case 4: 
                    separador();
                    echo "\nLos viajes son: ". "\n" . mostrarViajes() . "\n";
                    separador();
                    echo "El id del viaje actual es: " . $pasaj->getObjViaje()->getIdViaje() . "\n";
                    echo "Lo cambiara a: ";
                    $pasajero['nombre'] = $pasaj->getNombre();
                    $pasajero['apellido'] = $pasaj->getApellido();
                    $pasajero['ptelefono'] = $pasaj->getTelefono();
                    $pasajero['idviaje'] = trim(fgets(STDIN));
                    $viaje = new AbmViaje();

                    if($viaje->hayPasaje($pasajero)){
                        $resp = $objPasajero->modificacion($pasajero);
                    }else{
                        $resp = false;
                        echo "\nEl viaje llego a su capacidad maxima!!\n";
                    }
                    
                    if($resp){
                        echo "\nEl viaje se ha cambiado correctamente!!\n";
                    }else{
                        echo "\nEl viaje NO se ha cambiado correctamente!!\n";
                    }
                    break;
                //Modifica todos los datos del Pasajero
                case 5:
                    echo "El nombre actual es: " . $pasaj->getNombre() . "\n";
                    echo "Lo cambiara a: "; 
                    $pasajero['nombre'] = trim(fgets(STDIN));
                    $resp1 = $objPasajero->modificacion($pasajero);
                    
                    echo "\nEl apellido actual es: " . $pasaj->getApellido() . "\n";
                    echo "Lo cambiara a: ";
                    $pasajero['apellido'] = trim(fgets(STDIN));
                    $resp2 = $objPasajero->modificacion($pasajero);
                    
                    echo "\nEl telefono actual es: " . $pasaj->getTelefono() . "\n";
                    echo "Lo cambiara a: ";
                    $pasajero['ptelefono'] = trim(fgets(STDIN));
                    $resp3 = $objPasajero->modificacion($pasajero);
                    
                    "\n" . separador();
                    echo "\nLos viajes son: ". "\n" . mostrarViajes() . "\n";
                    separador();
                    echo "El id del viaje actual es: " . $pasaj->getObjViaje()->getIdViaje() . "\n";
                    echo "Lo cambiara a: ";
                    $pasajero['idviaje'] = trim(fgets(STDIN));
                    $viaje = new AbmViaje();
                    if($viaje->hayPasaje($pasajero)){
                        $resp4 = $objPasajero->modificacion($pasajero);
                    }else{
                        $resp4 = false;
                        echo "\nEl viaje llego a su capacidad maxima!!\n";
                    }

                    if($resp1 && $resp2 && $resp3 && $resp4){
                        echo "\nLos datos se han cambiado correctamente:\n";
                    }else{
                        echo "\nLos datos NO se han cambiado correctamente:\n";
                    }
                //Muestra los datos del Pasajero
                case 6: 
                    echo $objPasajero->obtenerPasajero($pasajero);
                break;
                //Sale del menu
                case 7: 
                    break;
                break;
                default:
                    echo "El numero que ingreso NO es valido, por favor ingrese un numero del 1 al 7\n";
                break;    
            }
        }while($opcion != 7);
    }

    /**
    * Este modulo cambia los datos de la empresa
    * @param object AbmEmpresa
    * @param int
    */
    function cambiarDatoEmpresa($objEmpresa,$id){
        do{
            $opcion = menuModifEmpresa();
            $empresa['idempresa'] = $id;
            $laEmpresa = $objEmpresa->obtenerEmpresa($empresa);
            switch ($opcion){
                //Modifica el nombre de la Empresa
                case 1:
                    echo "El nombre actual es: " . $laEmpresa->getNombre() . "\n";
                    echo "Lo cambiara a: ";
                    $empresa['enombre'] = trim(fgets(STDIN));
                    $empresa['edireccion'] = $laEmpresa->getDireccion();
                    $resp = $objEmpresa->modificacion($empresa);

                    if($resp){
                        echo "\nEl nombre se ha cambiado correctamente!!\n";
                    }else{
                        echo "\nEl nombre NO se ha cambiado correctamente!!\n";
                    }
                break;
                //Modifica la direccion de la Empresa
                case 2:
                    echo "La direccion actual es: " . $laEmpresa->getDireccion() . "\n";
                    echo "La cambiara a: ";
                    $empresa['enombre'] = $laEmpresa->getNombre();
                    $empresa['edireccion'] = trim(fgets(STDIN));
                    $resp = $objEmpresa->modificacion($empresa);

                    if($resp){
                        echo "\nLa direccion se ha cambiado correctamente!!\n";
                    }else{
                        echo "\nLa direccion NO se ha cambiado correctamente!!\n";
                    }
                break;
                //Modifica todos los datos de la Empresa
                case 3:
                    echo "El nombre actual es: " . $laEmpresa->getNombre() . "\n";
                    echo "Lo cambiara a: "; 
                    $empresa['enombre'] = trim(fgets(STDIN));
                    $resp1 = $objEmpresa->modificacion($empresa);

                    echo "\nLa direccion actual es: " . $laEmpresa->getDireccion() . "\n";
                    echo "La cambiara a: ";
                    $empresa['edireccion'] = trim(fgets(STDIN));
                    $resp2 = $objEmpresa->modificacion($empresa);

                    if($resp1 && $resp2){
                        echo "\nLos datos se han cambiado correctamente!!\n";
                    }else{
                        echo "\nLos datos NO se han cambiado correctamente!!\n";
                    }
                break;
                //Muestra los datos de la Empresa
                case 4:
                    echo $objEmpresa->obtenerEmpresa($empresa);
                break;
                //Sale del menu
                case 5: 
                    break;
                break;
                default:
                    echo "El numero que ingreso NO es valido, por favor ingrese un numero del 1 al 5\n";
                break;
            }
        }while($opcion != 5);
    }

    /**
    * Este modulo cambia los datos del responsable
    * @param object AbmResponsable
    * @param int
    */
    function cambiarDatoResponsable($objResponsable,$numD){
        do{
            $opcion = menuModifResponsable();
            $responsable['nrodoc'] = $numD;
            $respon = $objResponsable->obtenerResponsable($responsable);
            switch($opcion){
                //Modifica el nombre del Responsable
                case 1:
                    echo "El nombre actual es: " . $respon->getNombre() . "\n";
                    echo "Lo cambiara a: ";
                    $responsable['nombre'] = trim(fgets(STDIN));
                    $responsable['apellido'] = $respon->getApellido();
                    $responsable['rnumeroempleado'] = $respon->getNumEmpleado();
                    $responsable['rnumerolicencia'] = $respon->getNumLicencia();
                    $resp = $objResponsable->modificacion($responsable);

                    if($resp){
                        echo "\nEl nombre se ha cambiado correctamente!!\n";
                    }else{
                        echo "\nEl nombre NO se ha cambiado correctamente!!\n";
                    }
                break;
                //Modifica el apellido del Responsable
                case 2: 
                    echo "El apellido actual es: " . $respon->getApellido() . "\n";
                    echo "Lo cambiara a: ";
                    $responsable['nombre'] = $respon->getNombre();
                    $responsable['apellido'] = trim(fgets(STDIN));
                    $responsable['rnumeroempleado'] = $respon->getNumEmpleado();
                    $responsable['rnumerolicencia'] = $respon->getNumLicencia();
                    $resp = $objResponsable->modificacion($responsable);

                    if($resp){
                       echo "\nEl apellido se ha cambiado correctamente!!\n";
                    }else{
                        echo "\nEl apellido NO se ha cambiado correctamente!!\n";
                    }
                break;
                //Modifica el num de empleado del Responsable
                case 3:
                    echo "El numero de empleado actual es: " . $respon->getNumEmpleado() . "\n";
                    echo "Lo cambiara a: ";
                    $responsable['nombre'] = $respon->getNombre();
                    $responsable['apellido'] = $respon->getApellido();
                    $responsable['rnumeroempleado'] = trim(fgets(STDIN));
                    $responsable['rnumerolicencia'] = $respon->getNumLicencia();
                    $resp = $objResponsable->modificacion($responsable);

                    if($resp){
                        echo "\nEl numero de empleado se ha cambiado correctamente!!\n";
                    }else{
                        echo "\nEl numero de empleado NO se ha cambiado correctamente!!\n";
                    }
                break;
                //Modifica el num de licencia del Responsable
                case 4: 
                    echo "El numero de licencia actual es: " . $respon->getNumLicencia() . "\n";
                    echo "Lo cambiara a: ";
                    $responsable['nombre'] = $respon->getNombre();
                    $responsable['apellido'] = $respon->getApellido();
                    $responsable['rnumeroempleado'] = $respon->getNumEmpleado();
                    $responsable['rnumerolicencia'] = trim(fgets(STDIN));
                    $resp = $objResponsable->modificacion($responsable);

                    if($resp){
                        echo "\nEl numero de licencia se ha cambiado correctamente!!\n";
                    }else{
                        echo "\nEl numero de licencia NO se ha cambiado correctamente!!\n";
                    }
                break;
                //Modifica todos los datos del Responsable
                case 5:
                    echo "El nombre actual es: " . $respon->getNombre() . "\n";
                    echo "Lo cambiara a: ";
                    $responsable['nombre'] = trim(fgets(STDIN));
                    $resp1 = $objResponsable->modificacion($responsable);

                    echo "\nEl apellido actual es: " . $respon->getApellido() . "\n";
                    echo "Lo cambiara a: ";
                    $responsable['apellido'] = trim(fgets(STDIN));
                    $resp2 = $objResponsable->modificacion($responsable);

                    echo "\nEl numero de empleado actual es: " . $respon->getNumEmpleado() . "\n";
                    echo "Lo cambiara a: ";
                    $responsable['rnumeroempleado'] = trim(fgets(STDIN));
                    $resp3 = $objResponsable->modificacion($responsable);

                    echo "\nEl numero de licencia actual es: " . $respon->getNumLicencia() . "\n";
                    echo "Lo cambiara a: ";
                    $responsable['rnumerolicencia'] = trim(fgets(STDIN));
                    $resp4 = $objResponsable->modificacion($responsable);

                    if($resp1 && $resp2 && $resp3 && $resp4){
                        echo "\nLos datos se han cambiado correctamente!!\n";
                    }else{
                        echo "\nLos datos NO se han cambiado correctamente!!\n";
                    }
                break;
                //Muestra los datos del Responsable
                case 6: 
                    echo $objResponsable->obtenerResponsable($responsable);
                break;
                //Sale del menu
                case 7: 
                    break;
                break;
                default:
                    echo "El numero que ingreso NO es valido, por favor ingrese un numero del 1 al 7\n";
                break;      
            }
        }while($opcion != 7);   
    }

    /**
    * Este modulo modifica datos del viaje
    */
    function opcionesViaje(){
        $objViaje = new AbmViaje(); 
        $codigo = buscarViaje();
        if($codigo['idviaje'] != 0){
            do{
                $opcion = menuViajes();
                $elViaje = $objViaje->obtenerViaje($codigo);
                switch($opcion){
                    //Muestra los datos del Viaje
                    case 1:
                        $colObjPasajeros = $objViaje->getColPasajeros($codigo);
                        echo "\nLos datos del viaje son: \n" . $elViaje . "\n";
                        if(count($colObjPasajeros) == 0)
                            echo "No hay pasajeros cargados!!!\n";
                    break;
                    //Muestra la cantidad de Pasajeros
                    case 2: 
                        echo "La cantidad de pasajeros del viaje son: ". count($objViaje->getColPasajeros($codigo)) . "\n";
                        echo "La cantidad Maxima de pasajeros permitidos son: ". $elViaje->getCantMaxPasajeros() . "\n";
                    break;
                    //Muestra los datos de un Pasajero
                    case 3:
                        $colObjPasajeros = $objViaje->getColPasajeros($codigo);
                        $pasaj = -1;
                        $dni = 1;

                        if(count($colObjPasajeros) > 0){
                            while($pasaj == -1 && $dni != 0){
                                echo "Ingrese el DNI del pasajero que desea buscar (0 para salir) : ";
                                $dni = trim(fgets(STDIN));
                                $pasaj = $objViaje->buscarPasajero($dni,$codigo);
                                if($pasaj <> -1){
                                    echo "\nLos datos del pasajero son: \n";
                                    echo $objViaje->getColPasajeros($codigo)[$pasaj];
                                }else{
                                    echo "\nEl DNI del pasajero ingresado no existe!!\n\n";
                                    echo "Ingrese el DNI del pasajero que desea buscar (0 para salir) : ";
                                    $dni = trim(fgets(STDIN));
                                    $pasaj = $objViaje->buscarPasajero($dni,$codigo);
                                }
                            }
                        }else{
                            echo "\nNo hay pasajeros en este viaje!!\n\n";
                        }  
                    break;
                    //Muestra los datos de los Pasajeros
                    case 4:
                        $colObjPasajeros = $objViaje->getColPasajeros($codigo);
                        if(count($colObjPasajeros) > 0){
                            echo "Los pasajeros del viaje son: \n";
                            foreach($colObjPasajeros as $objPasajero){
                                echo $objPasajero . "\n";
                            }
                        }else{
                            echo "\nNo hay pasajeros en este viaje!!\n\n";
                        }
                    break;
                    //Modifica los datos de un Pasajero
                    case 5:
                        $colObjPasajeros = $objViaje->getColPasajeros($codigo);
                        $pasaj = -1;
                        $dni = 1;

                        if(count($colObjPasajeros) > 0){
                            do{
                                echo "Ingrese el DNI del pasajero a modificar (0 para salir) : ";
                                $dni = trim(fgets(STDIN));
                                $pasaj = $objViaje->buscarPasajero($dni,$codigo);
                                if($pasaj <> -1){
                                    $obj = new AbmPasajero();
                                    cambiarDatoPasajero($obj,$dni);
                                }elseif($dni != 0){
                                    echo "\nEl DNI del pasajero ingresado no existe!!\n\n";
                                }
                            }while($pasaj == -1 && $dni != 0);
                        }else{
                            echo "\nNo hay pasajeros en este viaje!!\n\n";
                        }
                    break;
                    //Agrega pasajeros al Viaje
                    case 6: 
                        $hayPasaje = $objViaje->hayPasaje($codigo);
                        if($hayPasaje){
                            echo "Ingrese cuantos pasajeros desea ingresar: ";
                                $cantPasajerosNuevos = trim(fgets(STDIN));
                                $cantTotal = count($objViaje->getColPasajeros($codigo)) + $cantPasajerosNuevos;
                                if($cantTotal <= $elViaje->getCantMaxPasajeros()){
                                    for($i=0;$i<$cantPasajerosNuevos;$i++){
                                        echo "\nPasajero " . ($i+1) . "\n";
                                        $rta = crearPasajero($objViaje,$codigo);
                                        if(!$rta){
                                            $i--;
                                        }
                                    }                
                                }else{
                                    echo "La cantidad de pasajeros es superior a la capacidad maxima!!\n";
                                }
                        }else{
                            echo "\nEl viaje ya llego a su capacidad maxima!!\n\n";
                        }
                    break;
                    //Elimina un pasajero del viaje
                    case 7: 
                        $colObjPasajeros = $objViaje->getColPasajeros($codigo);
                        if(count($colObjPasajeros) > 0){
                            echo "Ingrese el DNI del pasajero a eliminar: ";
                            $dni = trim(fgets(STDIN));
                            $obj = new AbmPasajero();
                            $resp = $obj->buscarPasajero($dni);
                            if($resp){
                                $resp = $obj->baja(['nrodoc' => $dni]);
                                if($resp){
                                    echo "\nEl pasajero se elimino correctamente!!\n";
                                }else{
                                    echo "\nEl pasajero NO se elimino correctamente!!\n";
                                }
                            }else{
                                echo "\nEl DNI del pasajero ingresado NO existe!!\n";
                            }
                        }else{
                            echo "\nNO hay pasajeros en este viaje!!\n\n";
                        }
                    break;
                    //Modifica los datos del viaje
                    case 8: 
                        $obj = new AbmViaje();
                        $resp = $obj->buscarViaje($codigo);
                        if($resp){
                            cambiarDatosViaje($obj,$codigo);
                        } 
                    break;
                    //Sale del menu
                    case 9: 
                        break;
                    break;
                    default: 
                        echo "El numero que ingreso NO es valido, por favor ingrese un numero del 1 al 9\n";
                    break;
                }
            }while($opcion != 9);
        }
    }

    /**
    * Menu para elegir la opcion a realizar
    */
    function opcionesMenuInicio($opc){
        switch($opc){
            //Ingresa un Viaje
            case 1:
                echo "\nIngrese la cantidad de viajes que desea agregar: ";
                $cant = trim(fgets(STDIN));
                cargarViajes($cant);
            break;
            //Ingresa una Empresa
            case 2:
                cargarEmpresa();
            break;
            //Ingresa un Responsable
            case 3:
                cargarResponsable();
            break;
            //Modifica un Viaje
            case 4:
                opcionesViaje();
            break;
            //Modifica una Empresa
            case 5:
                $obj = new AbmEmpresa();
                do{
                    echo "Ingrese el id de la empresa que desea modificar: \n" . separador() . mostrarEmpresas();
                    echo separador() . "Id empresa (0 para salir) : ";
                    $idEmpresa = trim(fgets(STDIN));
                    $empresa = $obj->buscarEmpresa(['idempresa'=>$idEmpresa,'opc' => 1]);

                    if($empresa){
                        cambiarDatoEmpresa($obj,$idEmpresa);
                    }elseif($idEmpresa != 0){
                        echo "\nEl numero de la empresa seleccionada no existe!!\n\n";
                    }
                }while(!$empresa && $idEmpresa != 0);
            break;
            //Modifica un Responsable
            case 6:
                $obj = new AbmResponsable();
                do{
                    echo "Ingrese el numero de documento del responsable que desea modificar: \n" . separador() . mostrarResponsables();
                    echo separador() . "Doc Empleado (0 para salir) : ";
                    $numDoc = trim(fgets(STDIN));
                    $responsable = $obj->buscarResponsable(['nrodoc'=>$numDoc,'opc'=> 1]);

                    if($responsable){
                        cambiarDatoResponsable($obj,$numDoc);
                    }elseif($numDoc != 0){
                        echo "\nEl numero del responsable seleccionado no existe!!\n\n";
                    }
                }while(!$responsable && $numDoc != 0);
            break;
            //Elimina un Viaje
            case 7:
                echo separador();
                echo "Los viajes son: ". "\n";
                echo  mostrarViajes();
                echo separador() . "\n";
                echo "Ingrese el codigo del viaje que desea eliminar (0 para salir): ";
                $codigo = trim(fgets(STDIN));

                $obj = new AbmViaje();
                $resp = $obj->buscarViaje(['idviaje'=>$codigo]);
                while(!$resp && $codigo != 0){
                    echo "\nEl codigo ingresado NO existe, ingrese alguno de los viajes o 0 para salir: " . "\n\n";
                    separador();
                    echo mostrarViajes();
                    separador();
                    echo "Codigo (0 para salir) : ";
                    $codigo = trim(fgets(STDIN));
                    $resp = $obj->buscarViaje(['idviaje'=>$codigo]);
                }
                if($codigo != 0){
                    if(count($obj->getColPasajeros(['idviaje'=>$codigo])) == 0){
                        $resp = $obj->baja(['idviaje'=>$codigo]);
                        if($resp){
                            echo "\nEl Viaje fue eliminado correctamente!!\n";
                        }else{
                            echo "\nEl codigo NO coicide con ningun Viaje!!\n";
                        }
                    }else{
                        echo "\nEl Viaje NO se puede eliminar porque tiene pasajeros!!\n";
                    }
                }
            break;
            //Elimina una Empresa
            case 8:
                echo separador();
                echo "Las empresas son: ". "\n";
                echo  mostrarEmpresas();
                echo separador() . "\n";
                echo "Ingrese el id de la empresa que desea eliminar (0 para salir): ";
                $idEmpresa = trim(fgets(STDIN));

                $objE = new AbmEmpresa();
                $resp = $objE->buscarEmpresa(['idempresa'=>$idEmpresa,'opc'=>1]);
                while(!$resp && $idEmpresa != 0){
                    echo "\nEl id ingresado NO existe, ingrese alguno de las empresas o 0 para salir: " . "\n\n";
                    separador();
                    echo mostrarEmpresas();
                    separador();
                    echo "Id (0 para salir) : ";
                    $idEmpresa = trim(fgets(STDIN));
                    $resp = $objE->buscarEmpresa(['idempresa'=>$idEmpresa,'opc'=>1]);
                }
                if($idEmpresa != 0){
                    $objV = new AbmViaje();
                    $resp = $objV->encontrarEmpresa($idEmpresa);
                    if(!$resp){
                        $resp = $objE->baja(['idempresa'=>$idEmpresa]);
                        if($resp){
                            echo "\nLa Empresa fue eliminada correctamente!!\n";
                        }else{
                            echo "\nEl id NO coicide con ninguna Empresa!!\n";
                        }
                    }else{
                        echo "\nLa Empresa NO se puede eliminar porque posee viajes!!\n";
                    }
                }
            break;
            //Elimina un Responsable
            case 9:
                echo separador();
                echo "Los responsables son: ". "\n";
                echo  mostrarResponsables();
                echo separador() . "\n";
                echo "Ingrese el documento del responsable que desea eliminar (0 para salir): ";
                $nroRes = trim(fgets(STDIN));

                $objR = new AbmResponsable();
                $resp = $objR->buscarResponsable(['nrodoc'=>$nroRes,'opc'=>1]);
                while(!$resp && $nroRes != 0){
                    echo "\nEl documento ingresado NO existe, ingrese alguno de los responsables o 0 para salir: " . "\n\n";
                    separador();
                    echo mostrarResponsables();
                    separador();
                    echo "Doc (0 para salir) : ";
                    $nroRes = trim(fgets(STDIN));
                    $resp = $objR->buscarResponsable(['nrodoc'=>$nroRes,'opc'=>1]);
                }
                if($nroRes != 0){
                    $objV = new AbmViaje();
                    $resp = $objV->encontrarResponsable($nroRes);
                    if(!$resp){
                        $resp = $objR->baja(['nrodoc'=>$nroRes]);
                        if($resp){
                            echo "\nEl Responsable fue eliminado correctamente!!\n";
                        }else{
                            echo "\nEl documento NO coicide con ningun Responsable!!\n";
                        }
                    }else{
                        echo "\nEl Responsable NO se puede eliminar porque esta a cargo de viajes!!\n";
                    }
                }
            break;
            //Sale del programa
            case 10:
                exit();
            break;
            default: 
                echo "El numero que ingreso NO es valido, por favor ingrese un numero del 0 al 10\n";
            break;
        }
    }

    //PROGRAMA PRINCIPAL
    do{
        $obj = new AbmViaje();
        $cantViajes = count($obj->obtenerViajes());
        if($cantViajes == 0){
            echo "\nNO hay viajes!! Ingrese la opcion 1, 2, 3, 10: \n";
            $opcion = menuPrincipal();
            while(($opcion != 1) && ($opcion != 2) && ($opcion != 3) && ($opcion != 10)){
                echo "NO hay viajes!! Ingrese la opcion 1, 2, 3, 10: \n";
                $opcion = trim(fgets(STDIN));
            }
            opcionesMenuInicio($opcion);
        }else{
            $opcion = menuPrincipal();
            opcionesMenuInicio($opcion);
        }
    }while($opcion != 10);
?>