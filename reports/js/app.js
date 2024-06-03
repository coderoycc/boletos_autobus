var locations = [];
$(document).ready(() => {
  load_locations();
});
/** EVENTS start **/
$(document).on('submit', '#form_params_report', send_report)
/** EVENTS end **/
async function load_locations() {
  const res = await $.ajax({
    url: '../app/location/all',
    type: 'GET',
    dataType: 'json',
  });
  if (res.success) {
    locations = res.data;
    $("#locations").html(html_locations());
  }
}
function html_locations() {
  let opt_html = '<option value="0">TODOS LOS DESTINOS</option>';
  locations.forEach(item => {
    opt_html += `<option value="${item.id}">${item.location.toUpperCase()}</option>`
  });
  return opt_html;
}
async function send_report(e) {
  e.preventDefault();
  const data = $(e.target).serialize();
  window.open(`../reports/pdf/report_sales.php?${data}`, '_blank');
}