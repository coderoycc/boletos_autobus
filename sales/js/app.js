$('input[type=radio][name=filter]').change(function(e) {
    const filter = $('input[name="filter"]:checked').val();
    $(`#ci-cliente`).prop('required', filter == 'ci');
    $(`#nit-cliente`).prop('required', filter == 'nit');
});

$('#select-client-modal').on('show.bs.modal', (e) => {
    //console.log('asdasd');
});

$('#select-client-modal').on('hidden.bs.modal', (e) => {
    clearDataClient();
});

$('#documento-cliente').on('click', (e) => {
    $('#select-client-modal').modal('show');
});

$('#btn-search-client').on('click', async (e) => {
    const ACTION = 'BUSCAR CLIENTE';
    const data = {
        ci: $('#ci-cliente').val(),
        nit: $('#nit-cliente').val(),
    };
    const filter = $('input[name="filter"]:checked').val();
    if(data[filter] == ''){
        $.toast({
            heading: ACTION,
            text: `Ingrese un ${filter.toUpperCase()} válido`,
            icon: 'info',
            loader: true,
            position: 'top-right',
        })
        return;
    }
    const requestClient = filter == 'ci'
            ? await showClientByCi(data.ci) 
            : await showClientByNit(data.nit);
    clearDataClient();
    if(requestClient.success){ 
        loadDataClient(requestClient.data[0]);
    }
    $.toast({
        heading: ACTION,
        text: requestClient.message,
        icon: requestClient.success ? 'success' : 'error',
        loader: true,
        position: 'top-right',
    });
    console.log(ACTION, requestClient.message);
});

$('#btn-create-client').on('click', async (e) => {
    const ACTION = 'CREAR CLIENTE';
    const form = document.getElementById('form-client-data');
    if(!isFormValidity(form)){
        return;
    }
    const requestClient = await createClient([form]);
    if(requestClient){
        const client = requestClient.data.client;
        const filter = $('input[name="filter"]:checked').val();
        $('#documento-cliente').val(client[filter]);
        $('#cliente-selected').val(client.id);
        $('#select-client-modal').modal('hide');
    }
    $.toast({
        heading: ACTION,
        text: requestClient.message,
        icon: requestClient.success ? 'success' : 'error',
        loader: true,
        position: 'top-right',
    });
    console.log(ACTION, requestClient.message);
});

$('#btn-select-client').on('click', (e) => {
    const filter = $('input[name="filter"]:checked').val();
    $('#documento-cliente').val($(`#${filter}-cliente`).val());
    $('#cliente-selected').val($('#id-cliente').val());
    $('#select-client-modal').modal('hide');
});

const loadDataClient = (client) => {
    $('#id-cliente').val(client.id);
    $('#nombre-cliente').val(client.name);
    $('#paterno-cliente').val(client.lastname);
    $('#materno-cliente').val(client.mothers_lastname);
    $('#ci-cliente').val(client.ci);
    $('#nit-cliente').val(client.nit);
    $('#check-menor').prop('checked', client.is_minor == 1);
}

const clearDataClient = () => {
    $('#id-cliente').val('');
    $('#ci-cliente').val('');
    $('#nit-cliente').val('');
    $('#nombre-cliente').val('');
    $('#paterno-cliente').val('');
    $('#materno-cliente').val('');
    $('#check-menor').prop('checked', false);
    $('#radio-ci').click();
}

$('#btn-create-sale').on('click', async (e) => {
    const ACTION = 'REGISTRAR VENTA';
    $(`#btn-create-sale`).prop('disabled', true);
    const form = document.getElementById('sale-data-form');
    if(!isFormValidity(form)){ return; }
    const client = $('#documento-cliente').val();
    const seat = $('#numero-asiento').val();
    const trip = $('#cliente-selected').val();
    if(client == '' || trip == ''){
        $(`#btn-create-sale`).prop('disabled', false);
        $.toast({
            heading: ACTION,
            text: 'Debe seleccionar un cliente registrado.',
            icon: 'error',
            loader: true,
            position: 'top-right',
        }); return;
    }
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
    const requestSale = await createSale([form]);
    if(requestSale.success){
        Swal.fire({
            title: ACTION,
            icon: 'success',
            text: requestSale.message,
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonText: `<i class="fa fa-print"></i> Imprimir`,
            cancelButtonText: `<i class="fa fa-check"></i> Cerrar`,
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                executeBluetoothPrinter(requestSale.data.ticket);
                location.reload();
            } else if (result.isCancel) {
                location.reload();
            };
        });
        //setTimeout(() => , 1500);
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