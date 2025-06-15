<?php

    class validation{
        public function validateEmail($email) {
            if(preg_match("/@(.*)/",$email, $dominio)){
                if($dominio[1] === "udistrital.edu.co"){
                    return true;
            }
        }
    }

        public function validatepassword($password){
            if(
               preg_match("/[a-z]/", $password) &&
               preg_match("/[A-Z]/", $password) &&
               preg_match("/[0-9]/", $password) &&
               preg_match("/[@$!%*?&#.]/", $password) &&
                strlen($password) > 8
            ){
                return true;
            }
            else return false;       
        }
    }
?>