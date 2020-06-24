<?php
/**
 * Created by PhpStorm.
 * User: ORDI
 * Date: 16/08/2018
 * Time: 00:45
 */
    /*Gerateur de mot de passe*/
    function generatepassword($longueur) {

        $Chaine = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ!?#&[]-$%@";
        $Chaine = str_shuffle($Chaine);

        $Chaine = substr($Chaine,0,$longueur);

        return $Chaine;
    }