<?php require_once __DIR__ . '/layouts/nav.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Soporte al Usuario - cloUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100" style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover;">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-white text-center mb-8">Centro de Soporte</h1>

        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">¿Necesitas ayuda?</h2>
            <p class="text-gray-700 mb-4">
                Si tienes problemas con la plataforma o necesitas asistencia, revisa la sección de instrucciones o comunícate con un administrador.
            </p>
        </div>

        <div id="instrucciones" class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Instrucciones de Soporte</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>Verifica que tu conexión a Internet esté activa.</li>
                <li>Revisa si el problema persiste desde otro navegador.</li>
                <li>Contacta al soporte si el error continúa.</li>
                <li>Usa un lenguaje claro al describir el problema.</li>
            </ul>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Contactanos</h2>
    <p class="text-gray-700 mb-2">
        Si tienes problemas adicionales o necesitas asistencia, puedes contactar a <span class="font-semibold"><?= $adminNombre ?></span> al siguiente correo:
    </p>
    <a class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition"<?= $adminCorreo ?>">
        <?= $adminCorreo ?>
    </a>
</div>
    </div>
</body>
</html>
