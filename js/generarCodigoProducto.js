//Funcion para cuando seleccione el checbox genere codigo de barras 
const codigoBarras = document.getElementById('codProduc');

// Obtener el checkbox por su ID
const checkboxGeneraCodigoB = document.getElementById('codigoGenerado');

// Agregar un manejador de eventos para el evento 'change'
checkboxGeneraCodigoB.addEventListener('change', async function() {

    if (checkboxGeneraCodigoB.checked) {

        const idConsecutivo= 1;

        const consecutivo = await consultarConsecutivoCodigo(idConsecutivo);

        //Convertimos el resultado en numero
        const consecutivoN  = parseFloat(consecutivo);

        const consecutivoNuevo = consecutivoN + 1;

        codigoBarras.value = consecutivoNuevo;

    } else {
        document.getElementById('codProduc').value = '';
    }
});


//Funcion para taer el consecutivo del codigo de barras
async function consultarConsecutivoCodigo(idConsecutivo) {
    
        try {
            const response = await fetch('index.php?action=generaCodigoProducto', {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ idConsecutivo: idConsecutivo }), // Enviar datos al servidor como JSON
            });

            const data = await response.json();

            if (data.success) {

                return data.consecutivoCodigo.CodigoBarra;

            } else {
                console.error('Error:', data.error);
                return null;
            }
        } catch (error) {
            console.error('Error al obtener el consecutivo:', error);
            return null;
        }
    }