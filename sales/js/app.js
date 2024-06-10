$('#btn-create-sale').on('click', async (e) => {
    const ACTION = 'REGISTRAR VENTA';
    const formSale = document.getElementById('sale-data-form');
    const formClient = document.getElementById('client-data-form');
    
    if(!isFormValidity(formClient)){ return; }
    if(!isFormValidity(formSale)){ return; }

    $(`#btn-create-sale`).prop('disabled', true);
    const seat = $('#numero-asiento').val();
    if(seat == ''){
        $(`#btn-create-sale`).prop('disabled', false);
        $.toast({
            heading: ACTION,
            text: 'Debe seleccionar un asiento',
            icon: 'error',
            loader: true,
            position: 'top-right',
        }); return;
    }
    const requestSale = await createSale([formClient, formSale]);
    if(requestSale.success){

        const type = $('input[type=radio][name="status"]:checked').val();
        if(type == 'RESERVA'){
            setTimeout(() => location.reload(), 2000);
            Swal.fire({
                title: 'RESERVA DE VENTA',
                icon: 'success',
                text: requestSale.message,
                allowOutsideClick: false,
                confirmButtonText: `<i class="fa fa-check"></i> Aceptar`,
              }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        }else if(type == 'VENDIDO'){
            executeBluetoothPrinter(requestSale.data.ticket);
            setTimeout(() => {
                location.reload();
            }, 200);
        }
    }else{
        $(`#btn-create-sale`).prop('disabled', false);
    }
    $.toast({
        heading: ACTION,
        text: requestSale.message,
        icon: requestSale.success ? 'success' : 'error',
        loader: true,
        position: 'top-right',
    });
    console.log(ACTION, requestSale.message);
});

const loadLocations = async (locationId) => {
    const request = await getAllLocations();
    if (request.success) {
      locations = request.data;
      $("#locations").html(htmlLocations(locationId));
    }
};

const htmlLocations = (locationId) => {
    let opt_html = '<option value="0" selected> - Ninguno - </option>';
    locations.forEach(item => {
        if(item.id != locationId){
            opt_html += `<option value="${item.id}">${item.location.toUpperCase()}</option>`
        }
    });
    return opt_html;
};