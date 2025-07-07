<?php

$tutoria = $_SESSION['tutorias_a_calificar'][0];
?>

<!-- Modal de calificación -->
<div id="calificacionModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-purple-800 text-white rounded-xl w-full max-w-lg mx-auto shadow-2xl p-6 border border-white">
        <h2 class="text-2xl font-bold mb-4 text-center">Califica la tutoría finalizada</h2>

        <form id="formCalificacion" action="<?= BASE_URL ?>StudentController/guardarCalificacion" method="POST">
            <input type="hidden" name="id_tutoria" value="<?= $tutoria->getId() ?>">
            <input type="hidden" name="calificacion" id="calificacion" required>
            <input type="hidden" name="cod_tutor" value="<?= $tutoria->getCod_tutor() ?>">

            <p class="mb-4 text-sm text-white text-center">
                <?= $tutoria->getFecha() ?> — <?= $tutoria->getHora_inicio() ?> a <?= $tutoria->getHora_fin() ?>
            </p>

            <!-- Estrellas interactivas -->
            <div class="flex justify-center space-x-2 mb-6 text-3xl">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class="fa-regular fa-star star cursor-pointer text-gray-300 transition-transform duration-200 transform hover:scale-125"
                       data-value="<?= $i ?>"></i>
                <?php endfor; ?>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="submit"
                        class="bg-yellow-400 hover:bg-yellow-300 text-purple-900 font-semibold px-5 py-2 rounded-lg transition duration-200">
                    Enviar Calificación
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script de manejo de estrellas -->
<script>
    const stars = document.querySelectorAll('.star');
    const calificacionInput = document.getElementById('calificacion');
    let selectedValue = 0;

    function highlightStars(value) {
        stars.forEach(star => {
            const starValue = parseInt(star.dataset.value);
            if (starValue <= value) {
                star.classList.remove('fa-regular', 'text-gray-300');
                star.classList.add('fa-solid', 'text-yellow-400');
            } else {
                star.classList.remove('fa-solid', 'text-yellow-400');
                star.classList.add('fa-regular', 'text-gray-300');
            }
        });
    }

    stars.forEach(star => {
        star.addEventListener('mouseover', () => {
            const value = parseInt(star.dataset.value);
            highlightStars(value);
        });

        star.addEventListener('mouseout', () => {
            highlightStars(selectedValue);
        });

        star.addEventListener('click', () => {
            selectedValue = parseInt(star.dataset.value);
            calificacionInput.value = selectedValue;
            highlightStars(selectedValue);

            // Pequeña animación al hacer clic
            star.classList.add('scale-150');
            setTimeout(() => {
                star.classList.remove('scale-150');
            }, 150);
        });
    });
</script>


