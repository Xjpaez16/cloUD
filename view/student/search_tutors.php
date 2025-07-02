<?php
require_once __DIR__ . '/../layouts/nav.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutores Disponibles | cloUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Incluir jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body class="bg-gray-50" style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover;">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-white mb-6 text-center">Tutores Disponibles</h1>
        
        <!-- Formulario de Filtros (ahora sin acción, manejado por AJAX) -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8" id="filters-container">
            <form id="filters-form" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Filtro por Área -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-book mr-2 text-purple-500"></i>Área de Enseñanza
                    </label>
                    <select name="area" id="area-filter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">Todas las áreas</option>
                        <?php if(isset($areas) && is_array($areas)): ?>
                            <?php foreach ($areas as $area): ?>
                                <option value="<?= $area->getCodigo() ?>">
                                    <?= htmlspecialchars($area->getNombre()) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                
                <!-- Filtro por Calificación -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-star mr-2 text-purple-500"></i>Calificación Mínima
                    </label>
                    <select name="rating" id="rating-filter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">Cualquier calificación</option>
                        <option value="3">3+ Estrellas</option>
                        <option value="4">4+ Estrellas</option>
                        <option value="5">5 Estrellas</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Contenedor para resultados (se actualizará via AJAX) -->
        <div id="tutors-container">
            <?php include __DIR__ . '/partials/tutors_list.php'; ?>
        </div>
    </div>

    <!-- Script AJAX -->
    <script>
    $(document).ready(function() {
        // Manejar envío del formulario
        $('#filters-form').on('submit', function(e) {
            e.preventDefault();
            filterTutors();
        });

        // Manejar cambio en los selects
        $('#area-filter, #rating-filter').on('change', function() {
            filterTutors();
        });

        // Manejar botón de limpiar
        $('#reset-filters').on('click', function() {
            $('#area-filter').val('');
            $('#rating-filter').val('');
            filterTutors();
        });

     // Función para filtrar tutores
        function filterTutors() {
            const area = $('#area-filter').val();
            const rating = $('#rating-filter').val();

            // Debug: Mostrar valores de filtros
            console.log("Filtrando por - Área:", area, "| Calificación:", rating);

            $.ajax({
                url: '<?= BASE_URL ?>index.php?url=RouteController/filterTutorsAjax',
                type: 'GET',
                data: {
                    area: area,
                    rating: rating
                },
                beforeSend: function() {
                    $('#tutors-container').html(`
                        <div class="text-center py-8">
                            <i class="fas fa-spinner fa-spin text-2xl text-purple-500"></i>
                            <p class="mt-2">Buscando tutores...</p>
                        </div>
                    `);
                },
                success: function(response) {
                    $('#tutors-container').html(response);
                    // Debug: Mostrar respuesta
                    console.log("Respuesta recibida:", response);
                },
                error: function(xhr, status, error) {
                    console.error("Error en AJAX:", error);
                    $('#tutors-container').html(`
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                            <p>Error al cargar los tutores. Por favor intenta nuevamente.</p>
                            <p class="text-sm">${error}</p>
                        </div>
                    `);
                }
            });
        }

        // Cargar tutores inicialmente
        filterTutors();
    });
    </script>
</body>
</html>