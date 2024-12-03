// LAVADO Y DESINFECCIÓN DOCUMENTO
import html2canvas from "html2canvas";
import jsPDF from "jspdf";
import Swal from "sweetalert2";

(function(){
    const documentold = document.getElementById('documento');

    if(documentold){
        var url = window.location.href;
        var urlObj = new URL(url);
        var windowWidth = 877.80; 
        var windowHeight = 491.73;
        var options = {
            windowWidth: windowWidth,
            windowHeight: windowHeight,

            scale: 1
        };
        try {
            document.addEventListener('DOMContentLoaded',function(){
                html2canvas(document.querySelector('.documento-wrapper'),options).then(function(canvas){
                    var image = new Image;
                    image.src = canvas.toDataURL('image/png');
                    var imgData = canvas.toDataURL('image/png');
    
                    const doc = new jsPDF();
                
                    var imageWidth = doc.internal.pageSize.getWidth() - 40;
                    var pageWidth = doc.internal.pageSize.getWidth();
                    
                    var imageHeight =  canvas.height * (imageWidth / canvas.width);
                   
                    if (imageHeight > doc.internal.pageSize.getHeight() - 40) { // Altura de la página menos los márgenes
                        // Reducir la altura de la imagen para que quepa dentro de la página
                        imageHeight = doc.internal.pageSize.getHeight() - 40;
                        imageWidth = canvas.width * (imageHeight / canvas.height); // Ajustar el ancho proporcionalmente
                    }
                    var xPosition = (pageWidth - imageWidth) / 2;
                    
                    doc.addImage(imgData, 'JPEG',xPosition,10,imageWidth,imageHeight,undefined,'FAST','center'); // Cambia las coordenadas y dimensiones según sea necesario
                    
                    html2canvas(document.querySelector('.pie-pagina'),options).then(function(footerCanvas){
                        var footerImgData = footerCanvas.toDataURL('image/png');
    
                        // Obtener las dimensiones de la imagen del footer
                        var footerImgWidth = footerCanvas.width;
                        var footerImgHeight = footerCanvas.height;
                        
                        // Calcular el ancho del pie de página en relación con el ancho de la página PDF
                        var pageWidth = doc.internal.pageSize.width;
                        var footerWidth = pageWidth - 20; // Ajuste de márgenes
    
                        // Calcular la altura del pie de página en relación con el ancho de la imagen del pie de página
                        var scaleFactor = footerWidth / footerImgWidth;
                        var footerHeight = footerImgHeight * scaleFactor;
                        doc.addImage(footerImgData, 'PNG', 10, doc.internal.pageSize.height - footerHeight - 10, footerWidth, footerHeight,undefined,'FAST');
                    
                        var pdfBlob = doc.output('blob');
                        guardarDocumento(pdfBlob);
                    })
                })
         
            })
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema generando el documento. Por favor, inténtalo de nuevo.'
            });
        }
        
        async function guardarDocumento(file){
            const data =  new FormData();
            const url = '/mantenimiento/documentold/upload';
            const token  =  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const documentoldId = urlObj.pathname.split('/').pop();
    
            data.append('file',file);
            data.append('documentold_id',documentoldId);
    
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
                        window.location.href = "/mantenimiento/documentold"
                    }); 
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Error! :(',
                        text: 'Hubo un error al guardar el archivo, intentelo de nuevo más tarde',
                        confirmButtonText: 'OK'
                    }).then(()=>{
                        window.location.href = "/mantenimiento/administracion/ordenes-trabajos"
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error! :(',
                    text: 'Hubo un error al generar el archivo, intentelo de nuevo más tarde',
                    confirmButtonText: 'OK'
                }).then(()=>{
                    window.location.href = "/mantenimiento/documentold"
                });
            }
        }
    }
})();