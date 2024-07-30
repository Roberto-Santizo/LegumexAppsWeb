import SignaturePad from 'signature_pad';

(function(){
    const formulario = document.getElementById('formulario4');

    if(formulario){
        
        var canvas1 = document.getElementById('signature-pad');
        var canvas2 = document.getElementById('signature-pad-2');
        var canvas3 = document.getElementById('signature-pad-3');
        var canvas4 = document.getElementById('signature-pad-4');


        if(canvas1){
            var canvasPad1 = new SignaturePad(canvas1);
            document.getElementById('clear-button').addEventListener('click',function(){
                canvasPad1.clear();
            })
        }
        if(canvas2){
            var canvasPad2 = new SignaturePad(canvas2);
            document.getElementById('clear-button-2').addEventListener('click',function(){
                canvasPad2.clear();
            })

        }
        if(canvas3){
            var canvasPad3 = new SignaturePad(canvas3); 
            document.getElementById('clear-button-3').addEventListener('click',function(){
                canvasPad3.clear();
            })
    
        }
        if(canvas4){
            var canvasPad4 = new SignaturePad(canvas4);
            document.getElementById('clear-button-4').addEventListener('click',function(){
                canvasPad4.clear();
            })
        }

    }

})();