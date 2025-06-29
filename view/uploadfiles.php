<?php

require_once(__DIR__ . '/../app/controllers/models/DTO/EstudianteDTO.php');
session_start();
require_once(__DIR__ . '/layouts/nav.php');

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Perfil - Estudiante</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- notyf vía CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

</head>

<body style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover;"
    class="bg-gray-100 bg-cover bg-bottom bg-no-repeat">
    <div class="flex flex-col min-h-screen w-auto">

        <div class="flex-grow flex-col flex items-center justify-center px-4 mt-20 xl:mr-0  mr-48 w-full">
            <div
                class="bg-[#604c9c] rounded-t-3xl shadow-md p-10 xl:w-full xl:max-w-xl transform hover:shadow-2xl transition ease-in-out duration-500 mb-0">
                <h1 class="text-3xl  text-white  font-sans font-bold text-center">Subir archivos academicos</h1>
            </div>
            <div
                class="bg-gray-50 rounded-b-3xl shadow-md p-10 w-full max-w-xl transform hover:shadow-2xl transition ease-in-out duration-500 mt-0">
                <?php
                ?>
                <form action="<?= BASE_URL ?>index.php?url=FilesController/uploadfiles" method="POST" enctype="multipart/form-data" >
                    <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file"
                                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    

                                    <!-- Aquí se mostrará el nombre del archivo -->
                                    <p id="file-name" class="mt-3 text-sm text-gray-700 font-medium hidden"></p>
                                </div>
                                <input id="dropzone-file" type="file" name="archivo" class="hidden" required />
                            </label>
                     </div>
                     <script src="<?= BASE_URL ?>public/js/seename.js"></script>
                    <div class="mb-5">
                        <label for="Profesor" class="block font-semibold text-[#5D54A4]">Profesor : </label>
                        <select name="profesor" id="profesor"
                            class="w-full px-4 py-2 mt-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#5D54A4]" required>
                            <?php /** @var ProfesorDTO $profesor */
                                ?>
                            <?php foreach ($profesores as $profesor): ?>
                            <option value="<?= $profesor->getCod() ?>">
                                <?= $profesor->getNom() ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="Areas" class="block font-semibold text-[#5D54A4]">Areas : </label>
                        <select name="area" id="area"
                            class="w-full px-4 py-2 mt-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#5D54A4]" required>
                            <?php /** @var AreaDTO $area */
                                ?>
                            <?php foreach ($areas as $area): ?>
                            <option value="<?= $area->getCodigo() ?>">
                                <?= $area->getNombre() ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="Materias" class="block font-semibold text-[#5D54A4]">Materia : </label>
                        <select name="materia" id="materia"
                            class="w-full px-4 py-2 mt-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#5D54A4]" required>
                            <?php /** @var MateriaDTO $materia */
                                ?>
                            <?php foreach ($materias as $materia): ?>
                            <option value="<?= $materia->getId() ?>">
                                <?= $materia->getNom_materia() ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex items-center justify-between">
                        <button
                            class="bg-[#5D54A4] hover:bg-[#4A4192] text-gray-50 font-semibold py-2 px-6 rounded-full shadow-md transform hover:scale-105 transition ease-in-out duration-300"
                            type="submit">
                            Subir Archvio
                        </button>
                        <a href="<?= BASE_URL ?>index.php?url=RouteController/student"
                            class="text-[#5D54A4] font-semibold hover:text-[#4A4192]">
                            Cancelar
                        </a>
                    </div>

                </form>
            </div>
        </div>
      


        

        <!-- FAQ opcional -->
        <div class="p-5 text-gray-50 font-semibold text-right">
            <a href="#" class="">FAQ</a>
        </div>
    </div>
    <script src="<?= BASE_URL ?>public/js/notyf.js"></script>
     <?php  
    if (isset($_GET['error'])){
    $Messages = [
        1 => 'Tipo de archivo no valido, comuniquese con soporte',
        2 => 'Error al subir el archivo',
    ];
    $msg = $Messages[$_GET['error']] ?? $Messages[1];
    ?>
   <script>
    showErrorRegister(`<?= $msg ?>`, { x: 'right', y: 'top' });
    </script>
<?php } ?>                               
</body>

</html>