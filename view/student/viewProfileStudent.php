<?php
require_once __DIR__ . '/../layouts/nav.php';

if (!isset($studentProfile)) {
    echo "<p class='text-red-600 text-center mt-6'>Error al cargar el perfil del estudiante.</p>";
    return;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil del Estudiante</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100" style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover; background-position: center;">

    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white bg-opacity-90 rounded-lg shadow-lg p-8 max-w-lg w-full">
            <h2 class="text-3xl font-bold text-purple-800 mb-6 text-center">Perfil del Estudiante</h2>

            <div class="space-y-4">
                <div>
                    <label class="block font-semibold text-gray-700">Código:</label>
                    <p class="text-gray-900 bg-gray-100 px-3 py-2 rounded"><?= htmlspecialchars($studentProfile['codigo']) ?></p>
                </div>

                <div>
                    <label class="block font-semibold text-gray-700">Nombre:</label>
                    <p class="text-gray-900 bg-gray-100 px-3 py-2 rounded"><?= htmlspecialchars($studentProfile['nombre']) ?></p>
                </div>

                <div>
                    <label class="block font-semibold text-gray-700">Correo:</label>
                    <p class="text-gray-900 bg-gray-100 px-3 py-2 rounded"><?= htmlspecialchars($studentProfile['correo']) ?></p>
                </div>

                <div>
                    <label class="block font-semibold text-gray-700">Carrera:</label>
                    <p class="text-gray-900 bg-gray-100 px-3 py-2 rounded"><?= htmlspecialchars($studentProfile['nombre_carrera']) ?></p>
                </div>

                <div>
                    <label class="block font-semibold text-gray-700">Estado:</label>
                    <p class="text-gray-900 bg-gray-100 px-3 py-2 rounded"><?= htmlspecialchars($studentProfile['tipo_estado']) ?></p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
