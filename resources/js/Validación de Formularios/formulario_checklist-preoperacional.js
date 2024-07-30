import { firmaVacia } from '../helpers';
import validator from "validator";

    
function validarDatosChecklistPreoperacional(canvasPads,inputsText,observaciones) {
    const checks = document.querySelectorAll('.table__check');
    
    const alertas = [];

    for(const input of inputsText){
        if(!(validator.isLength(input.value,{max:29}))){
            alertas.push('Los textos de problemas y acciones deben ser menos de 29 caracteres de lo contrario el documento no se genenarará de la manera correcta');
            break;
        }
    }

    if(!(validator.isLength(observaciones.value,{max:500}))){
        alertas.push('Las observaciones generales no pueden exceder los 500 caracteres');
    }
        
    for (const canvas of canvasPads) {
        if (firmaVacia(canvas)) {
            alertas.push("Asegurese de haber revisado todas las áreas");
            break;
        }
    }

    checks.forEach(check => {
        const problema = document.querySelector(`.problem-${check.dataset.id}`).value;
        const action = document.querySelector(`.action-${check.dataset.id}`).value;
        const responsable = document.getElementById(`responsable-${check.dataset.id}`).value;

        if(!check.checked){
            if (problema == '' || action == '' || !responsable) {
                alertas.push("Una o varias ubicaciones se encuentran en estado NO OK, asegúrese de haber colocado la información correspondiente");
            }
        }
    });
    
    return alertas;
}

export { validarDatosChecklistPreoperacional };