(function(){
    const ChecksLavadas = document.querySelectorAll('.lavadas');
    const ChecksDesinfectadas = document.querySelectorAll('.desinfectadas');
    const formulario1 = document.getElementById('formulario1');
    const formulario2 = document.getElementById('formulario2');

    if(formulario1 || formulario2){
        ChecksLavadas.forEach(function(checkLav){
            checkLav.addEventListener('change',function(e){
            CheckboxComprobacion(checkLav,ChecksLavadas,e);
         })
       });

       
       ChecksDesinfectadas.forEach(function(checkDes){
        checkDes.addEventListener('change',function(e){
        CheckboxComprobacion(checkDes,ChecksDesinfectadas,e);
            })
        });
    }

    function CheckboxComprobacion(check,Checks,e){
        Checks.forEach(function(checkbox){
            if((checkbox.value == check.value)){
                if((checkbox.name != check.name)){
                    checkbox.checked = false;
                }
            }
        })
    }

})();