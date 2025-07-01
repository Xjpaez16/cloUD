<?php
require_once __DIR__ . '/../layouts/nav.php';

// Debug avanzado
error_log("En vista - Total tutores: " . count($tutorsAvailable));
error_log("Datos en vista: " . print_r($tutorsAvailable, true));

if (!isset($tutorsAvailable)) {
    error_log("Advertencia: tutorsAvailable no está definido");
    $tutorsAvailable = [];
}

// Verificar si es array
if (!is_array($tutorsAvailable)) {
    error_log("Error crítico: tutorsAvailable no es un array");
    $tutorsAvailable = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutorías Disponibles</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100" style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover;">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-white mb-6 text-center">Tutores Disponibles</h1>
        
        <?php if (empty($tutorsAvailable)): ?>
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <p class="text-red-500 font-bold">DEBUG: No se encontraron tutores</p>
                <p class="text-gray-600">No hay tutores disponibles actualmente.</p>
                <p class="text-gray-500 mt-2">Por favor intenta nuevamente más tarde.</p>
                <?php error_log("No se encontraron tutores disponibles"); ?>
            </div>
        <?php else: ?>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($tutorsAvailable as $tutor): ?>
                    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                        <div class="flex justify-between items-start">
                            <div class="w-full">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">
                                    <?= htmlspecialchars($tutor['name'] ?? 'Tutor') ?>
                                </h3>

                                <div class="flex items-center mb-2">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                        <?= htmlspecialchars($tutor['subjects'] ?? 'Área no especificada') ?>
                                    </span>
                                </div>

                                <!-- Calificación en estrellas -->
                                <div class="mt-2 flex items-center gap-1">
                                    <?php
                                        $rating = (int) floor($tutor['rating'] ?? 0);
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $rating) {
                                                echo '<i class="fas fa-star text-yellow-400"></i>';
                                            } else {
                                                echo '<i class="far fa-star text-yellow-400"></i>';
                                            }
                                        }
                                    ?>
                                </div>

                                <div class="space-y-2 mt-2">
                                    <p class="text-gray-700">
                                        <i class="fas fa-calendar-day text-purple-500 mr-2"></i>
                                        <?= htmlspecialchars($tutor['day_name'] ?? 'Día no disponible') ?>
                                    </p>
                                    <p class="text-gray-700">
                                        <i class="fas fa-clock text-purple-500 mr-2"></i>
                                        <?= htmlspecialchars($tutor['start_time'] ?? '--:--') ?> 
                                        a 
                                        <?= htmlspecialchars($tutor['end_time'] ?? '--:--') ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <a href="<?= BASE_URL ?>index.php?url=RouteController/requestTutorial&tutor_id=<?= $tutor['code'] ?>&day=<?= $tutor['day_id'] ?>&start=<?= urlencode($tutor['start_time']) ?>&end=<?= urlencode($tutor['end_time']) ?>"
                               class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-full text-sm font-semibold transition-colors">
                                <i class="fas fa-calendar-check mr-1"></i> Solicitar Tutoría
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>