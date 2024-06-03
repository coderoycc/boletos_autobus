$(document).ready(() => {
  ticket_list();
  load_locations();
})
async function ticket_list() {
  const res = await $.ajax({
    url: '../app/ticket/table_list',
    type: 'GET',
    dataType: 'html',
  });
  $("#list_tickets").html(res);
}
async function load_locations() {
  const res = await $.ajax({
    url: '../app/location/all',
    type: 'GET',
    dataType: 'json',
  });
  if (res.success) {
    locations = res.data;
    $("#floatingSelect").html(html_locations());
  }
}
function html_locations() {
  let opt_html = '<option value="0">TODOS LOS DESTINOS</option>';
  locations.forEach(item => {
    opt_html += `<option value="${item.id}">${item.location.toUpperCase()}</option>`
  });
  return opt_html;
}