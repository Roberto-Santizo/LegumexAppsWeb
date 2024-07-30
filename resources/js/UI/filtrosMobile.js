(function(){
    const FiltrosBtn = document.getElementById('FiltrosBtn');
    
    if(FiltrosBtn){
        FiltrosBtn.addEventListener('click',function(e){
            const filtros = document.getElementById('filtros');

            filtros.classList.toggle('hidden');
        })
    }
    
})();