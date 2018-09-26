<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
/********************************************************************************************************
 * FUNCIÓN - 1
 * FUNCIÓN QUE PROCESA ARCHIVO PDF Y EXTRAE LA CÉDULA, NOMBRE Y TELÉFONO Y LO INSERTA EN LA BASE DE DATOS
 * ******************************************************************************************************/

/*FUNCIÓN PARA DETERMINAR SI ES NÚMERO*/
function isnums($c)
{
    if (($c=='0') || ($c=='1') || ($c=='2') || ($c=='3') || ($c=='4') || ($c=='5') || ($c=='6') || ($c=='7') || 
        ($c=='8') || ($c=='9') || ($c==' ')) return true;
    return false;
}

function isnum($c)
{
    if (($c=='0') || ($c=='1') || ($c=='2') || ($c=='3') || ($c=='4') || ($c=='5') || ($c=='6') || ($c=='7') || 
        ($c=='8') || ($c=='9')) return true;
    return false;
}

/***************
 * FIN FUNCIÓN-1
 * *************/

/*---------------------------------------------------------------------------------------------------------------*/

/********************************************************************************************************
 * FUNCIÓN-2 
 * FUNCIÓN QUE DEVUELVE TODA LA INFORMACIÓN DEL DIRECTORIO ACTIVO CON EL PARÁMETRO CÉDULA O INDICADOR
 * ******************************************************************************************************/
function verificar_usuario_i($parametro)
{
    $SERVIDOR_LDAP = "LDAP://SERVIDOR.DOMINIO.COM";
    $PUERTO_LDAP = 389;
    
    $ldap_server = $SERVIDOR_LDAP;
    $puerto = $PUERTO_LDAP;
    
    if ($connect=@ldap_connect($ldap_server,$puerto))
    { 
        ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
        
        if (($bind=@ldap_bind($connect)) == false) return 0;
        
        if(is_numeric($parametro))
        {
        if (($res_id = @ldap_search( $connect,
                                     "OU=Usuarios,DC=empresa,DC=com",
                                     "empresacom-AD-cedula=$parametro")) == false) 
                                     {
                                        @ldap_close($connect);
                                        return 0; 
                                     }
        }
        else
        {
        if (($res_id = @ldap_search( $connect,
                                     "OU=Usuarios,DC=empresa,DC=com",
                                     "uid=$parametro")) == false) 
                                     {
                                        @ldap_close($connect);
                                        return 0; 
                                     }            
        }
        if (!ldap_count_entries($connect, $res_id)) 
        {
            $error = ['error' => 'Error'];
            echo json_encode($error);
            @ldap_close($connect);
            return 0;
        }
        else
        {

        $atributos = ldap_get_entries($connect, $res_id);

        var_dump($atributos);

        for($i=0;$i<$atributos['count'];$i++)
        {

            $data[$i]['cedula'] = $atributos[$i]['empresacom-ad-cedula'][0];
            $data[$i]['nombre'] = $atributos[$i]['cn'][0];
            $data[$i]['foto'] = "http://ccschu14.empresa.com/PHOTOS/".substr_replace("000000000", $atributos[$i]["empresacom-ad-cedula"][0], strlen($atributos[$i]["empresacom-ad-cedula"][0])*(-1)).".jpg";

            $data[$i]['negocio'] = $atributos[$i]['company'][0];
            $data[$i]['localidad'] = $atributos[$i]['l'][0];
            $data[$i]['ext'] = $atributos[$i]['ipphone'][0];
            $data[$i]['celular'] = $atributos[$i]['mobile'][0];
            $data[$i]['correo'] = $atributos[$i]['mail'][0];
            $data[$i]['empleado'] = $atributos[$i]['employeetype'][0];
            $data[$i]['cargo'] = $atributos[$i]['title'][0];
            $data[$i]['nomina'] = $atributos[$i]['empresacom-ad-payrollclass'][0];
            $data[$i]['area'] = $atributos[$i]['empresacom-ad-physicalarea'][0];
            $data[$i]['aniversario'] = $atributos[$i]['empresacom-ad-hiredate'][0];
            $data[$i]['supervisor'] = $atributos[$i]['empresacom-ad-functionalsupervisor'][0];
            $data[$i]['organizacion'] = $atributos[$i]['empresacom-ad-organization'][0];
            $data[$i]['edif'] = $atributos[$i]['empresacom-ad-buildingname'][0];
            $data[$i]['descripcion'] = $atributos[$i]['description'][0];
        }

        /*$data = [
                    [ 
                        'cedula'=>'14828113', 
                        'nombre'=>'Juan'
                    ],
                    [ 
                        'cedula'=>'15326458', 
                        'nombre'=>'Kai'
                    ]
                ];*/

            echo json_encode($data);
        }
        
        @ldap_close($connect);
        
    } else return 0;
}
/***************
 * FIN FUNCIÓN-2
 * *************/

/*********************************************
 * CAPTURA LOS ARGUMENTOS POR LÍNEA DE COMANDO
 * *******************************************/



     verificar_usuario_i('$_REQUEST['query']');    
     //verificar_usuario_i('asdasd');    
    
?>

