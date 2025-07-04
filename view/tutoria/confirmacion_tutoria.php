<?php require_once __DIR__ . '/../layouts/nav.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Tutoría | cloUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: #f0f;
            opacity: 0.7;
            animation: fall 5s linear infinite;
        }
        @keyframes fall {
            to { transform: translateY(100vh); }
        }
    </style>
</head>
<body class="bg-gray-50" style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover;">
    <!-- Efecto de confeti (opcional) -->
    <div id="confetti-container" class="fixed inset-0 overflow-hidden pointer-events-none z-0"></div>

    <div class="container mx-auto px-4 py-8 relative z-10">
        <div class="max-w-2xl mx-auto">
            <!-- Tarjeta principal -->
            <div class="bg-white rounded-xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
                <!-- Encabezado con gradiente -->
                <div class="bg-gradient-to-r from-purple-600 to-green-500 px-8 py-6">
                    <div class="flex items-center">
                        <div class="bg-white bg-opacity-20 p-3 rounded-full mr-4">
                            <i class="fas fa-check-circle text-white text-3xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white">¡Tutoría Solicitada Exitosamente!</h1>
                            <p class="text-white text-opacity-90 mt-1">Revisa los detalles de tu reserva</p>
                        </div>
                    </div>
                </div>
                
                <!-- Cuerpo -->
                <div class="p-8">
                    <!-- Resumen -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Resumen de tu tutoría</h2>
                        
                        <!-- Tarjeta de información -->
                        <div class="bg-purple-50 border border-purple-100 rounded-lg p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Columna izquierda -->
                                <div>
                                    <div class="flex items-start mb-4">
                                        <div class="bg-purple-100 p-2 rounded-full mr-3">
                                            <i class="fas fa-user-tie text-purple-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-500">Tutor asignado</h3>
                                            <p class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($tutor->getNombre()) ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <div class="bg-purple-100 p-2 rounded-full mr-3">
                                            <i class="fas fa-question-circle text-purple-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-500">Motivo</h3>
                                            <p class="text-lg font-semibold text-gray-800">
                                                <?= isset($motivo) ? htmlspecialchars($motivo->getTipo_motivo()) : 'General' ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Columna derecha -->
                                <div>
                                    <div class="flex items-start mb-4">
                                        <div class="bg-purple-100 p-2 rounded-full mr-3">
                                            <i class="far fa-calendar-alt text-purple-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-500">Fecha</h3>
                                            <p class="text-lg font-semibold text-gray-800">
                                                <?= date('l, d F Y', strtotime($tutoria->getFecha())) ?>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <div class="bg-purple-100 p-2 rounded-full mr-3">
                                            <i class="far fa-clock text-purple-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-500">Horario</h3>
                                            <p class="text-lg font-semibold text-gray-800">
                                                <?= date('h:i A', strtotime($tutoria->getHora_inicio())) ?> - <?= date('h:i A', strtotime($tutoria->getHora_fin())) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- ID de referencia -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-8">
                        <div class="flex items-center">
                            <div class="bg-gray-200 p-2 rounded-full mr-3">
                                <i class="fas fa-info-circle text-gray-600"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">ID de referencia</h3>
                                <p class="text-lg font-mono font-semibold text-purple-600"><?= $tutoria->getId() ?></p>
                                <p class="text-xs text-gray-500 mt-1">Guarda este número para cualquier consulta</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Acciones -->
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="<?= BASE_URL ?>index.php?url=RouteController/showTutorSearch" 
                           class="flex-1 bg-white border border-gray-300 hover:border-purple-500 text-gray-700 hover:text-purple-700 px-6 py-3 rounded-lg text-center transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-search mr-2"></i> Buscar más tutores
                        </a>
                        
                        <a href="<?= BASE_URL ?>index.php?url=RouteController/viewMyTutorial" 
                           class="flex-1 bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg text-center transition-all duration-300 flex items-center justify-center">
                            <i class="far fa-list-alt mr-2"></i> Ver mis tutorías
                        </a>
                    </div>
                </div>
                
                <!-- Pie de página -->
                <div class="bg-gray-50 px-8 py-4 border-t border-gray-200">
                    <p class="text-sm text-center text-gray-500">
                        Recibirás un recordatorio por correo electrónico 24 horas antes de tu tutoría
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para confeti (opcional) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Crear confeti
            const container = document.getElementById('confetti-container');
            const colors = ['#f0f', '#0ff', '#ff0', '#0f0', '#00f'];
            
            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.animationDelay = Math.random() * 5 + 's';
                confetti.style.width = Math.random() * 10 + 5 + 'px';
                confetti.style.height = Math.random() * 10 + 5 + 'px';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                container.appendChild(confetti);
            }
        });
    </script>
</body>
</html>