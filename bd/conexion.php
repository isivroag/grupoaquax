<?php
    class conn{
        
        function connect(){
        
            define('servidor','127.0.0.1');
            define('bd_nombre','aquast');
            define('usuario','root');
            define('password','');

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