<div id="cancelationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[80vh] overflow-hidden mx-4">
        <div class="flex justify-between items-center border-b p-4">
            <h3 class="text-xl font-bold text-gray-800">Tutorías Pendientes</h3>
            <button onclick="document.getElementById('cancelationModal').classList.add('hidden')" 
                    class="text-gray-500 hover:text-gray-700 text-xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="p-4 overflow-y-auto">
            <?php if (empty($tutoriasPendientes)): ?>
                <div class="text-center py-8">
                    <i class="fas fa-calendar-check text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600">No tienes tutorías pendientes para cancelar.</p>
                </div>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($tutoriasPendientes as $tutoria): ?>
                        <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-gray-800">
                                        <i class="far fa-calendar-alt text-blue-500 mr-2"></i>
                                        <?= htmlspecialchars($tutoria->getFecha()) ?>
                                    </p>
                                    <p class="text-sm text-gray-600 mt-1">
                                        <i class="far fa-clock text-blue-500 mr-2"></i>
                                        <?= htmlspecialchars($tutoria->getHora_inicio()) ?> - <?= htmlspecialchars($tutoria->getHora_fin()) ?>
                                    </p>
                                </div>
                                <button onclick="document.getElementById('cancelForm<?= $tutoria->getId() ?>').classList.toggle('hidden')" 
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm flex items-center">
                                    <i class="fas fa-ban mr-1"></i> Cancelar
                                </button>
                            </div>

                            <form id="cancelForm<?= $tutoria->getId() ?>" 
                                  action="<?= BASE_URL ?>index.php?url=RouteController/processCancelation" 
                                  method="POST"
                                  class="hidden mt-3 p-3 bg-gray-50 rounded-lg">
                                <input type="hidden" name="id_tutoria" value="<?= $tutoria->getId() ?>">
                                
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-comment-alt text-blue-500 mr-1"></i> Motivo:
                                    </label>
                                    <select name="motivo" required 
                                            class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <?php foreach ($motivos as $motivo): ?>
                                            <option value="<?= $motivo->getCodigo() ?>">
                                                <?= htmlspecialchars($motivo->getTipo_motivo()) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="flex justify-end space-x-2">
                                    <button type="button" onclick="document.getElementById('cancelForm<?= $tutoria->getId() ?>').classList.add('hidden')" 
                                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-3 py-1 rounded-lg text-sm">
                                        <i class="fas fa-arrow-left mr-1"></i> Volver
                                    </button>
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm">
                                        <i class="fas fa-check mr-1"></i> Confirmar
                                    </button>
                                </div>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Función para abrir el modal desde otros lugares
function openCancelationModal() {
    document.getElementById('cancelationModal').classList.remove('hidden');
}
</script>