(function(){
    const horas_totales = document.getElementById('horas_totales');

    if(horas_totales){
        const personas = document.getElementById('personas');
        const tarifa = document.getElementById('tarifa');
        const presupuesto = document.getElementById('presupuesto');

        horas_totales.addEventListener('input',function(e){
            let personasTotales = e.target.value / 8;
            personas.value = Math.floor(personasTotales);
            presupuesto.value = tarifa.value * horas_totales.value;
        });

        tarifa.addEventListener('input',function(e){
            presupuesto.value = tarifa.value * horas_totales.value;
        })
    }

})();