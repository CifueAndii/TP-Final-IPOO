<?php
    include_once 'BaseDatos.php';
    include_once 'Viaje.php'; 
    include_once 'Pasajero.php';
    include_once 'Empresa.php';
    include_once 'ResponsableV.php';

    function separador(){
        echo "+++++++++++++++++++++++++++++++++++++++++++++++++++++\n";
    }

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
        echo "|                                   8) Salir                                 |\n";
        echo "|____________________________________________________________________________|\n";
        $opc = trim(fgets(STDIN));
        echo "\n";

        return $opc;
    }

    /**
    * Muestra el menu para que el usuario elija y retorna la opcion
    * @return int 
    */
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
        echo "|                     8) Modificar el responsable del viaje                   |\n";
        echo "|                          9) Modificar datos del viaje                       |\n";
        echo "|                          10) Volver al Menu Principal                       |\n";
        echo "|____________________________________________________________________________ |\n";
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
        $opc = trim(fgets(STDIN));
        echo "\n";

        return $opc;
    }

    function menuModifResponsable(){
        echo " ____________________________________________________________________________\n";
        echo "|                               Menu Responsable:                            |\n";
        echo "|                              1) Modificar Nombre                           |\n";
        echo "|                             2) Modificar Apellido                          |\n";
        echo "|                         3) Modificar Num de Licencia                       |\n";
        echo "|                         4) Modificar todos sus Datos                       |\n";
        echo "|                               5) Ver sus Datos                             |\n";
        echo "|                                   6) Salir                                 |\n";
        echo "|____________________________________________________________________________|\n";
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
        $opc = trim(fgets(STDIN));
        echo "\n";

        return $opc;
    }

    function cargarViajes($cant){
        for($i=0;$i<$cant;$i++){
            echo "\nIngrese el destino del viaje ". ($i+1) .": ";
            $destinoViaje = trim(fgets(STDIN));
            echo "Ingrese la capacidad maxima de pasajeros del viaje ". ($i+1) .": ";
            $cantMaxViaje = trim(fgets(STDIN));
            $objEmpresa = pedirEmpresa();
            $objResponsable = pedirResponsable();
            echo "\nIngrese el importe del viaje ". ($i+1) .": ";
            $importeViaje = trim(fgets(STDIN));

            $objViaje = new Viaje();
            $objViaje->cargar(null,$destinoViaje,$cantMaxViaje,$objEmpresa,$objResponsable,$importeViaje);
            $resp = $objViaje->insertar();

            cargarPasajeros($objViaje);

            if($resp) {
                echo "\nSe cargo correctamente la informacion del viaje!! \n";
            }else{ 
                echo $objViaje->getmensajeoperacion()."\n";
            }
        }
    }

    function cargarPasajeros($viaje){
        $ingreso = 's';
        $i = 0;
        echo "\nIngrese los pasajeros: \n";
        while($ingreso == 's' && $viaje->hayPasaje()){
            echo "\nPasajero Nro ". ($i+1) . "\n";
            echo "Ingrese el documento del pasajero: ";
            $dniPasajero = trim(fgets(STDIN));
            echo "Ingrese el nombre del pasajero: ";
            $nombrePasajero = trim(fgets(STDIN));
            echo "Ingrese el apellido del pasajero: ";
            $apellidoPasajero = trim(fgets(STDIN));
            echo "Ingrese el telefono del pasajero: ";
            $telefonoPasajero = trim(fgets(STDIN));
            
            $objPasajero = new Pasajero();
            $objPasajero->cargar($dniPasajero,$nombrePasajero,$apellidoPasajero,$telefonoPasajero,$viaje);
            $resp = $objPasajero->insertar();

            if($resp) {
                echo "\nSe cargo correctamente el pasajero al viaje!! \n";
            }else{ 
                echo $objPasajero->getmensajeoperacion()."\n";
            }
            $i++;
            
            echo "Quiere ingresar mas pasajeros? (s/n): ";
            $ingreso = trim(fgets(STDIN));
        }
        if(!$viaje->hayPasaje()){
            echo "Llegó a la capacidad máxima de pasajeros: " .$viaje->getCantMaxPasajeros();
        }
    }

    /**
    * Crea un pasajero en la BD
    * @param object $objPasajero
    */
    function crearPasajero($objViaje){
        echo "Ingrese el numero de documento del pasajero: ";
        $numDocumentoPasajero = trim(fgets(STDIN));
        echo "Ingrese el nombre del pasajero: ";
        $nombrePasajero = trim(fgets(STDIN));
        echo "Ingrese el apellido del pasajero: ";
        $apellidoPasajero = trim(fgets(STDIN));
        echo "Ingrese el telefono del pasajero: ";
        $telefonoPasajero = trim(fgets(STDIN));

        $objPasajero = new Pasajero();
        $objPasajero->cargar($numDocumentoPasajero,$nombrePasajero,$apellidoPasajero,$telefonoPasajero,$objViaje);
        $resp = $objPasajero->insertar();

        if($resp){
            echo "\nSe cargo correctamente la informacion del pasajero!! \n\n";
        }else{
            echo $objPasajero->getmensajeoperacion()."\n";
        }
    }

    /**
     * Crea una empresa en la BD
     */
    function cargarEmpresa(){
        echo "Ingrese el nombre de la empresa: ";
        $nombreEmpresa = trim(fgets(STDIN));
        echo "Ingrese la direccion de la empresa: ";
        $direccionEmpresa = trim(fgets(STDIN));
        
        $objEmpresa = new Empresa();
        $objEmpresa->cargar(null,$nombreEmpresa,$direccionEmpresa);
        $resp = $objEmpresa->insertar();

        if($resp) {
            echo "\nSe cargo correctamente la informacion de la empresa!! \n";
        }else{ 
            echo $objEmpresa->getmensajeoperacion();
        }
    }

    /**
    * Crea un responsable en la BD
    */
    function cargarResponsable(){
        echo "Ingrese el numero de licencia del responsable: ";
        $numLincenciaResponsable = trim(fgets(STDIN));
        echo "Ingrese el nombre del responsable: ";
        $nombreResponsable = trim(fgets(STDIN));
        echo "Ingrese el apellido del responsable: ";
        $apellidoResponsable = trim(fgets(STDIN));

        $objResponsable = new ResponsableV();
        $objResponsable->cargar(null,$numLincenciaResponsable,$nombreResponsable,$apellidoResponsable);
        $resp = $objResponsable->insertar();

        if($resp){
            echo "\nSe cargo correctamente la informacion del responsable!! \n";
        }else{
            echo $objResponsable->getmensajeoperacion()."\n";
        }
    }

    /**
    * Este modulo pide que el usuario elija una empresa o la crea en la BD segun lo que decida y devuelve el objeto
    * @return object
    */
    function pedirEmpresa(){
        $objEmpresa = new Empresa();
        $res = true;
        $mostrarEmpresas = mostrarEmpresas();

        do{
            if($res){
                echo "\nIngrese el id de la empresa: \n\n" . separador() . $mostrarEmpresas;
                echo separador() . "Empresa: ";
            }else{
                echo "\nEl id de la empresa no existe!! Seleccione alguna o ingrese 0 para crear una: \n\n" . separador() . $mostrarEmpresas . separador() . "Empresa: ";
            }
            $idEmpresa = trim(fgets(STDIN));

            if($idEmpresa == 0){
                cargarEmpresa();
                $res = $objEmpresa->buscar(count($objEmpresa->listar("")));
            }else{
                $res = $objEmpresa->buscar($idEmpresa);
            }
        }while(!$res);
        return $objEmpresa;
    }

    /**
    * Este modulo pide que el usuario elija un responsable o la crea en la BD segun lo que decida y devuelve el objeto
    * @return object
    */
    function pedirResponsable(){
        $objResponsable = new ResponsableV();
        $res = true;
        $mostrarResponsables = mostrarResponsables();
        
        do{
            if($res){
                echo "\nIngrese el numero de empleado del responsable: \n\n" . separador() . $mostrarResponsables;
                echo separador() . "Num Responsable: ";
            }else{
                echo "\nEl numero de empleado no existe!! Seleccione alguno o ingrese 0 para crear uno: \n\n" . separador() . $mostrarResponsables . separador() . "Num Responsable: ";
            }

            $nroResponsable = trim(fgets(STDIN));

            if($nroResponsable == 0){
                cargarResponsable();
                $res = $objResponsable->buscar(count($objResponsable->listar("")));
            }else{
                $res = $objResponsable->buscar($nroResponsable);
            }
        }while(!$res);
        return $objResponsable;
    }

    /**
    * Busca en la BD el viaje y devuelve el objeto
    * @return object
    */
    function buscarViaje(){
        $objViaje = new viaje();
        echo "Los Viajes son: "."\n";
        separador();
        echo mostrarViajes();
        separador();
        echo "Ingrese el codigo del viaje a buscar: ";
        $codigoViaje = trim(fgets(STDIN));
        $resp = $objViaje->buscar($codigoViaje);
        while(!$resp){
            echo "\nCodigo incorrecto, Ingreselo nuevamente!! \n\n";
            separador();
            echo mostrarViajes() . separador() . "\nCodigo: ";
            $codigoViaje = trim(fgets(STDIN));
            $resp = $objViaje->buscar($codigoViaje);
        }
        return $objViaje;
    }

    /**
    * Devuelve una cadena de caracteres para ver los datos del viaje
    * @return string
    */
    function mostrarViajes(){
        $datosViajes = "";
        $objViaje = new Viaje();
        $colObjViajes = $objViaje->listar("");
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
        $datosEmpresas = "";
        $objEmpresa = new Empresa();
        $colObjEmpresas = $objEmpresa->listar("");
        if(count($colObjEmpresas) > 0){
            foreach($colObjEmpresas as $unaEmpresa){
                $datosEmpresas .= " ".$unaEmpresa . "\n";
            }
        }
        return $datosEmpresas;
    }

    /**
    * Devuelve una cadena de caracteres para ver los datos del responsable
    * @return string
    */
    function mostrarResponsables(){
        $datosResponsables = "";
        $objResponsable = new ResponsableV();
        $colObjResponsables = $objResponsable->listar("");
        if(count($colObjResponsables) > 0){
            foreach($colObjResponsables as $unResponsable){
                $datosResponsables .= $unResponsable . "\n";
            }
        }
        return $datosResponsables;
    }

    /**
    * Este modulo cambia datos del Pasajero
    * @param object $objPasajero
    */
    function cambiarDatoPasajero($objPasajero){
        do{
            $opcion = menuModifPasajero();
            switch ($opcion){
                //
                case 1: 
                    echo $objPasajero->getNombre() . " es el nombre actual\n";
                    echo "Ingrese el nuevo nombre: "; 
                    $nuevoNombre = trim(fgets(STDIN));
                    $objPasajero->setNombre($nuevoNombre);
                    $resp = $objPasajero->modificar();
                    if($resp){
                        echo "\nEl nombre se ha cambiado correctamente!!\n";
                    }else{
                        echo $objPasajero->getMensajeOperacion() . "\n";
                    }
                break;
                //
                case 2: 
                    echo $objPasajero->getApellido() . " es el apellido actual\n";
                    echo "Ingrese el nuevo apellido: "; 
                    $nuevoApellido = trim(fgets(STDIN));
                    $objPasajero->setApellido($nuevoApellido);
                    $resp = $objPasajero->modificar();
                    if($resp){
                        echo "\nEl apellido se ha cambiado correctamente!!\n";
                    }else{
                        echo $objPasajero->getMensajeOperacion() . "\n";
                    }
                break;
                //
                case 3: 
                    echo $objPasajero->getTelefono() . " es el telefono actual\n";
                    echo "Ingrese el nuevo telefono: "; 
                    $nuevoTelefono = trim(fgets(STDIN));
                    $objPasajero->setTelefono($nuevoTelefono);
                    $resp = $objPasajero->modificar();
                    if($resp){
                        echo "\nEl telefono se ha cambiado correctamente!!\n";
                    }else{
                        echo $objPasajero->getMensajeOperacion() . "\n";
                    }
                    break;
                //
                case 4: 
                    echo $objPasajero->getObjViaje()->getidViaje() . " es el viaje actual\n";
                    separador();
                    echo "\nLos viajes son: ". "\n" . mostrarEmpresas() . "\n";
                    separador();
                    echo "Ingrese el id del nuevo viaje del pasajero: ";
                    $nuevoViaje = trim(fgets(STDIN));
                    $objPasajero->getObjViaje()->setIdViaje($nuevoViaje);
                    $resp = $objPasajero->modificar();
                    if($resp){
                        echo "\nEl viaje se ha cambiado correctamente!!\n";
                    }else{
                        echo $objPasajero->getMensajeOperacion() . "\n";
                    }
                    break;
                //
                case 5:
                    echo $objPasajero->getNombre() . " es el nombre actual\n";
                    echo "Ingrese el nuevo nombre: "; 
                    $nuevoNombre = trim(fgets(STDIN));
                    $objPasajero->setNombre($nuevoNombre);
                    $resp1 = $objPasajero->modificar();
                    
                    echo $objPasajero->getApellido() . " es el apellido actual\n";
                    echo "Ingrese el nuevo apellido: "; 
                    $nuevoApellido = trim(fgets(STDIN));
                    $objPasajero->setApellido($nuevoApellido);
                    $resp2 = $objPasajero->modificar();
                    
                    echo $objPasajero->getTelefono() . " es el telefono actual\n";
                    echo "Ingrese el nuevo telefono: "; 
                    $nuevoTelefono = trim(fgets(STDIN));
                    $objPasajero->setTelefono($nuevoTelefono);
                    $resp3 = $objPasajero->modificar();
                    
                    echo $objPasajero->getObjViaje()->getidViaje() . " es el viaje actual\n";
                    separador();
                    echo "\nLos viajes son: ". "\n" . mostrarViajes() . "\n";
                    separador();
                    echo "Ingrese el id del nuevo viaje del pasajero: ";
                    $nuevoViaje = trim(fgets(STDIN));
                    $objPasajero->getObjViaje()->setIdViaje($nuevoViaje);
                    $resp4 = $objPasajero->modificar();

                    if($resp1 && $resp2 && $resp3 && $resp4){
                        echo "Los datos se han cambiado correctamente:\n";
                    }else{
                        echo $objPasajero->getMensajeOperacion() . "\n";
                    }
                //
                case 6: 
                    echo $objPasajero;
                break;
                //
                case 7: 
                    break;
                break;
                default:
                    echo "El número que ingresó no es válido, por favor ingrese un número del 1 al 7\n";
                break;    
            }
        }while($opcion != 7);
    }

    /**
    * Este modulo cambia los datos del responsable
    * @param object $objResponsable
    */
    function cambiarDatoResponsable($objResponsable){
        do{
            $opcion = menuModifResponsable();
            switch($opcion){
                //
                case 1: 
                    echo $objResponsable->getNombre() . " es el nombre actual\n";
                    echo "Ingrese el nuevo nombre: "; 
                    $nuevoNombre = trim(fgets(STDIN));
                    $objResponsable->setNombre($nuevoNombre);
                    $resp = $objResponsable->modificar();
                    if($resp){
                        echo "\nEl nombre se ha cambiado correctamente!!\n";
                    }else{
                        echo $objResponsable->getMensajeOperacion() . "\n";
                    }
                break;
                //
                case 2: 
                    echo $objResponsable->getApellido() . " es el apellido actual\n";
                    echo "Ingrese el nuevo apellido: "; 
                    $nuevoApellido = trim(fgets(STDIN));
                    $objResponsable->setApellido($nuevoApellido);
                    $resp = $objResponsable->modificar();
                    if($resp){
                       echo "\nEl apellido se ha cambiado correctamente!!\n";
                    }else{
                        echo $objResponsable->getMensajeOperacion() . "\n";
                    }
                break;
                //
                case 3: 
                    echo $objResponsable->getNumLicencia() . " es el numero de licencia actual\n";
                    echo "Ingrese el nuevo numero de licencia: "; 
                    $nuevoNumLicencia = trim(fgets(STDIN));
                    $objResponsable->setNumLicencia($nuevoNumLicencia);
                    $resp = $objResponsable->modificar();
                    if($resp){
                        echo "\nEl numero de licencia se ha cambiado correctamente!!\n";
                    }else{
                        echo $objResponsable->getMensajeOperacion() . "\n";
                    }
                break;
                //
                case 4:
                    echo $objResponsable->getNumLicencia() . " es el numero de licencia actual\n";
                    echo "Ingrese el nuevo numero de licencia: "; 
                    $nuevoNumLicencia = trim(fgets(STDIN));
                    $objResponsable->setNumLicencia($nuevoNumLicencia);
                    $resp3 = $objResponsable->modificar();

                    echo $objResponsable->getNombre() . " es el nombre actual\n";
                    echo "Ingrese el nuevo nombre: "; 
                    $nuevoNombre = trim(fgets(STDIN));
                    $objResponsable->setNombre($nuevoNombre);
                    $resp1 = $objResponsable->modificar();

                    echo $objResponsable->getApellido() . " es el apellido actual\n";
                    echo "Ingrese el nuevo apellido: "; 
                    $nuevoApellido = trim(fgets(STDIN));
                    $objResponsable->setApellido($nuevoApellido);
                    $resp2 = $objResponsable->modificar();

                    if($resp1 && $resp2 && $resp3){
                        echo "\nLos datos se han cambiado correctamente!!\n";
                    }else{
                        echo $objResponsable->getMensajeOperacion() . "\n";
                    }
                break;
                //
                case 5: 
                    echo $objResponsable;
                break;
                //
                case 6: 
                    break;
                break;
                default:
                    echo "El número que ingresó no es válido, por favor ingrese un número del 1 al 6\n";
                break;      
            }
        }while($opcion != 6);   
    }

    /**
    * Este modulo cambia los datos del viaje
    * @param object $objViaje
    */
    function cambiarDatosViaje($objViaje){
        do{
            $opcion = menuModifViaje();
            switch ($opcion){
                //
                case 1: 
                    echo $objViaje->getDestino() . " es el destino actual\n";
                    echo "Ingrese el nuevo destino: ";
                    $nuevoDestino = trim(fgets(STDIN));
                    $objViaje->setDestino($nuevoDestino);
                    $resp = $objViaje->modificar();
                    if($resp){
                        echo "\nEl destino se ha cambiado correctamente!!\n";
                    }else{
                        echo $objViaje->getMensajeOperacion() . "\n";
                    }
                break;
                //
                case 2: 
                    echo $objViaje->getCantMaxPasajeros() . " es la cantidad maxima actual\n";
                    echo "Ingrese la nueva capacidad máxima: ";
                    $nuevaCapacidad = trim(fgets(STDIN));
                    $objViaje->setCantMaxPasajeros($nuevaCapacidad);
                    $resp = $objViaje->modificar();
                    if($resp){
                        echo "\nLa capacidad máxima se ha cambiado correctamente!!\n";
                    }else{
                        echo $objViaje->getMensajeOperacion() . "\n";
                    }
                break;
                //
                case 3: 
                    echo $objViaje->getObjEmpresa() . "  \nEs la empresa a cargo actual\n";
                    separador();
                    echo "\nLas empresas son: ". "\n" . mostrarEmpresas() . "\n";
                    separador();
                    echo "Ingrese el id de la nueva empresa a cargo: ";
                    $nuevaEmpresa = trim(fgets(STDIN));
                    $objViaje->getObjEmpresa()->setIdEmpresa($nuevaEmpresa);
                    $resp = $objViaje->modificar();
                    if($resp){
                        echo "\nLa empresa se ha cambiado correctamente!!\n";
                    }else{
                        echo $objViaje->getMensajeOperacion() . "\n";
                    }
                break;
                //
                case 4: 
                    echo $objViaje->getObjResponsable() . "  \nEs el responsable a cargo actual\n";
                    separador();
                    echo "\nLos responsables son: ". "\n" . mostrarResponsables() . "\n";
                    separador();
                    echo "Ingrese el nuevo numero de empleado del responsable a cargo: ";
                    $nuevoResponsable = trim(fgets(STDIN));
                    $objViaje->getObjResponsable()->setNumEmpleado($nuevoResponsable);
                    $resp = $objViaje->modificar();
                    if($resp){
                        echo "\nEl responsable se ha cambiado correctamente!!\n";
                    }else{
                        echo $objViaje->getMensajeOperacion() . "\n";
                    }
                break;
                case 5: 
                    echo $objViaje->getImporte() . " es el importe actual\n";
                    echo "Ingrese el nuevo importe: ";
                    $nuevoImporte = trim(fgets(STDIN));
                    $objViaje->setImporte($nuevoImporte);
                    $resp = $objViaje->modificar();
                    if($resp){
                        echo "\nEl importe se ha cambiado correctamente!!\n";
                    }else{
                        echo $objViaje->getMensajeOperacion() . "\n";
                    }
                break;
                case 6: 
                    echo $objViaje->getDestino() . " es el destino actual\n";
                    echo "Ingrese el nuevo destino: ";
                    $nuevoDestino = trim(fgets(STDIN));
                    $objViaje->setDestino($nuevoDestino);
                    $resp1 = $objViaje->modificar();
                    
                    echo "\n" . $objViaje->getCantMaxPasajeros() . " es la cantidad maxima actual\n";
                    echo "Ingrese la nueva capacidad maxima: ";
                    $nuevaCapacidad = trim(fgets(STDIN));
                    $objViaje->setCantMaxPasajeros($nuevaCapacidad);
                    $resp2 = $objViaje->modificar();
                    
                    echo "\n" . $objViaje->getObjEmpresa() . "  \nEs la empresa a cargo actual\n";
                    separador();
                    echo "\nLas empresas son: ". "\n" . mostrarEmpresas() . "\n";
                    separador();
                    echo "Ingrese la nueva empresa a cargo: ";
                    $nuevaEmpresa = trim(fgets(STDIN));
                    $objViaje->getObjEmpresa()->setIdEmpresa($nuevaEmpresa);
                    $resp3 = $objViaje->modificar();
                    
                    echo "\n" . $objViaje->getObjResponsable() . "  \nEs el responsable a cargo actual\n";
                    separador();
                    echo "\nLos responsables son: ". "\n" . mostrarResponsables() . "\n";
                    separador();
                    echo "Ingrese el nuevo responsable a cargo: ";
                    $nuevoResponsable = trim(fgets(STDIN));
                    $objViaje->getObjResponsable()->setNumEmpleado($nuevoResponsable);
                    $resp4 = $objViaje->modificar();
                    
                    echo "\n" . $objViaje->getImporte() . " es el importe actual\n";
                    echo "Ingrese el nuevo importe: ";
                    $nuevoImporte = trim(fgets(STDIN));
                    $objViaje->setImporte($nuevoImporte);
                    $resp5 = $objViaje->modificar();
                    

                    if($resp1 && $resp2 && $resp3 && $resp4 && $resp5){
                        echo "\nLos datos se han cambiado correctamente!!\n";
                    }else{
                        echo $objViaje->getMensajeOperacion() . "\n";
                    }
                break;
                //
                case 7: 
                    echo $objViaje;
                    $objViaje->obtenerPasajeros();
                    $colObjPasajeros = $objViaje->getColObjPasajeros();
                    if(count($colObjPasajeros) == 0){
                        echo "\nNo hay pasajeros en este viaje!!\n\n";
                    }
                break;
                //
                case 8: 
                    break;
                break;
                default:
                    echo "El número que ingresó no es válido, por favor ingrese un número del 1 al 8\n";
                break;
            }
        }while($opcion != 8);
    }

    /**
    * Este modulo cambia los datos de la empresa
    * @param object $objEmpresa
    */
    function cambiarDatoEmpresa($objEmpresa){
        do{
            $opcion = menuModifEmpresa();
            switch ($opcion){
                //
                case 1: 
                    echo $objEmpresa->getNombre() . " es el nombre actual\n";
                    echo "Ingrese el nuevo nombre: "; 
                    $nuevoNombre = trim(fgets(STDIN));
                    $objEmpresa->setNombre($nuevoNombre);
                    $resp = $objEmpresa->modificar();
                    if($resp){
                        echo "\nEl nombre se ha cambiado correctamente!!\n";
                    }else{
                        echo $objEmpresa->getMensajeOperacion() . "\n";
                    }
                break;
                //
                case 2: 
                    echo $objEmpresa->getDireccion() . " es la direccion actual\n";
                    echo "Ingrese la nueva direccion: "; 
                    $nuevaDireccion = trim(fgets(STDIN));
                    $objEmpresa->setDireccion($nuevaDireccion);
                    $resp = $objEmpresa->modificar();
                    if($resp){
                        echo "\nLa direccion se ha cambiado correctamente!!\n";
                    }else{
                        echo $objEmpresa->getMensajeOperacion() . "\n";
                    }
                break;
                //
                case 3:
                    echo $objEmpresa->getNombre() . " es el nombre actual\n";
                    echo "Ingrese el nuevo nombre: "; 
                    $nuevoNombre = trim(fgets(STDIN));
                    $objEmpresa->setNombre($nuevoNombre);
                    $resp1 = $objEmpresa->modificar();

                    echo $objEmpresa->getDireccion() . " es la direccion actual\n";
                    echo "Ingrese la nueva direccion: "; 
                    $nuevaDireccion = trim(fgets(STDIN));
                    $objEmpresa->setDireccion($nuevaDireccion);
                    $resp2 = $objEmpresa->modificar();

                    if($resp1 && $resp2){
                        echo "\nLos datos se han cambiado correctamente!!\n";
                    }else{
                        echo $objEmpresa->getMensajeOperacion() . "\n";
                    }
                break;
                //
                case 4: 
                    echo $objEmpresa;
                break;
                //
                case 5: 
                    break;
                break;
                default:
                    echo "El número que ingresó no es válido, por favor ingrese un número del 1 al 5\n";
                break;
            }
        }while($opcion != 5);
    }

    /**
    * Este modulo modifica datos del viaje
    */
    function opcionesViaje(){
        $objViaje = buscarViaje();
        do{
        $opcion = menuViajes();
            switch($opcion){
                // Ver los datos del viaje
                case 1:
                    echo "Los datos del viaje son: \n" . $objViaje . "\n";
                    $objViaje->obtenerPasajeros();
                    $colObjPasajeros = $objViaje->getColObjPasajeros();
                    if(count($colObjPasajeros) == 0)
                        echo "  No hay pasajeros cargados!!!\n";
                break;
                // Ver la cantidad de pasajeros
                case 2: 
                    $objViaje->obtenerPasajeros();
                    echo "La cantidad de pasajeros del viaje a " . $objViaje->getDestino() . " son: ". count($objViaje->getColObjPasajeros()) . "\n";
                break;
                // Ver datos de un pasajero
                case 3: 
                    $objViaje->obtenerPasajeros();
                    $colObjPasajeros = $objViaje->getColObjPasajeros();
                    if(count($colObjPasajeros) > 0){
                        echo "Ingrese el DNI del pasajero que desea buscar: ";
                        $dni = trim(fgets(STDIN));
                        $pasaj = $objViaje->buscarPasajero($dni);
                            if($pasaj <> -1){
                                echo "Los datos del pasajero son: \n";
                                echo $objViaje->getColObjPasajeros()[$pasaj];
                            }else{
                                echo "\nEl pasajero ingresado no existe!!\n";
                            }
                        }else{
                            echo "\nNo hay pasajeros en este viaje!!\n\n";
                        }
                break;
                // Ver los datos de los pasajeros
                case 4:
                    $objViaje->obtenerPasajeros();
                    $colObjPasajeros = $objViaje->getColObjPasajeros();
                    if(count($colObjPasajeros) > 0){
                        echo "Las personas del viaje son: \n";
                        foreach($colObjPasajeros as $objPasajero){
                            echo $objPasajero . "\n";
                        }
                    }else{
                        echo "\nNo hay pasajeros en este viaje!!\n\n";
                    }
                break;
                // Modificar los datos de un pasajero
                case 5:
                    $objViaje->obtenerPasajeros();
                    $colObjPasajeros = $objViaje->getColObjPasajeros();
                    if(count($colObjPasajeros) > 0){
                        echo "Ingrese el DNI del pasajero a modificar: ";
                        $dni = trim(fgets(STDIN));
                        $objPasajero = new Pasajero();
                        $resp = $objPasajero->buscar($dni);
                        if($resp){
                            cambiarDatoPasajero($objPasajero);
                        }else{
                            echo "El DNI del pasajero ingresado no existe!!\n";
                        }
                    }else{
                        echo "\nNo hay pasajeros en este viaje!!\n\n";
                    }
                break;
                // Agregar pasajeros al viaje
                case 6: 
                    $hayPasaje = $objViaje->hayPasaje();
                    if($hayPasaje){
                        echo "Ingrese cuantos pasajeros desea ingresar: ";
                            $cantPasajerosNuevos = trim(fgets(STDIN));
                            $cantTotal = count($objViaje->getColObjPasajeros()) + $cantPasajerosNuevos;
                            if($cantTotal <= $objViaje->getCantMaxPasajeros()){
                                for($i=0;$i<$cantPasajerosNuevos;$i++){
                                    echo "\nPasajero " . ($i+1) . "\n";
                                    crearPasajero($objViaje);
                                }                
                            }else{
                                echo "La cantidad de pasajeros es superior a la capacidad maxima!!\n";
                            }
                    }else{
                    echo "\nEl viaje ya llegó a su capacidad máxima!!\n\n";
                    }
                break;
                // Eliminar un pasajero del viaje
                case 7: 
                    $objViaje->obtenerPasajeros();
                    $colObjPasajeros = $objViaje->getColObjPasajeros();
                    if(count($colObjPasajeros) > 0){
                        echo "Ingrese el DNI del pasajero a eliminar: ";
                        $dni = trim(fgets(STDIN));
                        $objPasajero = new Pasajero();
                        $resp = $objPasajero->buscar($dni);
                        if($resp){
                            $resp = $objPasajero->eliminar($dni);
                            if($resp){
                                echo "El pasajero se elimino correctamente!!\n";
                            }else{
                                echo $objPasajero->getMensajeOperacion() . "\n";
                            }
                        }else{
                            echo "El DNI del pasajero ingresado no existe!!\n";
                        }
                    }else{
                        echo "\nNo hay pasajeros en este viaje!!\n\n";
                    }
                break;
                // Modificar el responsable viaje
                case 8: 
                    cambiarDatoResponsable($objViaje->getObjResponsable());
                break;
                // Modificar datos del viaje
                case 9: 
                    cambiarDatosViaje($objViaje);
                break;
                // Vuelve al menu principal
                case 10: 
                    break;
                break;
                default: 
                    echo "El número que ingresó no es válido, por favor ingrese un número del 1 al 10\n";
                    $opcion = menuViajes();
                break;
            }
        }while($opcion != 10);
    }

    function opcionesMenuInicio($opc){
        switch($opc){
            // Ingresar un viaje
            case 1:
                echo "Ingrese la cantidad de viajes que desea agregar: ";
                $cant = trim(fgets(STDIN));
                cargarViajes($cant);
            break;
            // Ingresar una empresa
            case 2:
                cargarEmpresa();
            break;
            // Ingresar un responsable
            case 3:
                cargarResponsable();
            break;
            // Modificar un viaje
            case 4:
                opcionesViaje();
            break;
            // Modificar una empresa
            case 5:
                $objEmpresa = new Empresa();
                echo "Ingrese el id de la empresa que desea modificar: \n" . separador() . mostrarEmpresas();
                echo separador() . "Id empresa: ";
                $idEmpresa = trim(fgets(STDIN));
                $resp = $objEmpresa->buscar($idEmpresa);
                if($resp){
                    cambiarDatoEmpresa($objEmpresa);
                }else{
                    echo "El numero de la empresa seleccionada no existe!!\n";
                }
            break;
            //Modificar un Responsable
            case 6:
                $objResponsable = new ResponsableV();
                echo "Ingrese el numero de empleado del responsable que desea modificar: \n" . separador() . mostrarResponsables();
                echo separador() . "Num Empleado: ";
                $numEmpleado = trim(fgets(STDIN));
                $resp = $objResponsable->buscar($numEmpleado);
                if($resp){
                    cambiarDatoResponsable($objResponsable);
                }else{
                    echo "El numero del responsable seleccionado no existe!!\n";
                }
            break;
            // Eliminar un viaje
            case 7:
                echo "Los viajes son: ". "\n" . separador() . mostrarViajes() . separador() . "\n";
                echo "Ingrese el codigo del viaje que desea eliminar: ";
                $codigo = trim(fgets(STDIN));
                $objViaje = new Viaje();
                $resp = $objViaje->buscar($codigo);
                while(!$resp && $codigo != 0){
                    echo "\nEl codigo ingresado no existe, ingrese alguno de los viajes o 0 para salir: " . "\n\n" . separador() . mostrarViajes() . separador() . "Codigo: ";
                    $codigo = trim(fgets(STDIN));
                    $resp = $objViaje->buscar($codigo);
                }
                if($codigo != 0){
                    $objViaje->obtenerPasajeros();
                    if(count($objViaje->getColObjPasajeros()) == 0){
                        $resp = $objViaje->eliminar();
                        if($resp){
                            echo "El viaje fue eliminado correctamente!!\n";
                        }else{
                            echo "El codigo no coicide con ningun viaje!!\n";
                        }
                    }else{
                        echo "El viaje no se puede eliminar porque tiene pasajeros!!\n";
                    }
                }
                
            break;    
            // Salir del programa
            case 8:
                exit();
            break;
            default: 
                echo "El número que ingresó no es válido, por favor ingrese un número del 0 al 8\n";
            break;
        }
    }

    // PROGRAMA PRINCIPAL
    do{
        $objViaje = new Viaje();
        $cantViajes = count($objViaje->listar(""));
        if($cantViajes == 0){
            echo "No hay viajes!! Ingrese la opcion 1, 2, o 3: \n";
            $opcion = menuPrincipal();
            while(($opcion != 1) && ($opcion != 2) && ($opcion != 3) && ($opcion != 10)){
                echo "No hay viajes!! Ingrese la opcion 1, 2, o 3: \n";
                $opcion = trim(fgets(STDIN));
            }
            opcionesMenuInicio($opcion);
        }else{
            $opcion = menuPrincipal();
            opcionesMenuInicio($opcion);
        }
    }while($opcion != 8);


