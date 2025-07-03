<?php 
require_once __DIR__ . '/../layouts/nav.php'; 
require_once __DIR__ . '/../../app/controllers/models/DTO/HorarioDTO.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Tutoría | cloUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
</head>

<body class="bg-gray-100" style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover;">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Tarjeta del tutor -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                <div class="bg-purple-600 px-6 py-4">
                    <h1 class="text-xl font-bold text-white">Solicitar Tutoría con <?= htmlspecialchars($tutor->getNombre()) ?></h1>
                </div>
                
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center">
                                <i class="fas fa-user-graduate text-purple-600 text-xl"></i>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($tutor->getNombre()) ?></h3>
                            <p class="text-gray-600"><?= htmlspecialchars($tutor->getCorreo()) ?></p>
                        </div>
                    </div>

                    <!-- Calificación - Versión corregida -->
                    <div class="mb-4">
                        <span class="text-gray-700 font-medium">Calificación:</span>
                        <div class="flex items-center mt-1">
                            <?php
                                // Asegurarnos de que la calificación es numérica
                                $rating = is_numeric($tutor->getCalificacion_general()) ? 
                                          (int) floor((float)$tutor->getCalificacion_general()) : 
                                          0;
                                          
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $rating) {
                                        echo '<i class="fas fa-star text-yellow-400"></i>';
                                    } else {
                                        echo '<i class="far fa-star text-yellow-400"></i>';
                                    }
                                }
                            ?>
                            <span class="ml-2 text-gray-600">(<?= $rating ?>/5)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario de solicitud -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-purple-600 px-6 py-4">
                    <h2 class="text-lg font-bold text-white">Detalles de la Tutoría</h2>
                </div>
                
                <form action="<?= BASE_URL ?>index.php?url=RouteController/processRequest" method="POST" class="p-6">
                    <input type="hidden" name="tutor_id" value="<?= $tutor->getCodigo() ?>">

                    <!-- Fecha -->
                    <div class="mb-4">
                        <label for="fecha" class="block text-gray-700 font-medium mb-2">
                            <i class="fas fa-calendar-day text-purple-500 mr-2"></i>Fecha
                        </label>
                        <input type="date" id="fecha" name="fecha" data-diapermitido="<?= $horario->getId_dia()?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                               min="<?= date('Y-m-d') ?>" required>
                    </div>
                    

                    <!-- Horario -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="hora_inicio" class="block text-gray-700 font-medium mb-2">
                                <i class="fas fa-clock text-purple-500 mr-2"></i>Hora inicio
                            </label>
                            <input type="time" step="3600" id="hora_inicio" name="hora_inicio" data-horamin="<?= $horario->getHora_inicio()?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                   required>
                        </div>
                        <div>
                            <label for="hora_fin" class="block text-gray-700 font-medium mb-2">
                                <i class="fas fa-clock text-purple-500 mr-2"></i>Hora fin
                            </label>
                            <input type="time" step="3600"  id="hora_fin" name="hora_fin" data-horafin="<?= $horario->getHora_fin()?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                   required>
                        </div>
                    </div>
                    <!-- Botones -->
                    <div class="flex justify-end space-x-4">
                        <a href="<?= BASE_URL ?>index.php?url=RouteController/showTutorSearch" 
                           class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition-colors font-medium">
                            <i class="fas fa-arrow-left mr-2"></i>Cancelar
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium">
                            <i class="fas fa-calendar-check mr-2"></i>Solicitar Tutoría
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para mejorar la experiencia de usuario -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Establecer hora fin automáticamente (1 hora después de la hora inicio)
            const horaInicio = document.getElementById('hora_inicio');
            const horaFin = document.getElementById('hora_fin');
            
            horaInicio.addEventListener('change', function() {
                if (horaInicio.value) {
                    const [hours, minutes] = horaInicio.value.split(':');
                    const endTime = new Date();
                    endTime.setHours(parseInt(hours) + 1);
                    endTime.setMinutes(minutes);
                    
                    const endHours = endTime.getHours().toString().padStart(2, '0');
                    const endMinutes = endTime.getMinutes().toString().padStart(2, '0');
                    
                    horaFin.value = `${endHours}:${endMinutes}`;
                }
            });
        });
    </script>
    <script src="<?= BASE_URL ?>public/js/validar-fecha.js"></script>
    <script src="<?= BASE_URL ?>public/js/validar-hora.js"></script>
</body>
</html>