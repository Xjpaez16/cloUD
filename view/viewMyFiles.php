<?php
require_once __DIR__ . '/../app/controllers/models/DTO/S3DTO.php';
require_once __DIR__ . '/../app/controllers/models/DTO/ArchivoDTO.php';
require_once __DIR__ . '/../app/controllers/models/DAO/ArchivoDAO.php';

require_once __DIR__ . '/layouts/nav.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Archivos Subidos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative min-h-screen bg-cover bg-bottom bg-no-repeat text-white font-sans"
    style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg');">

    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-center text-white pt-8 pb-8"> Mis archivos 📂</h1>
        <div class="flex flex-col items-center justify-center text-black pt-10">

            <?php ini_set('display_errors', 1);
            error_reporting(E_ALL);
            require_once(__DIR__ . '/../app/controllers/models/DTO/EstudianteDTO.php');
            require_once(__DIR__ . '/../app/controllers/models/DTO/TutorDTO.php');
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $role = isset($_SESSION["rol"]) ? $_SESSION["rol"] : null;
            $usuario = isset($_SESSION["usuario"]) ? $_SESSION["usuario"] : null;

            if ($role == "estudiante") {
            ?>

        </div>
        <?php if (!empty($error)): ?>
            <p class="text-red-600 text-center">❌ <?= $error ?></p>
        <?php elseif (empty($archivosest)): ?>
            <p class="text-center text-gray-300 pt-8 font-sans font-bold">No hay archivos subidos aún.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 pt-8">
                <?php foreach ($archivosest as $archivo): ?>
                    <?php
                        $ext = strtolower($archivoDAO->obtenertipo($archivo->getId_tipo()));
                        error_log("extension : " . $ext);
                        $archivo->getId_tipo();
                        $url = $archivo->getRuta();
                        $nombre = basename($url);

                    ?>
                    <div class="bg-white text-black p-4 rounded-lg shadow-md hover:shadow-lg transition archivo">

                        <?php if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])): ?>

                            <a href="<?= $url ?>" target="_blank">
                                <img src="<?= $url ?>" alt="<?= $nombre ?>"
                                    class="w-full h-48 object-cover rounded mb-2 hover:opacity-90 transition">
                            </a>
                        <?php elseif ($ext === 'pdf'): ?>
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
                            <a href="descargar.php?file=<?= urlencode($nombre) ?>"
                                class="text-sm text-green-600 hover:underline">⬇️ Descargar</a>
                        </div>

                        <!-- Datos opcionales de BD -->
                        <div class="mt-2 text-xs text-gray-500">
                            <form action="<?= BASE_URL ?>index.php?url=FilesController/updatefile" method="post">

                                <label for="Profesor" class="block font-semibold text-[#5D54A4]">Profesor : </label>
                                <select name="profesor" id="profesor"
                                    class="w-full px-4 py-2 mt-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#5D54A4]"
                                    required>
                                    <?php /** @var ProfesorDTO $profesor */
                                    ?>
                                    <?php foreach ($profesores as $profesor): ?>
                                        <option value="<?= $profesor->getCod() ?>"
                                            <?= $archivo->getCod_profesor() == $profesor->getCod() ? 'selected' : '' ?>>
                                            <?= $profesor->getNom() ?>
                                        </option>

                                    <?php endforeach; ?>
                                </select>
                                <label for="Areas" class="block font-semibold text-[#5D54A4]">Areas : </label>
                                <select name="area" id="area"
                                    class="w-full px-4 py-2 mt-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#5D54A4]"
                                    required>
                                    <?php /** @var AreaDTO $area */
                                    ?>
                                    <?php foreach ($areas as $area): ?>
                                        <option value="<?= $area->getCodigo() ?>"
                                            <?= $archivo->getCod_area() == $area->getCodigo() ? 'selected' : '' ?>>
                                            <?= $area->getNombre() ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <br>
                                <label for="Materias" class="block font-semibold text-[#5D54A4]">Materia : </label>
                                <select name="materia" id="materia"
                                    class="w-full px-4 py-2 mt-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#5D54A4]"
                                    required>
                                    <?php /** @var MateriaDTO $materia */
                                    ?>
                                    <?php foreach ($materias as $materia): ?>
                                        <option value="<?= $materia->getId() ?>"
                                            <?= $archivo->getId_materia() == $materia->getId() ? 'selected' : '' ?>>
                                            <?= $materia->getNom_materia() ?>
                                        </option>

                                    <?php endforeach; ?>
                                </select>

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
                                <button
                                    class="bg-[#5D54A4] hover:bg-[#4A4192] text-gray-50 font-semibold py-2 px-6 rounded-full shadow-md transform hover:scale-105 transition ease-in-out duration-300"
                                    type="submit">
                                    Guardar Cambios
                                </button>
                                <input name="id" type="hidden" value="<?= $archivo->getId() ?>">
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php } elseif ($role == "tutor") { ?>
        <?php if (!empty($error)): ?>
            <p class="text-red-600 text-center">❌ <?= $error ?></p>
        <?php elseif (empty($archivosest)): ?>
            <p class="text-center text-gray-300 pt-8 font-sans font-bold">No hay archivos subidos aún.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 pt-8">
                <?php foreach ($archivosest as $archivo): ?>
                    <?php
                        $ext = strtolower($archivoDAO->obtenertipo($archivo->getId_tipo()));
                        error_log("extension : " . $ext);
                        $archivo->getId_tipo();
                        $url = $archivo->getRuta();
                        $nombre = basename($url);

                    ?>
                    <div class="bg-white text-black p-4 rounded-lg shadow-md hover:shadow-lg transition archivo">

                        <?php if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])): ?>

                            <a href="<?= $url ?>" target="_blank">
                                <img src="<?= $url ?>" alt="<?= $nombre ?>"
                                    class="w-full h-48 object-cover rounded mb-2 hover:opacity-90 transition">
                            </a>
                        <?php elseif ($ext === 'pdf'): ?>
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
                            <a href="descargar.php?file=<?= urlencode($nombre) ?>"
                                class="text-sm text-green-600 hover:underline">⬇️ Descargar</a>
                        </div>

                        <!-- Datos opcionales de BD -->
                        <div class="mt-2 text-xs text-gray-500">
                            <form action="<?= BASE_URL ?>index.php?url=FilesController/updatefile" method="post">

                                <label for="Profesor" class="block font-semibold text-[#5D54A4]">Profesor : </label>
                                <select name="profesor" id="profesor"
                                    class="w-full px-4 py-2 mt-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#5D54A4]"
                                    required>
                                    <?php /** @var ProfesorDTO $profesor */
                                    ?>
                                    <?php foreach ($profesores as $profesor): ?>
                                        <option value="<?= $profesor->getCod() ?>"
                                            <?= $archivo->getCod_profesor() == $profesor->getCod() ? 'selected' : '' ?>>
                                            <?= $profesor->getNom() ?>
                                        </option>

                                    <?php endforeach; ?>
                                </select>
                                <label for="Areas" class="block font-semibold text-[#5D54A4]">Areas : </label>
                                <select name="area" id="area"
                                    class="w-full px-4 py-2 mt-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#5D54A4]"
                                    required>
                                    <?php /** @var AreaDTO $area */
                                    ?>
                                    <?php foreach ($areas as $area): ?>
                                        <option value="<?= $area->getCodigo() ?>"
                                            <?= $archivo->getCod_area() == $area->getCodigo() ? 'selected' : '' ?>>
                                            <?= $area->getNombre() ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <br>
                                <label for="Materias" class="block font-semibold text-[#5D54A4]">Materia : </label>
                                <select name="materia" id="materia"
                                    class="w-full px-4 py-2 mt-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#5D54A4]"
                                    required>
                                    <?php /** @var MateriaDTO $materia */
                                    ?>
                                    <?php foreach ($materias as $materia): ?>
                                        <option value="<?= $materia->getId() ?>"
                                            <?= $archivo->getId_materia() == $materia->getId() ? 'selected' : '' ?>>
                                            <?= $materia->getNom_materia() ?>
                                        </option>

                                    <?php endforeach; ?>
                                </select>

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
                                <button
                                    class="bg-[#5D54A4] hover:bg-[#4A4192] text-gray-50 font-semibold py-2 px-6 rounded-full shadow-md transform hover:scale-105 transition ease-in-out duration-300"
                                    type="submit">
                                    Guardar Cambios
                                </button>
                                <input name="id" type="hidden" value="<?= $archivo->getId() ?>">
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php } ?>
    </div>
    <script src="<?= BASE_URL ?>public/js/notyf.js"></script>
    <?php
    if (isset($_GET['success'])) {
        $Messages = [
            1 => 'Archivo modificado con éxito',

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