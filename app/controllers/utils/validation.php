<?php

class validation
{
    public function validateEmail($email)
    {
        if (preg_match("/@(.*)/", $email, $dominio)) {
            if ($dominio[1] === "udistrital.edu.co") {
                return true;
            }
        }
    }

    public function validatepassword($password)
    {
        if (
            preg_match("/[a-z]/", $password) &&
            preg_match("/[A-Z]/", $password) &&
            preg_match("/[0-9]/", $password) &&
            preg_match("/[@$!%*?&#.]/", $password) &&
            strlen($password) >= 8
        ){
            return true;
        } else return false;
    }
    public function validarlogin($email,$password){
        $adminDAO = new AdminDAO();
        $tutorDAO = new TutorDAO();
       
          if ($tutorDAO->comprobarCorreo($email)) {
                if ($tutorDAO->verificarEstado($email)) {
                    header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=2');
                    exit;
                }
                $tutor =$tutorDAO->validarLogin($email);

                if (password_verify($password, $tutor->getContrasena())) {
                    session_start();
                    $_SESSION['usuario'] = $tutor;
                    $_SESSION['rol'] = 'tutor';
                    header('Location: ' . BASE_URL . 'index.php?url=RouteController/tutor&session=success');
                    exit;
                } else {
                    header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=1');
                    error_log('Error de inicio de sesión: contraseña incorrecta para el correo ' . $tutor->getContrasena());
                    exit;
                }
            }

            // Si es administrador
            $admin = $adminDAO->obtenerAdminPorCorreo($email);
            if ($password == $admin->getContrasena()) {
                session_start();
                $_SESSION['usuario'] = $admin;
                $_SESSION['rol'] = 'administrador';
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/admin&session=success');
                exit;
            }
    }
}
