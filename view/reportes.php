<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>📊 Reportes en PDF</title>
    <!-- jsPDF desde CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<!-- AutoTable desde CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>


    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script>
        const BASE_URL = '<?= BASE_URL ?>';
    </script>
    <script src="<?= BASE_URL ?>public/js/reportes.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative min-h-screen bg-cover bg-bottom bg-no-repeat text-white font-sans flex items-center justify-center p-6"
    style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg');">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl p-8">
        <h1 class="text-3xl font-bold text-center text-[#5D54A4] mb-8">📊 Generar Reportes del Sistema</h1>

        <!-- Formulario de fechas -->
        <form id="form-fechas" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 text-black">
            <div>
                <label for="desde" class="text-sm font-semibold text-gray-600">Desde:</label>
                <input type="date" id="desde" class="w-full mt-1 p-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#5D54A4]" required>
            </div>
            <div>
                <label for="hasta" class="text-sm font-semibold text-gray-600">Hasta:</label>
                <input type="date" id="hasta" class="w-full mt-1 p-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#5D54A4]" required>
            </div>
        </form>

        <!-- Enlaces para reportes -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-center">
            <a href="#" id="btn-reporte1"
               class="bg-[#5D54A4] hover:bg-[#443C88] text-white font-semibold py-2 px-4 rounded-full transition block">
                📌 Tutor más agendado
            </a>
            <a href="#" id="btn-reporte2"
               class="bg-[#5D54A4] hover:bg-[#443C88] text-white font-semibold py-2 px-4 rounded-full transition block">
                📌 Estudiante más activo
            </a>
            <a href="#" id="btn-reporte3"
               class="bg-[#5D54A4] hover:bg-[#443C88] text-white font-semibold py-2 px-4 rounded-full transition block">
                ⭐ Top 3 tutores por calificación
            </a>
            <a href="#" id="btn-reporte4"
               class="bg-[#5D54A4] hover:bg-[#443C88] text-white font-semibold py-2 px-4 rounded-full transition block">
                📂 Estudiante con más archivos
            </a>
        </div>
    </div>
</body>
</html>
