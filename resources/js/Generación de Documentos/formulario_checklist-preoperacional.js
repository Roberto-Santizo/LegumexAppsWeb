// LAVADO Y DESINFECCIÓN DOCUMENTO
import html2canvas from "html2canvas";
import jsPDF from "jspdf";
import Swal from "sweetalert2";

(function(){
    const documentocp = document.getElementById('documento3');

    if(documentocp){
        var url = window.location.href;
        var urlObj = new URL(url);
        var windowWidth = 4608; 
        var windowHeight = 2212.80;
        var options = {
            windowWidth: windowWidth,
            windowHeight: windowHeight,
            scale: 1
        };
    
        try {
            document.addEventListener('DOMContentLoaded', function(){
                html2canvas(document.querySelector('.documento-wrapper'), options).then(function(canvas){
                    var imgData = canvas.toDataURL('image/png');
    
                    const doc = new jsPDF('landscape');
                
                    var pageWidth = doc.internal.pageSize.getWidth();
                    var pageHeight = doc.internal.pageSize.getHeight();
    
                    var canvasWidth = canvas.width;
                    var canvasHeight = canvas.height;
    
                    // Ajustar la imagen para que ocupe todo el ancho y la altura de la página
                    var imageWidth = pageWidth;
                    var imageHeight = (canvasHeight * pageWidth) / canvasWidth;
    
                    if (imageHeight < pageHeight) {
                        imageHeight = pageHeight;
                        imageWidth = (canvasWidth * pageHeight) / canvasHeight;
                    }
    
                    doc.addImage(imgData, 'JPEG', 0, 0, imageWidth, imageHeight, undefined, 'FAST');
                    
                    var pdfBlob = doc.output('blob');
                    guardarDocumento(pdfBlob);
    
                });
            });
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema generando el documento. Por favor, inténtalo de nuevo.'
            });
        }

        async function guardarDocumento(file){
            const data =  new FormData();
            const url = '/mantenimiento/documentocp/upload';
            const token  =  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const documentocp_id = urlObj.pathname.split('/').pop();
    
            data.append('file',file);
            data.append('documentocp_id',documentocp_id);
    
            try {
                const response = await fetch(url,{
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                    },
                    body: data
                })
    
                const result = await response.json();
                if(result.status == 200){
                    document.getElementById("loadingScreen").style.display = "none";
                    Swal.fire({
                        icon: 'success',
                        title: 'Listo!',
                        text: 'El archivo se ha subido correctamente',
                        confirmButtonText: 'OK'
                    }).then(()=>{
                        window.location.href = "/mantenimiento/documentocp"
                    }); 
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error! :(',
                    text: 'Hubo un error al generar el archivo, intentelo de nuevo más tarde',
                    confirmButtonText: 'OK'
                }).then(()=>{
                    window.location.href = "/mantenimiento/documentocp"
                });
            }
        }
    }


    
})();