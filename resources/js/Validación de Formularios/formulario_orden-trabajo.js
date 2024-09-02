import { firmaVacia } from '../helpers';
import validator from 'validator';

function validarDatosOTVM(){
    const retiro_equipo = document.getElementById('retiro_equipo').value;
    const problema_detectado = document.getElementById('problema_detectado').value;
    const firma = document.getElementById('signature-pad');
    const firma2 = document.getElementById('signature-pad-2');
    const fecha_propuesta = document.getElementById('fecha_propuesta').value;
    const supervisor = document.getElementById('supervisor_id').value;
    const folder_id = document.getElementById('folder_id').value; 
    const folder_url = document.getElementById('folder_url').value; 

    let alertas = [];
    
    if(retiro_equipo == ''){
        alertas.push('Especifique si es necesario retirar el equipo');
    }

    if(supervisor == ''){
        alertas.push('Seleccione un supervisor');
    }

    if(problema_detectado == ''){
        alertas.push('Especifique el problema detectado');
    }

    if(folder_id == ''){
        alertas.push('Asegurese de haber tomado y guardado las fotos');
    }

    if(folder_url == ''){
        alertas.push('Asegurese de haber tomado y guardado las fotos');
    }

    if(!(validator.isLength(problema_detectado,{max:750}))){
        alertas.push('Las observaciones generales no pueden exceder los 750 caracteres');
    }

    if(!fecha_propuesta){
        alertas.push('Agrege la fecha propuesta de entrega');
    }

    if(firmaVacia(firma) || firmaVacia(firma2)){
        alertas.push('Asegurese de haber firmado');
    }


    return alertas;
}

function validarDatosOT(){
    const retiro_equipo = document.getElementById('retiro_equipo').value;
    const problema_detectado = document.getElementById('problema_detectado').value;
    const firma = document.getElementById('signature-pad');
    const firma2 = document.getElementById('signature-pad-2');
    const fecha_propuesta = document.getElementById('fecha_propuesta').value;
    const planta_id = document.getElementById('planta_id').value;
    const area_id = document.getElementById('area_id').value;
    const supervisor = document.getElementById('supervisor_id').value;
    const folder_id = document.getElementById('folder_id').value; 
    const folder_url = document.getElementById('folder_url').value; 

    let alertas = [];
    
    if(planta_id == ''){
        alertas.push('Seleccione un planta');
    }

    if(folder_id == ''){
        alertas.push('Asegurese de haber tomado y guardado las fotos');
    }

    if(folder_url == ''){
        alertas.push('Asegurese de haber tomado y guardado las fotos');
    }

    if(planta_id == '1' || planta_id == '2' || planta_id == '5'){
        const ubicacion_id = document.getElementById('elemento_id').value;
     
        if(ubicacion_id == '' || ubicacion_id == 0){
            alertas.push('Seleccione un ubicacion');
        }
        
    }else{
        const area_id = document.getElementById('area_id').value;
        const equipo_problema = document.getElementById('equipo_problema').value;

        if(equipo_problema == ''){
            alertas.push('Especifique el equipo con problema'); 
        }

        if(!(validator.isLength(equipo_problema,{max:60}))){
            alertas.push('El nombre del equipo con problema no debe exceder los 120 caracteres');
        }

        if(area_id == '23' || area_id == '28'){
            const especifique = document.getElementById('especifique').value;

            if(especifique == ''){
                alertas.push('Especifique el área en donde se encuentra el problema'); 
            }

            if(!(validator.isLength(especifique,{max:60}))){
                alertas.push('La especificación del área no debe exceder los 60 caracteres');
            }
        }

    }

    if(area_id == ''){
        alertas.push('Seleccione un area');
    }


    if(retiro_equipo == ''){
        alertas.push('Especifique si es necesario retirar el equipo');
    }

     if(supervisor == ''){
        alertas.push('Seleccione un supervisor');
    }

    if(problema_detectado == ''){
        alertas.push('Especifique el problema detectado');
    }

    if(!(validator.isLength(problema_detectado,{max:750}))){
        alertas.push('Las observaciones generales no pueden exceder los 750 caracteres');
    }

    if(!fecha_propuesta){
        alertas.push('Agrege la fecha propuesta de entrega');
    }

    if(firmaVacia(firma) || firmaVacia(firma2)){
        alertas.push('Asegurese de haber firmado');
    }


    return alertas;
}

    function validarFormularioOT1(){
        let alertasaux = [];
        const trabajo_realizado = document.getElementById('trabajo_realizado').value;
        const repuestos_utilizados = document.getElementById('repuestos_utilizados').value;
        const hora_inicio = document.getElementById('hora_inicio').value;
        const hora_final = document.getElementById('hora_final').value;
        const fecha_entrega = document.getElementById('fecha_entrega').value;
        const calidad = document.getElementById('c_calidad_id').value;
        const firma = document.getElementById('signature-pad-2');
        const firma2 = document.getElementById('signature-pad-3');


        
        if (firmaVacia(firma) || firmaVacia(firma2)) {
            alertasaux.push('Asegurese de haber firmado');
        }

        if (trabajo_realizado == '') {
            alertasaux.push('Asegurese de ingresar el trabajo que se haya realizado');
        }

        if(!(validator.isLength(trabajo_realizado,{max:750}))){
            alertasaux.push('El texto de trabajo realizado no debe exceder los 750 caracteres');
        }
    
        if (repuestos_utilizados == '') {
            alertasaux.push('Asegurese de ingresar los repuestos que se hayan utilizado');
        }

        if(!(validator.isLength(repuestos_utilizados,{max:750}))){
            alertasaux.push('El texto de repuestos utilizados no debe exceder los 750 caracteres');
        }
        if (hora_inicio == '') {
            alertasaux.push('Ingrese la hora en la que inició');
        }

        if (hora_final == '') {
            alertasaux.push('Ingrese la hora en la que finalizó');
        }

        if (fecha_entrega == '') {
            alertasaux.push('Ingrese la fecha en la que se entregó');
        }

        if(calidad == ''){
            alertasaux.push('Seleccione un supervisor de calidad');
        }
        
        return alertasaux;
      
    }

    function validarFormularioOT2(){
        let alertasaux = [];
        const jefemanto_nombre = document.getElementById('jefemanto_nombre').value;
        const fecha_inspeccion = document.getElementById('fecha_inspeccion').value;
        const firma = document.getElementById('signature-pad-3');
  
        if (firmaVacia(firma)) {
            alertasaux.push('Aseguere de haber firmado');
        }

        if (jefemanto_nombre == '') {
            alertasaux.push('Asegurese de ingresar el nombre de jefe de mantenimiento');
        }

        if (fecha_inspeccion == '') {
            alertasaux.push('Asegurese de colocar la fecha de la inspección');
        }

        return alertasaux;
      
    }

export {validarDatosOTVM ,validarDatosOT, validarFormularioOT1,  validarFormularioOT2}