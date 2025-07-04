<?php require_once __DIR__ . '/../layouts/nav.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de Tutoría | cloUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50" class="bg-gray-50" style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover;">
    <div class="container mx-auto px-4 py-8">
        <!-- Mensajes de retroalimentación -->
        <?php if (!empty($_SESSION['error_message'])): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <p><?= htmlspecialchars($_SESSION['error_message']) ?></p>
                <?php unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success_message'])): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                <p><?= htmlspecialchars($_SESSION['success_message']) ?></p>
                <?php unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-white">
                    <i class="fas fa-calendar-check text-purple-500 mr-2 "></i>
                    Solicitudes de Tutoría
                </h1>
                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">
                    <?= is_array($solicitudes) ? count($solicitudes) : 0 ?> pendientes
                </span>
            </div>

            <?php if (empty($solicitudes) || !is_array($solicitudes)): ?>
                <div class="bg-white rounded-xl shadow-md p-8 text-center">
                    <i class="fas fa-calendar-times text-4xl text-gray-300 mb-4"></i>
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">No hay solicitudes pendientes</h2>
                    <p class="text-gray-500">Cuando los estudiantes soliciten tutorías, aparecerán aquí.</p>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horario</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($solicitudes as $solicitud): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-purple-600"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?= htmlspecialchars($solicitud['nombre_estudiante'] ?? 'Nombre no disponible') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?= !empty($solicitud['fecha']) ? date('d/m/Y', strtotime($solicitud['fecha'])) : 'Fecha no disponible' ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?= !empty($solicitud['hora_inicio']) ? date('H:i', strtotime($solicitud['hora_inicio'])) : '--:--' ?> - 
                                            <?= !empty($solicitud['hora_final']) ? date('H:i', strtotime($solicitud['hora_final'])) : '--:--' ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <form action="<?= BASE_URL ?>index.php?url=RouteController/aprobarTutoria" method="POST">
                                                <input type="hidden" name="id_tutoria" value="<?= $solicitud['id'] ?>">
                                                <button type="submit" class="text-green-600 hover:text-green-800 bg-green-50 hover:bg-green-100 px-3 py-1 rounded-md transition-colors">
                                                    <i class="fas fa-check-circle mr-1"></i> Aceptar
                                                </button>
                                            </form>
                                            
                                            <button onclick="openRejectModal(<?= $solicitud['id'] ?? '' ?>)" class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1 rounded-md transition-colors">
                                                <i class="fas fa-times-circle mr-1"></i> Rechazar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal para rechazar -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50  items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Motivo de rechazo</h3>
            
            <form id="rejectForm" action="<?= BASE_URL ?>index.php?url=RouteController/rechazarTutoria" method="POST">
                <input type="hidden" name="id_tutoria" id="modalTutoriaId">
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Selecciona un motivo</label>
                    <select name="motivo" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" required>
                        <option value="">-- Selecciona --</option>
                        <?php if (is_array($motivos)): ?>
                            <?php foreach ($motivos as $motivo): ?>
                                <option value="<?= $motivo->getCodigo() ?>"><?= htmlspecialchars($motivo->getTipo_motivo()) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                        <i class="fas fa-times-circle mr-1"></i> Confirmar Rechazo
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Funciones para manejar el modal
        function openRejectModal(tutoriaId) {
            document.getElementById('modalTutoriaId').value = tutoriaId;
            document.getElementById('rejectModal').classList.remove('hidden');
        }
        
        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('rejectForm').reset();
        }
        
        // Cerrar modal al hacer clic fuera
        window.onclick = function(event) {
            const modal = document.getElementById('rejectModal');
            if (event.target === modal) {
                closeRejectModal();
            }
        }
    </script>
</body>
</html>