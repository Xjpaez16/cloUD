document.addEventListener('DOMContentLoaded', function() {
    const notyf = new Notyf({
        duration: 3000,
        position: {
            x: 'center',
            y: 'bottom',
        },
        dismisible: true,
        ripple: false,
        timeout: 2000,
    });
    const hora_Inicio = document.getElementById('hora_inicio');
    const hora_Fin = document.getElementById('hora_fin');
    const form = hora_Inicio.closest('form');
   
    const horamin = hora_Inicio.dataset.horamin;
    const horafin = hora_Fin.dataset.horafin;

    function convertirHoraAMinutos(hora) {
        const [h,m]=hora.split(':').map(Number);
        return h * 60 +m;
    }

    function convertirA12Horas(hora24) {
    const [hora, minutos] = hora24.split(':').map(Number);
    const ampm = hora >= 12 ? 'PM' : 'AM';
    const hora12 = (hora % 12) || 12; // El 0 se convierte en 12
    return `${hora12}:${minutos.toString().padStart(2, '0')} ${ampm}`;
    }

    form.addEventListener('submit', function(e){
        const inicioVal = hora_Inicio.value;
        const finalVal = hora_Fin.value;
        if(!inicioVal ||  !finalVal){
            return;
        }
        const inicioMin = convertirHoraAMinutos(inicioVal);
        const finalMin = convertirHoraAMinutos(finalVal);
        const minPermitido = convertirHoraAMinutos(horamin);
        const maxPermitido = convertirHoraAMinutos(horafin);
        
        if(inicioMin < minPermitido || finalMin > maxPermitido){
            e.preventDefault();
            notyf.open({
                type: 'error',
                message: 'La hora digitada no puede ser menor a ' + convertirA12Horas(horamin) + ' y mayor a '+ convertirA12Horas(horafin),
            });
            return;
        }
        if(finalMin <= inicioMin){
            e.preventDefault();
            notyf.open({
                type: 'error',
                message: 'La hora digitada debe ser mayor a la de inicio'
            });
            return;
        }
    });
    
    
    console.log("JS cargado y funcionando");
}); 