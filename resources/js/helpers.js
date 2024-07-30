function firmaVacia(firma) {
    var context = firma.getContext('2d');
    var imageData = context.getImageData(0, 0, firma.width, firma.height).data;
    
    for (var i = 0; i < imageData.length; i += 4) {
        if (imageData[i + 3] !== 0) {
            return false; // La firma no está vacío
        }
    }
    
    return true; // La firma está vacío
}

function mostrarAlertas(alertas, contenedor, parametros = []) {
    const alertas2 = contenedor.querySelectorAll('.alerta');

    alertas2.forEach(alertadiv => {
        if (alertadiv.parentNode === contenedor) {
            contenedor.removeChild(alertadiv);
        }
    });

    const primerHijo = contenedor.firstChild;

    alertas.forEach(alerta => {
        const alertadiv = document.createElement('DIV');
        alertadiv.classList.add('alerta', 'text-white', 'bg-red-500', 'font-bold', 'p-3', 'mb-5', 'rounded', 'uppercase');
        
        if (parametros.length > 0) {
            parametros.forEach(parametro => {
                alertadiv.classList.add(parametro);
            });
        }

        alertadiv.textContent = alerta;
        contenedor.insertBefore(alertadiv, primerHijo);
    });

    if (!(parametros.length > 0)) {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
}



function sonIguales(arr1, arr2) {
    return arr1.toString() === arr2.toString();
  }

  function blobToBase64(blob) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = () => {
            const base64data = reader.result.split(',')[1];
            resolve(base64data);
        };
        reader.onerror = (error) => {
            reject(error);
        };
    });
}

function quitarAlertas(contenedor) {
    const alertas = contenedor.querySelectorAll('.alerta');
    
    alertas.forEach(alertadiv => {
        if (contenedor.contains(alertadiv)) {
            contenedor.removeChild(alertadiv);
        }
    });
}



function scrollTop(){
    document.getElementById('contenido').scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

function reloadSign() {
    const form = document.querySelector('form'); // Selecciona el formulario

    window.addEventListener('beforeunload', function (e) {
        const confirmationMessage = 'Los datos que se hayan ingresado se perderán';
        (e || window.event).returnValue = confirmationMessage;
        return confirmationMessage; 
    });

    if (form) {
        form.addEventListener('submit', function () {
            window.removeEventListener('beforeunload', beforeUnloadHandler);
            
            // Vuelve a agregar el evento after a short delay
            setTimeout(function() {
                window.addEventListener('beforeunload', beforeUnloadHandler);
            }, 1000);
        });
    }
}


export {firmaVacia, mostrarAlertas, sonIguales, blobToBase64, scrollTop, reloadSign, quitarAlertas};