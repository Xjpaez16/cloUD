<?php require_once __DIR__ . '/layouts/nav.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Preguntas Frecuentes - cloUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100" style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover;">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-white text-center mb-8">Preguntas Frecuentes (FAQ)</h1>

        <!-- Registro -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">¿Cómo me registro?</h2>
            <p class="text-gray-700 mb-2">
                Debes ir a la parte superior derecha y seleccionar el logo: <img src="<?= BASE_URL ?>public/img/login.png" alt="Login" class="h-20 w-auto">
                
            </p>
            <p class="text-gray-700 mb-2">
                Debes seleccionar el rol con el cual deseas asociar tu cuenta: <span class="font-semibold">Tutor</span> o <span class="font-semibold">Estudiante</span> (Puedes tener ambos roles).
            </p>
            <p class="text-gray-700">
                Debes tener un correo institucional con extensión <span class="font-mono">@udistrital.edu.co</span> y una contraseña que contenga: mayúsculas, números y caracteres especiales.
            </p>
        </div>
		
        <!-- Editar perfil -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">¿Cómo edito mi perfil?</h2>
            <p class="text-gray-700">
                Ve a "Editar Perfil" desde el panel de <span class="font-semibold">Tutor</span> o <span class="font-semibold">Estudiante</span> y modifica tus datos. 
                Si deseas cambiar tu contraseña se te solicitarán los datos de seguridad que digitaste al momento de registrarte.
            </p>
        </div>

        <!-- FAQ Tutor -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">FAQ para Tutor</h2>

            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">¿Cómo digito mi disponibilidad?</h3>
                <p class="text-gray-700">
                    Ve a tu panel de Tutor y selecciona "Disponibilidad". Ahí podrás ver una tabla con tu disponibilidad.
                    Si aún no tienes ninguna, aparecerá un botón <span class="font-semibold">"Agregar Horario"</span> donde podrás registrar por día los bloques disponibles de manera general durante tu semestre académico.
                </p>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">¿Cómo veo las tutorías pendientes?</h3>
                <p class="text-gray-700">
                    Dirígete al panel de Tutor y ve a "Mis Tutorías". Ahí podrás ver todas tus tutorías pendientes con toda la información relacionada como horario, tema, etc.
                </p>
            </div>
        </div>

        <!-- FAQ Estudiante -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">FAQ para Estudiante</h2>

            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">¿Cómo veo los tutores disponibles?</h3>
                <p class="text-gray-700">
                    Desde tu panel, ve a "Buscar Tutorías" y verás todos los tutores disponibles junto a su información.
                    También podrás solicitar tutorías desde esa misma vista.
                </p>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">¿Cómo veo mis tutorías pendientes?</h3>
                <p class="text-gray-700">
                    Desde tu panel, selecciona "Mis Tutorías" y verás el historial de tus tutorías pendientes con toda la información correspondiente.
                </p>
            </div>
        </div>

        <!-- Contacto -->
        <div class="bg-white rounded-lg shadow-lg p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">¿Necesitas más ayuda?</h2>
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
