<?php
    class conn{
        
        function connect(){
        
            define('servidor','grupoaquax.mx');
            define('bd_nombre','grupoaqu_aquax');
            define('usuario','grupoaqu_uaquax');
            define('password','Gp0Aquax.2021');

            $opciones=array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

            try{
                $conexion=new PDO("mysql:host=".servidor.";dbname=".bd_nombre, usuario,password, $opciones);
                return $conexion;
            }catch(Exception $e){
                return null;
            }
        }
    }
?>