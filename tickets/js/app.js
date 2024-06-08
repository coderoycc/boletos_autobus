var trips = [];
$(document).ready(async () => {
  await listAllTickets();
  setTimeout(() => {
    loadTrips();
  }, 1000);
});

const listAllTickets = async () => {
  console.log('adsfasdfsd')
  const form = document.getElementById('data-filter-form');
  console.log(form)
  // if (!isFormValidity(form)) { return; }

  $("#list_tickets").html(`<div class="w-100 d-flex justify-content-center"><div class="spinner-border text-primary" role="status">
    <span class= "visually-hidden" > Cargando...</span >
  </div></div>`);

  const request = await getAllTicketsView([form]);
  $("#list_tickets").html(request);
  $("#tickets-table").DataTable({
    language: lenguaje,
    info: false,
    scrollX: true,
  });
  $('.dataTables_filter').hide();
};

const loadTrips = async () => {
  const request = await getTrips();
  if (request.success) {
    trips = request.data;
    $("#trip_id").html(htmlTrips());
  }
};
$(document).on('change', '#trip_id', (e) => {
  const driver = e.target.selectedOptions[0].dataset.driver || '';
  const placa = e.target.selectedOptions[0].dataset.placa || '';
  console.log(driver, placa);
  $("#driver_detail").val(driver + ' - ' + placa);
  listAllTickets();
})
const htmlTrips = () => {
  const sel_trip = $("#current_trip_id").val() || '0'
  let opt_html = '';
  // let opt_html = '<option value="0" selected> - Seleccionar Todo - </option>';
  trips.forEach(item => {
    let date = item.departure_date.split('-');
    let time = item.departure_time.split(':');
    opt_html += `<option data-driver="${item.conductor}" data-placa="${item.placa}" value="${item.id}" ${sel_trip == item.id ? 'selected' : ''}>${date[2] + '/' + date[1]} ${time[0] + ':' + time[1]} | ${item.destino}</option>`
  });
  return opt_html;
};

$('#ticket-detail-modal').on('show.bs.modal', async (e) => {
  const ticketId = e.relatedTarget.dataset.ticket;
  const request = await getTicketDetailView(ticketId);
  $('#ticket-detail').html(request);
});

$('#ticket-detail-modal').on('hidden.bs.modal', (e) => {
  $('#ticket-detail').html('');
});

$('#btn-search-filter').on('click', (e) => {
  listAllTickets();
});

$('#ticket-delete-modal').on('show.bs.modal', async (e) => {
  const ticketId = e.relatedTarget.dataset.ticket;
  document.getElementById('ticket-id-delete').value = ticketId;
});

$('#ticket-delete-modal').on('hide.bs.modal', async (e) => {
  $('#ticket-password-confirm').val('');
  $('#ticket-id-delete').val('');
});

$('#btn-delete-ticket').on('click', async () => {
  const ACTION = 'ELIMINAR BOLETO';
  const form = document.getElementById('delete-ticket-form');
  const btnDelete = document.getElementById('btn-delete-ticket');
  btnDelete.disabled = true;
  if (isFormValidity(form)) {
    const request = await deleteSoldTicket([form]);
    console.log(request);
    if (request.success) {
      location.reload();
    }
    toast(ACTION, request.message, request.success ? 'success' : 'error');
    console.log(ACTION, request.message);
  }
  btnDelete.disabled = false;
});