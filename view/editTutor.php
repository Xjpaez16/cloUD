<?php
require_once(__DIR__ . '/../app/controllers/models/DTO/TutorDTO.php');


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Perfil - Tutor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- notyf vía CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    
</head>

<body style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover;"
    class="bg-gray-100 bg-cover bg-bottom bg-no-repeat">

    <?php
    $rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;
    $tutor = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
    error_log("Rol del usuario: " . $rol);
    error_log("Nom usuario: " . $tutor->getNombre());
    if ($rol == "tutor") { ?>
        <div class="flex flex-col min-h-screen w-auto">

            <div class="flex-grow flex-col flex items-center justify-center px-4 mt-20 xl:mr-0  mr-48 w-full">
                <div
                    class="bg-[#604c9c] rounded-t-3xl shadow-md p-10 xl:w-full xl:max-w-xl transform hover:shadow-2xl transition ease-in-out duration-500 mb-0">
                    <h1 class="text-3xl  text-white  font-sans font-bold text-center">Modificar mi información</h1>
                </div>
                <div
                    class="bg-gray-50 rounded-b-3xl shadow-md p-10 w-full max-w-xl transform hover:shadow-2xl transition ease-in-out duration-500 mt-0">

                    <form action="<?= BASE_URL ?>index.php?url=TutorController/updateProfile" method="POST">
                        <div class="mb-5">
                            <label for="nombre" class="block font-semibold text-[#5D54A4]">Nombre</label>
                            <input id="nombre" name="nombre" type="text" value="<?php echo $tutor->getNombre(); ?>" required
                                class="w-full px-4 py-2 mt-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#5D54A4]" />
                        </div>

                        <div class="mb-5">
                            <label for="correo" class="block font-semibold text-[#5D54A4]">Correo</label>
                            <input id="correo" name="correo" type="email" value="<?php echo $tutor->getCorreo(); ?>"
                                required
                                class="w-full px-4 py-2 mt-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#5D54A4]" />
                        </div>
                        <div class="mb-5">
                            <label for="correo" class="block font-semibold text-[#5D54A4]">Tus areas del saber : </label>
                            <ul>
                                <?php /** @var AreaDTO $area */

                                $areasSeleccionadas = array_column($checkedAreas, 'codigo');

                                foreach ($areas as $area) :
                                ?>
                                    <li> <input type="checkbox" name="area[]" value="<?= $area->getCodigo(); ?>"
                                            <?php if (in_array($area->getCodigo(), $areasSeleccionadas)) echo 'checked'; ?> />
                                        <?= $area->getNombre() ?> </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="flex flex-wrap items-center justify-between gap-4 pb-5">

                            <div class="text-sm">
                                <a href="<?= BASE_URL ?>index.php?url=RouteController/changePassword"
                                    class="text-purple-600 hover:underline font-semibold xl:text-[16.5px]">
                                    ¿Quieres cambiar tu contraseña?
                                </a>
                            </div>
                        </div>


                        <div class="flex items-center justify-between">
                            <button
                                class="bg-[#5D54A4] hover:bg-[#4A4192] text-gray-50 font-semibold py-2 px-6 rounded-full shadow-md transform hover:scale-105 transition ease-in-out duration-300"
                                type="submit">
                                Guardar Cambios
                            </button>
                            <a href="<?= BASE_URL ?>index.php?url=RouteController/tutor" class="text-[#5D54A4] font-semibold hover:text-[#4A4192]">
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
        </div>
         <script src="<?= BASE_URL ?>public/js/notyf.js"></script><!-- .flex-col -->
    <?php if (isset($_GET['error'])) {
    $errorMessages = [
        1 => 'La informacion no ha podido ser editada',
       
    ];
    $msg = $errorMessages[$_GET['error']] ?? $errorMessages[1];
    ?>
    <script>
      showError('<?= $msg ?>');
    </script>?>
    <?php }elseif(isset($_GET['success'])) { 
    $successMessages = [
        1 => 'Su informacion ha sido cambiada',
        
    ];
    $msg = $successMessages[$_GET['success']] ?? $successMessages[1];
?>
    <script>
      showSuccess('<?= $msg ?>');
    </script>
<?php } ?>  ?><!-- .flex-col -->
</body>

</html>