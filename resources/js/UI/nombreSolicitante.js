(function(){
    const check_solicitante = document.getElementById('check_solicitante');

    if(check_solicitante){
        const nombre_solicitante = document.getElementById('nombre_solicitante');
        check_solicitante.addEventListener('change',function(e){
            if(check_solicitante.checked){
                nombre_solicitante.disabled = false;
                nombre_solicitante.hidden = false;
            }else{
                nombre_solicitante.disabled = true;
                nombre_solicitante.hidden =true;
            }
        });
    }
}());