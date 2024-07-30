(function(){
    const formulario = document.getElementById('formulario5');
    let alertas = [];

    if (formulario) {
        const inputArea = document.getElementById('area_id');
        const inputPlanta = document.getElementById('planta_id');

        inputArea.addEventListener('change',function(e){
            const inputEspecifique = document.querySelector('.especifique');

            if (e.target.value === '23' || e.target.value === '28') {
                inputEspecifique.classList.remove('hidden');
            } else {
                inputEspecifique.classList.add('hidden');
            }
        })

        inputPlanta.addEventListener('change',function(e){
            const inputEquipo = document.querySelector('.equipo_problema');
            const inputUbicacion = document.querySelector('.elemento_id');
            if (e.target.value === '3' || e.target.value=='4') {
                inputEquipo.classList.remove('hidden');
                inputUbicacion.classList.add('hidden');
            } else {
                inputEquipo.classList.add('hidden');
                inputUbicacion.classList.remove('hidden');
            }
        })
    }
})();
