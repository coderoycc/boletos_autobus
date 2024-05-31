$(document).ready(() => {
  list();
})
async function add_new() {
  const data = $("#form_add_location").serializeArray();
  const res = await $.ajax({
    url: '../app/location/create',
    data,
    dataType: 'json',
    type: 'POST'
  });
  if (res.success) {
    toast('Operación exitosa', 'Destino agregado', 'success', 2100);
    setTimeout(() => {
      location.reload()
    }, 2190);
  } else {
    toast('Fallo en operación', 'No se agregó en destino', 'danger', 2600);
  }
}
async function list() {
  const res = await $.ajax({
    url: '../app/location/list',
    dataType: 'html',
    type: 'GET'
  });
  $('#data_location').html(res);
}