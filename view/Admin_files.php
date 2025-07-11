<?php
require_once __DIR__ . '/../app/controllers/models/DTO/S3DTO.php';
require_once __DIR__ . '/../app/controllers/models/DTO/ArchivoDTO.php';
require_once __DIR__ . '/../app/controllers/models/DAO/ArchivoDAO.php';
require_once __DIR__ . '/../app/controllers/models/DTO/AdminDTO.php';

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Archivos Subidos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
</head>

<body class="relative min-h-screen bg-cover bg-bottom bg-no-repeat text-white font-sans"
    style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg');">
    
    <div class="max-w-6xl mx-auto">
       
        <h1 class="text-3xl font-bold mb-6 text-center text-white pt-8 pb-8 ">📂 Archivos Subidos al Repositorio de cloUD
        </h1>
        <div class="flex flex-col items-center justify-center text-black pt-10">
             <a href="<?= BASE_URL ?>RouteController/admin">
                <button class="bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-700 hover:to-purple-500 text-white font-bold py-3 px-6 rounded-xl shadow-lg text-lg transition-all duration-300 transform hover:scale-105 ">Volver</button>
             </a>
            <div class="grid grid-cols-1 md:grid-cols-3  lg:grid-cols-3 xl:grid-cols-3 gap-12">
                <div class="mb-5">
                    <label for="Profesor" class="block font-semibold text-white">Profesor : </label>
                    <select name="profesor" id="profesor"
                        class="w-full px-4 py-2 mt-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 font-semibold focus:ring-[#5D54A4] "
                        required>
                        <option value="">Ninguno</option>
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
                    <label for="Areas" class="block font-semibold text-white">Areas : </label>
                    <select name="area" id="area"
                        class="w-full px-4 py-2 mt-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 font-semibold focus:ring-[#5D54A4] "
                        required>
                        <option value="">Ninguno</option>
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
                    <label for="Materias" class="block font-semibold text-white">Materia : </label>
                    <select name="materia" id="materia"
                        class="w-full px-4 py-2 mt-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 font-semibold focus:ring-[#5D54A4] "
                        required>
                        <option value="">Ninguno</option>
                        <?php /** @var MateriaDTO $materia */
                        ?>
                        <?php foreach ($materias as $materia): ?>

                            <option value="<?= $materia->getId() ?>">

                                <?= $materia->getNom_materia() ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <?php if (!empty($error)): ?>
            <p class="text-red-600 text-center">❌ <?= $error ?></p>
        <?php elseif (empty($archivos)): ?>
            <p class="text-center text-gray-300 pt-8 font-sans font-bold">No hay archivos subidos aún.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 pt-8">
                <?php foreach ($archivos as $archivo): ?>
                    <?php
                    $ext = strtolower($archivoDAO->obtenertipo($archivo->getId_tipo()));
                    error_log("extension : " . $ext);
                    $archivo->getId_tipo();
                    $url = $archivo->getRuta();
                    $nombre = basename($url);

                    ?>
                    <div class="bg-white text-black p-4 rounded-lg shadow-md hover:shadow-lg transition archivo"
                        data-area="<?= strtolower($archivoDAO->obtenerarea($archivo->getCod_area())) ?>"
                        data-profesor="<?= strtolower($archivoDAO->obtenerprofesor($archivo->getCod_profesor())) ?>"
                        data-materia="<?= strtolower($archivoDAO->obtenermateria($archivo->getId_materia())) ?>">
                        <?php if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                            <a href="<?= $url ?>" target="_blank">
                                <img src="<?= $url ?>" alt="<?= $nombre ?>"
                                    class="w-full h-48 object-cover rounded mb-2 hover:opacity-90 transition">
                            </a>
                        <?php elseif (in_array($ext, ['pdf','mp4','txt'])): ?>
                            <a href="<?= $url ?>" target="_blank">
                                <iframe src="<?= $url ?>" class="w-full h-48 rounded mb-2 border" frameborder="0"></iframe>
                            </a>
                        <?php else: ?>
                            <div class="flex items-center justify-center h-48 bg-gray-100 text-gray-700 rounded mb-2">
                                <span class="text-sm font-semibold">📁 <?= $nombre ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="flex justify-between items-center mt-2">
                            <a href="<?= $url ?>" target="_blank" class="text-sm text-blue-600 hover:underline">🔗 Ver</a>
                            <a href="<?= BASE_URL ?>index.php?url=Filescontroller/downloadFile&file=<?= $nombre?>"
                                class="text-sm text-green-600 hover:underline">⬇️ Descargar</a>
                        </div>
                        <form action="<?= BASE_URL ?>index.php?url=FilesController/updateestado" method="post" >
                         <div class="flex items-center me-4 pt-2">
                                    <input id="purple-radio" type="radio" value="7" name="estado"
                                        class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 dark:focus:ring-purple-600"
                                        <?php if ($archivo->getCod_estado() == 7) echo 'checked'; ?>>
                                    <label for="purple-radio" class="ms-2 text-sm font-medium text-gray-500">Disponible</label>

                                </div>

                                <div class="flex items-center me-4 pt-2 pb-5">
                                    <input id="purple-radio" type="radio" value="8" name="estado"
                                        class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 dark:focus:ring-purple-600 "
                                        <?php if ($archivo->getCod_estado() == 8) echo 'checked'; ?>>
                                    <label for="purple-radio" class="ms-2 text-sm font-medium text-gray-500">No
                                        Disponible</label>

                        </div>  
                                
                        <!-- Datos opcionales de BD -->
                        <div class="mt-2 text-xs text-gray-500">
                            Área: <?= $archivoDAO->obtenerarea($archivo->getCod_area()) ?><br>
                            Profesor: <?= $archivoDAO->obtenerprofesor($archivo->getCod_profesor()) ?><br>
                            Materia: <?= $archivoDAO->obtenermateria($archivo->getId_materia()) ?>
                        </div>
                        
                        <button
                                    class="bg-[#5D54A4] hover:bg-[#4A4192] text-gray-50 font-semibold py-2 px-6 rounded-full shadow-md transform hover:scale-105 transition ease-in-out duration-300"
                                    type="submit">
                                    Guardar Cambios
                        </button>
                        <input name="id" type="hidden" value="<?= $archivo->getId() ?>">
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <script src="<?= BASE_URL ?>public/js/filterfiles.js"></script>
    <script src="<?= BASE_URL ?>public/js/notyf.js"></script>
    <?php
    if (isset($_GET['error'])) {
        $Messages = [
            1 => 'Error al descargar el archivo',

        ];
        $msg = $Messages[$_GET['error']] ?? $Messages[1]; ?>
        <script>
            showErrorRegister(`<?= $msg ?>`, {
                x: 'right',
                y: 'top'
            });
        </script>
    <?php } ?>
    
    <?php
    if (isset($_GET['success'])) {
        $Messages = [
            1 => 'El archivo se ha cambiado de estado con exito',

        ];
        $msg = $Messages[$_GET['success']] ?? $Messages[1];
    ?>
        <script>
            showSuccessPosition(`<?= $msg ?>`, {
                x: 'right',
                y: 'top'
            });
        </script>
    <?php } elseif (isset($_GET['error'])) {
        $Messages = [
            1 => 'Error al modificar el archivo',

        ];
        $msg = $Messages[$_GET['error']] ?? $Messages[1]; ?>
        <script>
            showErrorRegister(`<?= $msg ?>`, {
                x: 'right',
                y: 'top'
            });
        </script>
    <?php } ?>
</body>

</html>