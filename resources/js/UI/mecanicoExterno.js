(function(){
    const externo = document.getElementById('externo');

    if(externo){
        const mecanico_externo = document.getElementById('mecanico_externo');
        externo.addEventListener('change',function(e){
            if(externo.checked){
                mecanico_externo.disabled = false;
                mecanico_externo.hidden = false;
            }else{
                mecanico_externo.disabled = true;
                mecanico_externo.hidden =true;
            }
        });
    }
}());