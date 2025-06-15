<?php
require_once(__DIR__ . '/../app/controllers/models/DTO/EstudianteDTO.php');


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil - Estudiante</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover;" 
      class="bg-gray-100 bg-cover bg-bottom bg-no-repeat">
    
    <?php 
    $rol = isset($_SESSION['rol'])? $_SESSION['rol'] : null;
    $student = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
    /*error_log("Rol del usuario: " . $rol);
    error_log("Nom usuario: " . $student->getNombre());*/
    if($rol == "estudiante"){?>
    <div class="flex flex-col min-h-screen w-auto">
  
        <div class="flex-grow flex-col flex items-center justify-center px-4 mt-20 xl:mr-0  mr-48 w-full">
            <div class= "bg-[#604c9c] rounded-t-3xl shadow-md p-10 xl:w-full xl:max-w-xl transform hover:shadow-2xl transition ease-in-out duration-500 mb-0">
                <h1 class="text-3xl  text-white  font-sans font-bold text-center">Modificar mi información</h1>
            </div>
            <div class="bg-gray-50 rounded-b-3xl shadow-md p-10 w-full max-w-xl transform hover:shadow-2xl transition ease-in-out duration-500 mt-0">
                
                <form action="<?= BASE_URL ?>index.php?url=StudentController/updateProfile" method="POST">
                    <div class="mb-5">
                        <label for="nombre" class="block font-semibold text-[#5D54A4]">Nombre</label>
                        <input id="nombre" name="nombre" type="text" 
                                value="<?php echo $student->getNombre(); ?>" 
                                required
                                class="w-full px-4 py-2 mt-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#5D54A4]" />
                    </div>
                    <div class="mb-5">
                        <label for="correo" class="block font-semibold text-[#5D54A4]">Correo</label>
                        <input id="correo" name="correo" type="email" 
                                value="<?php echo $student->getCorreo(); ?>" 
                                required
                                class="w-full px-4 py-2 mt-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#5D54A4]" />
                    </div>
                    <div class="mb-4">
                            <label for="carrera"
                                class="block mb-2 text-sm md:text-md xl:text-lg font-medium text-gray-900 dark:text-black">Carrera</label>
                            <select name="carrer" id="carrera" class=" bg-gray-50 border border-gray-300 text-gray-900
                                text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                                dark:focus:ring-blue-500 dark:focus:border-blue-500 ">
                                <?php /** @var CarreraDTO $carrera */
                                ?>
                                <?php foreach ($carreras as $carrera): ?>
                                    <option value="<?= $carrera->getCodigo() ?>"
                                        <?= $student->getCod_carrera() == $carrera->getCodigo() ? 'selected' : '' ?>>
                                        <?= $carrera->getCodigo() . " - " . $carrera->getNom_carrera() ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <div class="flex flex-wrap items-center justify-between gap-4 pb-5">
                            <div class="text-sm">
                                <a href="jajvascript:void(0);"
                                    class="text-purple-600 hover:underline font-semibold xl:text-[16.5px]">
                                    ¿Quieres cambiar tu contraseña?
                                </a>
                            </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <button class="bg-[#5D54A4] hover:bg-[#4A4192] text-gray-50 font-semibold py-2 px-6 rounded-full shadow-md transform hover:scale-105 transition ease-in-out duration-300" 
                                type="submit">
                            Guardar Cambios
                        </button>
                        <a href="<?= BASE_URL ?>index.php?ruta=RouteController/student" 
                           class="text-[#5D54A4] font-semibold hover:text-[#4A4192]">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <?php } ?>

        <!-- FAQ opcional -->
        <div class="p-5 text-gray-50 font-semibold text-right">
            <a href="#" class="">FAQ</a>
        </div>
    </div><!-- .flex-col -->
</body>
</html>
