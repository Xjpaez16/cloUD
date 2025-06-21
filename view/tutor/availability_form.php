<?php
require_once(__DIR__ . '/../../app/controllers/models/DTO/TutorDTO.php');
require_once(__DIR__ . '/../../app/controllers/models/DTO/DiaDTO.php');
require_once __DIR__ . '/../layouts/nav.php'; 
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Disponibilidad - Tutor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- notyf vía CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <!-- Flatpickr para mejor selección de tiempo -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
</head>

<body style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover;"
    class="bg-gray-100 bg-cover bg-bottom bg-no-repeat">

    
    <div class="flex flex-col min-h-screen w-auto">
        <div class="flex-grow flex-col flex items-center justify-center px-4 mt-20 xl:mr-0 mr-48 w-full">
            <!-- Encabezado morado -->
            <div class="bg-[#604c9c] rounded-t-3xl shadow-md p-10 xl:w-full xl:max-w-xl transform hover:shadow-2xl transition ease-in-out duration-500 mb-0">
                <h1 class="text-3xl text-white font-sans font-bold text-center">Registrar Mi Disponibilidad</h1>
                <p class="text-white text-center mt-2">Selecciona el día y horario en que estarás disponible para tutorías</p>
            </div>
            
            <!-- Formulario blanco -->
            <div class="bg-gray-50 rounded-b-3xl shadow-md p-10 w-full max-w-xl transform hover:shadow-2xl transition ease-in-out duration-500 mt-0">
                <form id="availabilityForm" action="<?= BASE_URL ?>index.php?url=RouteController/processAvailability" method="POST">
                    <!-- Selección de día -->
                    <div class="mb-5">
                        <label for="dia" class="block font-semibold text-[#5D54A4]">Día de la semana</label>
                        <select id="dia" name="dia" required
                            class="w-full px-4 py-2 mt-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#5D54A4]">
                            <option value="">Seleccione un día</option>
                            <?php foreach ($dias as $dia): ?>
                                <option value="<?= $dia->getId() ?>"><?= $dia->getDia() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Duración de la disponibilidad -->
                    <div class="mb-5">
                        <label for="semanas" class="block font-semibold text-[#5D54A4]">¿Para cuántas semanas?</label>
                        <select id="semanas" name="semanas" required
                            class="w-full px-4 py-2 mt-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#5D54A4]">
                            <option value="1">1 semana</option>
                            <option value="2" selected>2 semanas</option>
                            <option value="3">3 semanas</option>
                            <option value="4">4 semanas</option>
                        </select>
                    </div>

                    <!-- Horario -->
                    <div class="mb-5">
                        <label class="block font-semibold text-[#5D54A4]">Horario disponible</label>
                        <p class="text-sm text-gray-500 mt-1">Selecciona un intervalo de al menos 1 hora</p>
                        
                        <div class="flex items-center gap-4 mt-2">
                            <input type="time" id="hora_inicio" name="hora_inicio" required
                                class="w-full px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#5D54A4]">
                            <span class="text-[#5D54A4] font-bold">a</span>
                            <input type="time" id="hora_fin" name="hora_fin" required
                                class="w-full px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#5D54A4]">
                        </div>
                        <div id="timeError" class="text-red-500 text-sm mt-1 hidden">El intervalo debe ser de al menos 1 hora</div>
                    </div>

                    <!-- Vista previa de bloques -->
                    <div class="mb-5 hidden" id="previewSection">
                        <label class="block font-semibold text-[#5D54A4]">Bloques de 1 hora que se crearán:</label>
                        <div class="mt-2 p-3 bg-gray-100 rounded-lg" id="timeBlocksPreview">
                            <!-- Aquí se mostrarán los bloques -->
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex items-center justify-between mt-8">
                        <button type="submit" id="submitBtn"
                            class="bg-[#5D54A4] hover:bg-[#4A4192] text-gray-50 font-semibold py-2 px-6 rounded-full shadow-md transform hover:scale-105 transition ease-in-out duration-300">
                            Guardar Disponibilidad
                        </button>
                        <a href="<?= BASE_URL ?>index.php?url=RouteController/tutor" class="text-[#5D54A4] font-semibold hover:text-[#4A4192]">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- FAQ opcional -->
        <div class="p-5 text-gray-50 font-semibold text-right">
            <a href="#" class="hover:underline">Preguntas frecuentes</a>
        </div>
    </div>

    <!-- Notificaciones -->
    <script src="<?= BASE_URL ?>public/js/notyf.js"></script>
    
    <!-- Script para manejo del formulario -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const horaInicio = document.getElementById('hora_inicio');
        const horaFin = document.getElementById('hora_fin');
        const timeError = document.getElementById('timeError');
        const previewSection = document.getElementById('previewSection');
        const timeBlocksPreview = document.getElementById('timeBlocksPreview');
        const submitBtn = document.getElementById('submitBtn');
        const diaSelect = document.getElementById('dia');
        
        // Configuración de flatpickr para los inputs de tiempo
        flatpickr(horaInicio, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            minuteIncrement: 30,
            locale: "es"
        });
        
        flatpickr(horaFin, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            minuteIncrement: 30,
            locale: "es"
        });
        
        // Función para validar los tiempos
        function validateTimes() {
            if (horaInicio.value && horaFin.value) {
                const inicio = new Date(`2000-01-01T${horaInicio.value}`);
                const fin = new Date(`2000-01-01T${horaFin.value}`);
                const diff = (fin - inicio) / (1000 * 60 * 60); // Diferencia en horas
                
                if (diff < 1) {
                    timeError.classList.remove('hidden');
                    submitBtn.disabled = true;
                    previewSection.classList.add('hidden');
                    return false;
                } else {
                    timeError.classList.add('hidden');
                    submitBtn.disabled = false;
                    updateTimeBlocksPreview();
                    return true;
                }
            }
            return false;
        }
        
        // Función para actualizar la vista previa de bloques
        function updateTimeBlocksPreview() {
            if (!horaInicio.value || !horaFin.value || !validateTimes()) {
                previewSection.classList.add('hidden');
                return;
            }
            
            const inicio = new Date(`2000-01-01T${horaInicio.value}`);
            const fin = new Date(`2000-01-01T${horaFin.value}`);
            let current = new Date(inicio);
            let blocks = [];
            
            while (current < fin) {
                const blockStart = new Date(current);
                const blockEnd = new Date(current);
                blockEnd.setHours(blockEnd.getHours() + 1);
                
                if (blockEnd > fin) {
                    blockEnd = new Date(fin);
                }
                
                blocks.push({
                    start: blockStart.toTimeString().substring(0, 5),
                    end: blockEnd.toTimeString().substring(0, 5)
                });
                
                current = new Date(blockEnd);
            }
            
            // Mostrar los bloques en la vista previa
            if (blocks.length > 0) {
                timeBlocksPreview.innerHTML = '';
                blocks.forEach(block => {
                    const blockElement = document.createElement('div');
                    blockElement.className = 'py-1 flex justify-between';
                    blockElement.innerHTML = `
                        <span>${block.start} - ${block.end}</span>
                        <span class="text-green-600">✔</span>
                    `;
                    timeBlocksPreview.appendChild(blockElement);
                });
                
                previewSection.classList.remove('hidden');
            } else {
                previewSection.classList.add('hidden');
            }
        }
        
        // Event listeners
        horaInicio.addEventListener('change', validateTimes);
        horaFin.addEventListener('change', validateTimes);
        diaSelect.addEventListener('change', function() {
            if (horaInicio.value && horaFin.value) {
                updateTimeBlocksPreview();
            }
        });
        
        // Mostrar notificaciones según parámetros de URL
        <?php if (isset($_GET['error'])): 
            $errorMessages = [
                1 => 'El intervalo de tiempo debe ser de al menos 1 hora',
                2 => 'Error al registrar la disponibilidad',
                3 => 'Todos los campos son requeridos',
                4 => 'El horario seleccionado entra en conflicto con otra disponibilidad'
            ];
            $msg = $errorMessages[$_GET['error']] ?? 'Error desconocido';
        ?>
            showError('<?= $msg ?>');
        <?php elseif(isset($_GET['success'])): 
            $successMessages = [
                1 => 'Disponibilidad registrada exitosamente',
                2 => 'Disponibilidad actualizada correctamente'
            ];
            $msg = $successMessages[$_GET['success']] ?? 'Operación exitosa';
        ?>
            showSuccess('<?= $msg ?>');
        <?php endif; ?>
    });
    
    // Funciones de notificación
    function showError(message) {
        const notyf = new Notyf({
            position: { x: 'right', y: 'top' },
            types: [
                {
                    type: 'error',
                    background: '#ef4444',
                    icon: {
                        className: 'fas fa-times-circle',
                        tagName: 'span',
                        color: '#fff'
                    },
                    dismissible: true
                }
            ]
        });
        
        notyf.error(message);
    }
    
    function showSuccess(message) {
        const notyf = new Notyf({
            position: { x: 'right', y: 'top' },
            types: [
                {
                    type: 'success',
                    background: '#10b981',
                    icon: {
                        className: 'fas fa-check-circle',
                        tagName: 'span',
                        color: '#fff'
                    },
                    dismissible: true
                }
            ]
        });
        
        notyf.success(message);
    }
    </script>
</body>
</html>