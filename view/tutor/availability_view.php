<?php
require_once(__DIR__ . '/../../app/controllers/models/DTO/TutorDTO.php');
require_once(__DIR__ . '/../../app/controllers/models/DTO/DisponibilidadDTO.php');
require_once __DIR__ . '/../layouts/nav.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Disponibilidad - Tutor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- notyf vía CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <style>
        .availability-card {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .table-responsive {
            overflow-x: auto;
        }
        .day-name {
            min-width: 120px;
        }
        .status-badge {
            padding: 0.35rem 0.65rem;
            border-radius: 50rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .btn-add {
            background-color: #5D54A4;
            transition: all 0.3s ease;
        }
        .btn-add:hover {
            background-color: #4A4192;
            transform: translateY(-2px);
        }
    </style>
</head>

<body style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover; background-attachment: fixed;"
    class="bg-gray-100 bg-cover bg-fixed bg-no-repeat min-h-screen">

    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white">Mi Disponibilidad</h1>
                <p class="text-white opacity-90">Revisa y gestiona tus horarios disponibles para tutorías</p>
            </div>
            <a href="<?= BASE_URL ?>index.php?url=RouteController/registerAvailability" 
               class="btn-add text-white px-6 py-2 rounded-full shadow-md flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>Agregar Horario</span>
            </a>
        </div>

        <!-- Notificación -->
        <?php if (isset($_GET['success'])): ?>
        <div id="notification" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p>
                        <?php 
                        $messages = [
                            1 => 'Disponibilidad registrada exitosamente!',
                            2 => 'Disponibilidad actualizada correctamente',
                            3 => 'Horario eliminado con éxito'
                        ];
                        echo $messages[$_GET['success']] ?? 'Operación realizada con éxito';
                        ?>
                    </p>
                </div>
                <button onclick="document.getElementById('notification').remove()" class="text-green-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <?php endif; ?>

        <!-- Tabla de disponibilidad -->
        <div class="availability-card overflow-hidden">
            <?php if (empty($disponibilidad)): ?>
                <div class="text-center p-12">
                    <div class="inline-block p-4 bg-purple-50 rounded-full mb-4">
                        <i class="fas fa-calendar-times text-purple-500 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay disponibilidad registrada</h3>
                    <p class="text-gray-500 mb-4">Aún no has registrado horarios disponibles para tutorías</p>
                    <a href="<?= BASE_URL ?>index.php?url=RouteController/registerAvailability" 
                       class="btn-add inline-block text-white px-6 py-2 rounded-full shadow-md">
                        Registrar mi primer horario
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-purple-600 text-white">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Día
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Horario
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Estado
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($disponibilidad as $disp): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap day-name">
                                    <div class="text-sm text-gray-900 font-semibold">
                                        <?= $disp['dia'] ?? 'No especificado' ?>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <?= substr($disp['hora_i'], 0, 5) ?> - <?= substr($disp['hora_fn'], 0, 5) ?>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="status-badge bg-<?= $disp['estado'] == 'Disponible' ? 'green' : 'gray' ?>-100 text-<?= $disp['estado'] == 'Disponible' ? 'green' : 'gray' ?>-800">
                                        <?= $disp['estado'] ?>
                                    </span>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex flex-col md:flex-row gap-2 justify-end">
                                        <a href="#" class="text-purple-600 hover:text-purple-900">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <a href="#" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Nota informativa -->
        <div class="mt-6 p-4 bg-white bg-opacity-80 rounded-lg border border-purple-200">
            <div class="flex items-start">
                <div class="flex-shrink-0 pt-1">
                    <i class="fas fa-info-circle text-purple-500"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-purple-800">Información importante</h3>
                    <div class="mt-1 text-sm text-purple-700">
                        <p>• Los horarios se muestran en bloques de 1 hora según lo registrado.</p>
                        <p>• Puedes editar o eliminar tu disponibilidad en cualquier momento.</p>
                        <p>• Los estudiantes podrán agendar tutorías en tus horarios marcados como "Disponible".</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para notificaciones -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar notificación de éxito si existe
        <?php if (isset($_GET['success'])): ?>
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
            
            notyf.success('<?= 
                isset($messages) ? $messages[$_GET['success']] : "Operación realizada con éxito" 
            ?>');
        <?php endif; ?>
        
        // Confirmación para eliminar
        document.querySelectorAll('a[href*="eliminar"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('¿Estás seguro de que deseas eliminar este horario?')) {
                    // Aquí iría la llamada AJAX o redirección para eliminar
                    window.location.href = '<?= BASE_URL ?>index.php?url=TutorController/deleteAvailability&id=' + 
                                          this.closest('tr').dataset.id;
                }
            });
        });
    });
    </script>
</body>
</html>