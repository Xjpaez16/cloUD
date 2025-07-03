<?php
require_once __DIR__ . '/../layouts/nav.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Disponibilidad - Tutor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover; background-attachment: fixed;"
    class="bg-gray-100 bg-cover bg-fixed bg-no-repeat min-h-screen">

<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white bg-opacity-90 rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-edit text-purple-500 mr-2"></i>
                Editar Disponibilidad
            </h2>
            <a href="<?= BASE_URL ?>index.php?url=RouteController/viewAvailability" 
               class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </a>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <p>Error al procesar la solicitud. Por favor, inténtalo de nuevo.</p>
                </div>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?= BASE_URL ?>index.php?url=RouteController/updateAvailability">

            <!-- Campos ocultos requeridos para la actualización -->
            <input type="hidden" name="id_horario" value="<?= $disponibilidad['id_horario'] ?>">
            <input type="hidden" name="cod_tutor" value="<?= $disponibilidad['cod_tutor'] ?>">
            <input type="hidden" name="hora_i" value="<?= $disponibilidad['hora_inicio'] ?>">
            <input type="hidden" name="hora_fn" value="<?= $disponibilidad['hora_fin'] ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                
                <div>
                    <label for="dia" class="block text-sm font-medium text-gray-700 mb-1">Día</label>
<select id="dia" name="dia" required
    class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
    <?php foreach ($dias as $dia): ?>
        <option value="<?= $dia->getId() ?>" <?= $dia->getId() == $disponibilidad['id_dia'] ? 'selected' : '' ?>>
            <?= $dia->getDia() ?>
        </option>
    <?php endforeach; ?>
</select>

                </div>

                <div>
                    <label for="hora_inicio" class="block text-sm font-medium text-gray-700 mb-1">Hora de Inicio</label>
                    <input type="time" id="hora_inicio" name="hora_inicio" required
                           value="<?= substr($disponibilidad['hora_inicio'], 0, 5) ?>"
                           class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                </div>

                <div>
                    <label for="hora_fin" class="block text-sm font-medium text-gray-700 mb-1">Hora de Fin</label>
                    <input type="time" id="hora_fin" name="hora_fin" required
                           value="<?= substr($disponibilidad['hora_fin'], 0, 5) ?>"
                           class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                </div>

            </div>

            <div class="flex justify-end space-x-3 mt-8">
                <a href="<?= BASE_URL ?>index.php?url=RouteController/viewAvailability" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    Guardar Cambios
                </button>
            </div>
        </form>

    </div>
</div>
</body>
</html>
