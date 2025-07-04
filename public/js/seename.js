
const inputFile = document.getElementById('dropzone-file');
const fileNameDisplay = document.getElementById('file-name');

inputFile.addEventListener('change', function () {
if (this.files && this.files.length > 0) {
fileNameDisplay.textContent = "Archivo seleccionado: " + this.files[0].name;
fileNameDisplay.classList.remove('hidden');
} else {
fileNameDisplay.textContent = '';
fileNameDisplay.classList.add('hidden');
        }
 });