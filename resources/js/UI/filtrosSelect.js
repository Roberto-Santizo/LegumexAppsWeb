import 'choices.js/public/assets/styles/choices.min.css';
import Choices from 'choices.js';

(function(){
    const selects = document.querySelectorAll('.select');
    
    if(selects){
        selects.forEach(select => {
            const choices = new Choices(select, {
                searchEnabled: true,
                placeholder: true,
                placeholderValue: '---SELECCIONE UNA OPCIÓN---',
                removeItemButton: true,
                itemSelectText: '',
                allowHTML: true
            }); 
        });
      
    }
    
})();