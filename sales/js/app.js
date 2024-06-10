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
        /*Swal.fire({
            title: ACTION,
            icon: 'success',
            text: requestSale.message,
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonText: `<i class="fa fa-print"></i> Imprimir`,
            cancelButtonText: `<i class="fa fa-check"></i> Cerrar`,
          }).then((result) => {
            if (result.isConfirmed) {
                
            } else if (result.isCancel) {
                
            };
            location.reload();
        });*/
        executeBluetoothPrinter(requestSale.data.ticket);
        setTimeout(() => {
            location.reload();
        }, 200);
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
    console.log(locationId);
    const request = await getAllLocations();
    console.log(request);
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