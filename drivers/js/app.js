$(document).ready(() => {
  list()
})

/** EVENTS start **/
$(document).on('change', '#distro_type', show_distro_card)
$(document).on('click', '#btn__new_distro', show_card_new_distro)
$(document).on('show.bs.modal', '#driver_delete', show_driver_delete)
/** EVENTS end **/


function show_driver_delete(e) {
  console.log(e.relatedTarget.dataset)
  const id = e.relatedTarget.dataset.id;
  console.log(id)
  $('#driver_id_delete').val(id);
}
async function list() {
  const res = await $.ajax({
    url: '../app/driver/all',
    type: 'GET',
    dataType: 'html'
  })
  $("#data_buses").html(res)
}

const loadFormCreateDriver = async () => {
  const response = await $.ajax({
    url: '../app/driver/card_add_new',
    type: 'GET',
    dataType: 'html'
  });
  $("#driver-data").html(response);
};

const loadFormUpdateDriver = async (driverId) => {
  const response = await $.ajax({
    url: '../app/driver/card_update',
    type: 'POST',
    data: { driver_id: driverId },
    dataType: 'html'
  });
  $("#driver-data").html(response);
};

$('#driver-data-modal').on('show.bs.modal', (e) => {
  const action = e.relatedTarget.dataset.action;
  if(action == 'add'){
    loadFormCreateDriver();
  }else if(action == 'update'){
    loadFormUpdateDriver(
      e.relatedTarget.dataset.id
    );
  }
});

$('#driver-data-modal').on('hide.bs.modal', (e) => {
  $("#driver-data").html('');
});

async function show_distro_card(e) {
  const id = e.target.value;
  if (id == '') return;
  const res = await $.ajax({
    url: '../app/distribution/card_distro_seats',
    type: 'GET',
    data: { id },
    dataType: 'html'
  });
  $("#col__details").html(res)
}
async function show_card_new_distro(e) {

}

const createNewDriver = async () => {
  const form = document.getElementById('data-driver-form');
  if (!isFormValidity(form)) { return; }

  const ACTION = 'CREAR NUEVO CONDUCTOR';
  const request = await createDriver([form]);
  if (request.success) {
    list();
    $('#driver-data-modal').modal('hide');
  }
  $.toast({
    heading: ACTION,
    text: request.message,
    icon: request.success ? 'success' : 'error',
    loader: true,
    position: 'top-right',
  });
  console.log(ACTION, request.message);
};

const updateDataDriver = async () => {
  const form = document.getElementById('data-driver-update-form');
  if (!isFormValidity(form)) { return; }

  const ACTION = 'ACTUALIZAR BUS';
  const request = await updateDriver([form]);
  if (request.success) {
    list();
    $('#driver-data-modal').modal('hide');
  }
  $.toast({
    heading: ACTION,
    text: request.message,
    icon: request.success ? 'success' : 'error',
    loader: true,
    position: 'top-right',
  });
  console.log(ACTION, request.message);
};

async function down_driver() {
  const driver_id = $("#driver_id_delete").val();
  const res = await $.ajax({
    url: '../app/driver/down_driver',
    type: 'POST',
    data: { driver_id },
    dataType: 'json'
  })
  if (res.success) {
    list();
    toast('Operación exitosa', res.message, 'success', 2500)
  } else {
    toast('Operación fallida', res.message, 'error', 3500)
  }
}