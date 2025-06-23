<?php
require_once __DIR__ . '/../app/controllers/models/DTO/S3DTO.php';
require_once __DIR__ . '/../app/controllers/models/DTO/ArchivoDTO.php';
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
        <h1 class="text-3xl font-bold mb-6 text-center text-white pt-8">📂 Archivos Subidos al Repositorio de cloUD</h1>

        <?php if (!empty($error)): ?>
            <p class="text-red-600 text-center">❌ <?= $error ?></p>
        <?php elseif (empty($archivos)): ?>
            <p class="text-center text-gray-300">No hay archivos subidos aún.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <?php foreach ($archivos as $archivo): ?>
                    <?php
                        $ext = $archivo->getId_tipo();
                        $url = $archivo->getRuta();
                        $nombre = $archivo->getNombre();
                    ?>
                    <div class="bg-white text-black p-4 rounded-lg shadow-md hover:shadow-lg transition">
                        <?php if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                            <a href="<?= $url ?>" target="_blank">
                                <img src="<?= $url ?>" alt="<?= $nombre ?>" class="w-full h-48 object-cover rounded mb-2 hover:opacity-90 transition">
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
                            <a href="descargar.php?file=<?= urlencode($nombre) ?>" class="text-sm text-green-600 hover:underline">⬇️ Descargar</a>
                        </div>

                        <!-- Datos opcionales de BD -->
                        <div class="mt-2 text-xs text-gray-500">
                            Área: <?= $archivo->getCod_area() ?><br>
                            Profesor: <?= $archivo->getCod_profesor() ?><br>
                            Materia: <?= $archivo->getId_materia() ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
