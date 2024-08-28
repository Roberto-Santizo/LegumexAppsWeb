import Swal from "sweetalert2";

(function () {
    const my_camera = document.getElementById("my_camera");
    let images = [];

    if (my_camera) {
        const take_button = document.getElementById("takesnapshot");
        const upload_button = document.getElementById('upload_button');
        const switch_camera_button = document.getElementById('switch_camera');

        navigator.mediaDevices.enumerateDevices()
        .then(devices => {
          devices.forEach(device => {
            if (device.kind === 'videoinput') {
              alert(device.label, device.deviceId);
            }
          });
        });
        
        navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: { exact: "environment" } // O "user" para la cámara frontal
            }
        }).then(function(stream){
            Webcam.set({
                width: 250,
                height: 200,
                image_format: 'jpeg',
                jpeg_quality: 90,
                srcObject: stream // Usa el stream de video que configuraste manualmente
            });
            Webcam.attach('#my_camera');
        });
     
        upload_button.addEventListener('click', function(){
            Swal.fire({
                title: "Quieres guardar las imagenes?",
                text: 'Una vez guardadas no se pueden tomar más fotos o cambiar las fotos',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Guardar",
                denyButtonText: `No Guardar`
            }).then((result) => {
                if (result.isConfirmed) {
                    guardarImagenes();
                } 
            });
        });

        take_button.addEventListener("click", takeSnapshot);
    }

    // Función para capturar la foto
    function takeSnapshot() {
        Webcam.snap(function (data_uri) {
            const imgContainer = document.createElement("div");
            imgContainer.className = "captured-image";
            imgContainer.innerHTML = `
                <div class="p-2 shadow">
                    <img src="${data_uri}" />
                </div>
            `;
            document.getElementById("results").appendChild(imgContainer);

            images.push(data_uri);
        });
    }

    async function guardarImagenes() {
        const loadingIcon = document.getElementById('loading_icon');
        loadingIcon.classList.toggle('hidden');
        const datos = new FormData();
        const url = '/api/imagenes/upload';

        const base64ToBlob = (base64, type = 'image/jpeg') => {
            const [header, data] = base64.split(',');
            const byteCharacters = atob(data);
            const byteNumbers = new Array(byteCharacters.length);
            for (let i = 0; i < byteCharacters.length; i++) {
                byteNumbers[i] = byteCharacters.charCodeAt(i);
            }
            return new Blob([new Uint8Array(byteNumbers)], { type });
        };

        // Agrega imágenes a FormData
        images.forEach((base64, index) => {
            const blob = base64ToBlob(base64, 'image/jpeg');
            datos.append(`imagenes${index + 1}`, blob, `firma${index + 1}.jpg`);
        });

        const response = await fetch(url, {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: datos
        });

        const result = await response.json();
        if(result.status){
            const folder_url = document.getElementById('folder_url');
            const folder_id = document.getElementById('folder_id');
            const camera = document.getElementById('camera');

            folder_url.value = result.folder_url;
            folder_id.value = result.folder_id;
            camera.classList.add('hidden');

            Swal.fire({
                title: 'Imagenes subidas correctamente!',
                text: 'Las imagenes fueron subidas correctamente',
                icon: 'success',
                confirmButtonText: 'Ok'
            }).then(()=>{
                loadingIcon.classList.toggle('hidden');
            });
        }
    }
})();
