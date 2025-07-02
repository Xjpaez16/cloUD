<?php if (empty($tutorsAvailable)): ?>
    <div class="bg-white rounded-xl shadow-md p-8 text-center">
        <i class="fas fa-user-graduate text-5xl text-purple-500 mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">No se encontraron tutores</h3>
        <p class="text-gray-600 mb-4">
            <?= (isset($filtros['area']) || isset($filtros['rating']) 
                ? 'No hay tutores disponibles con los filtros actuales.' 
                : 'Actualmente no hay tutores disponibles.' )?>
        </p>
    </div>
<?php else: ?>
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($tutorsAvailable as $tutor): ?>
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <!-- Información del Tutor -->
                    <div class="flex items-start space-x-4 mb-4">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                                <i class="fas fa-user-tie text-xl"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-gray-900 truncate">
                                <?= htmlspecialchars($tutor['nombre'] ?? 'Tutor') ?>
                            </h3>
                            <p class="text-sm text-gray-500 truncate">
                                <?= htmlspecialchars($tutor['correo'] ?? '') ?>
                            </p>
                        </div>
                    </div>

                    <!-- Áreas de Enseñanza -->
                    <?php if (!empty($tutor['areas'])): ?>
                        <div class="mb-3 flex flex-wrap gap-2">
                            <?php foreach (explode(', ', $tutor['areas']) as $area): ?>
                                <span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-0.5 rounded">
                                    <?= htmlspecialchars(trim($area)) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Calificación -->
                    <div class="mb-4 flex items-center">
                        <?php
                            $rating = isset($tutor['calificacion_general']) ? (float)$tutor['calificacion_general'] : 0;
                            for ($i = 1; $i <= 5; $i++) {
                                echo $i <= $rating 
                                    ? '<i class="fas fa-star text-yellow-400"></i>' 
                                    : '<i class="far fa-star text-yellow-400"></i>';
                            }
                        ?>
                        <span class="ml-2 text-sm text-gray-600">
                            <?= $rating > 0 ? number_format($rating, 1) : 'Sin calificaciones' ?>
                        </span>
                    </div>

                    <!-- Horario específico -->
                    <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center text-purple-600 mb-1">
                            <i class="fas fa-calendar-day mr-2"></i>
                            <span class="font-medium"><?= htmlspecialchars($tutor['nombre_dia'] ?? 'Día no especificado') ?></span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-clock mr-2 text-sm"></i>
                            <span><?= htmlspecialchars($tutor['hora_inicio'] ?? '') ?> - <?= htmlspecialchars($tutor['hora_fin'] ?? '') ?></span>
                        </div>
                    </div>

                    <!-- Botón de Solicitud -->
                    <div class="flex justify-end">
                        <a href="<?= BASE_URL ?>index.php?url=RouteController/requestTutorial&tutor_id=<?= $tutor['codigo'] ?>&horario_id=<?= $tutor['id_horario'] ?? '' ?>"
                           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-full text-sm font-semibold transition-colors inline-flex items-center">
                            <i class="fas fa-calendar-check mr-2"></i> Solicitar esta hora
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>