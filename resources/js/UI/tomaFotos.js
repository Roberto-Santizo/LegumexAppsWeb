(function () {
    const my_camera = document.getElementById("my_camera");

    if (my_camera) {
        const take_button = document.getElementById('takesnapshot');


        Webcam.set({
            width: 320,
            height: 240,
            image_format: "jpeg",
            jpeg_quality: 90,
        });

        Webcam.attach("#my_camera");

        take_button.addEventListener("click", takeSnapshot);
    }

    // Función para capturar la foto
    function takeSnapshot() {
        const my_camera = document.getElementById('my_camera');
        const form = document.getElementById('uploadForm');
        const imageDataInput = document.getElementById('image_data');
        
        let images = [];

        Webcam.snap(function (data_uri) {
           
            const imgContainer = document.createElement('div');
            imgContainer.className = 'captured-image';
            imgContainer.innerHTML = 
                '<img src="' + data_uri + '" />';
            document.getElementById('results').appendChild(imgContainer);
            
            // Guardar la imagen en el array
            images.push(data_uri);

            // Imprimir el array de imágenes en la consola para verificar
            console.log(images);

            // Actualizar el campo oculto con los datos de la imagen en formato JSON
            imageDataInput.value = JSON.stringify(images);

            // También puedes enviar la imagen a tu servidor aquí
            // var formData = new FormData();
            // formData.append('image', data_uri);
            // fetch('/upload', {
            //     method: 'POST',
            //     body: formData
            // }).then(response => response.json())
            //   .then(data => console.log(data))
            //   .catch(error => console.error('Error:', error));
        });
    }

    // Exponer la función globalmente
    window.takeSnapshot = takeSnapshot;
})();
