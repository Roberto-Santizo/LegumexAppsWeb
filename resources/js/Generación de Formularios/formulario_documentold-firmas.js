import SignaturePad from 'signature_pad';

(function(){
    const formulario = document.getElementById('formulario1');
    const formulario2 = document.getElementById('formulario2');

    if(formulario){
        var firmaTecnicoMantenimientoCanvas = document.getElementById('signature-pad');
        var firmaInspeccionCalidadEntrada = document.getElementById('signature-pad-2');
        var firmaAsistenteMantenimientoCanvas = document.getElementById('signature-pad-3');

        var PadTecnicoManto = new SignaturePad(firmaTecnicoMantenimientoCanvas);
        var PadAsistenteManto = new SignaturePad(firmaAsistenteMantenimientoCanvas);
        var PadInspeccionCalidadEntrada = new SignaturePad(firmaInspeccionCalidadEntrada);
        
        document.getElementById('clear-button-3').addEventListener('click',function(){
            PadAsistenteManto.clear();
        })

        document.getElementById('clear-button').addEventListener('click',function(){
            PadTecnicoManto.clear();
        })

        document.getElementById('clear-button-2').addEventListener('click',function(){
            PadInspeccionCalidadEntrada.clear();
        })
    }

    if(formulario2){
        var firmaInspeccionCalidadSalida = document.getElementById('signature-pad');
        var firmaInspectorCalidadCanvas = document.getElementById('signature-pad-2');

        var PadInspectorCalidad = new SignaturePad(firmaInspectorCalidadCanvas);
        var PadInspeccionCalidadSalida = new SignaturePad(firmaInspeccionCalidadSalida);
        
        document.getElementById('clear-button-2').addEventListener('click',function(){
            PadInspectorCalidad.clear();
        })

        document.getElementById('clear-button').addEventListener('click',function(){
            PadInspeccionCalidadSalida.clear();
        })
    }

})();