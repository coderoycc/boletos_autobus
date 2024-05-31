var locations = [];
$(document).ready(() => {
  list_data()
  load_locations();
  load_buses();
});

$(document).on('show.bs.modal', "#depa_edit", open_modal_edit)
$(document).on('show.bs.modal', '#depa_delete', open_modal_delete)
$(document).on('change', '#add_trip_origen', destination_values)

async function list_data() {
  const res = await $.ajax({
    url: '../app/trips/all',
    type: 'GET',
    dataType: 'html',
  });
  $("#content_department").html(res)
  $("#table_departments").DataTable({
    language: lenguaje,
    info: false,
    scrollX: true,
    columnDefs: [
      // { orderable: false, targets: [5, 7] }
    ],
  })
}
function open_modal_delete(e) {
  const id = e.relatedTarget.dataset.id
  $("#id_depa_delete").val(id)
}
async function delete_department() {
  const id = $("#id_depa_delete").val()
  const res = await $.ajax({
    url: `../app/department/delete`,
    type: 'DELETE',
    data: { id },
    dataType: 'json',
  });
  if (res.success) {
    toast('Operación exitosa', 'Departamento eliminado', 'success', 2000)
    setTimeout(() => {
      location.reload()
    }, 2100);
  } else {
    toast('Ocurrió un error', res.message, 'error', 3000)
  }
}
async function open_modal_edit(e) {
  const id = e.relatedTarget.dataset.id
  const res = await $.ajax({
    url: `../app/department/content_edit`,
    type: 'GET',
    data: { id },
    dataType: 'html',
  });
  $("#modal_content_edit").html(res);
}
async function update_department() {
  const data = $("#form_update_department").serializeArray();
  const res = await $.ajax({
    url: `../app/department/update`,
    type: 'PUT',
    data,
    dataType: 'json',
  });
  if (res.success) {
    toast('Operación exitosa', 'Departamento actualizado', 'success', 2000)
    setTimeout(() => {
      location.reload()
    }, 2100);
  } else toast('Ocurrió un error', res.message, 'error', 3000)
}

async function add_trip() {
  const data = $("#form_add_trip").serializeArray();
  console.log(data)
  const res = await $.ajax({
    url: `../app/trip/create`,
    type: 'POST',
    data,
    dataType: 'json',
  });
  if (res.success) {
    toast('Operación exitosa', 'Viaje creado', 'success', 2000)
    setTimeout(() => {
      location.reload()
    }, 2100);
  } else
    toast('Ocurrió un error', res.message, 'error', 3000)
}
async function load_locations() {
  const res = await $.ajax({
    url: '../app/location/all',
    type: 'GET',
    dataType: 'json',
  });
  if (res.success) {
    locations = res.data;
    $("#add_trip_origen").html(html_locations(true));
  }
}
function destination_values(e) {
  $("#add_trip_destination").html(html_locations())
}
function html_locations(origen = false) {
  let opt_html = '<option value="">SELECCIONE</option>';
  if (origen) {
    locations.forEach(item => {
      opt_html += `<option value="${item.id}">${item.location.toUpperCase()}</option>`
    });
  } else {
    const curr_id = $("#add_trip_origen").val();
    locations.forEach(item => {
      if (item.id != curr_id)
        opt_html += `<option value="${item.id}">${item.location.toUpperCase()}</option>`
    });
  }
  return opt_html;
}
function html_buses(buses) {
  let html = '';
  buses.forEach((item) => {
    html += `<option value="${item.id}">${item.placa.toUpperCase()} <span class="float-end">${item.description.substring(0, 10)}</span></option>`
  })
  return html;
}
async function load_buses() {
  const res = await $.ajax({
    url: '../app/bus/list_all',
    type: 'GET',
    dataType: 'json',
  });
  if (res.success) {
    $("#buses_selected").html(html_buses(res.data));
  }
}