$(document).ready(async () => {
  await loadLocations();
  await listAllTickets();
});

const listAllTickets = async ( ) => {
  const form = document.getElementById('data-filter-form');
  if(!isFormValidity(form)){ return; }

  $("#list_tickets").html('');
  const request = await getAllTicketsView([form]);
  $("#list_tickets").html(request);
  $("#tickets-table").DataTable({
    language: lenguaje,
    info: false,
    scrollX: true,
  });
  $('.dataTables_filter').hide();
};

const loadLocations = async ( ) => {
  const request = await getAllLocations();
  if (request.success) {
    locations = request.data;
    $("#destination").html(htmlLocations());
  }
};

const htmlLocations = ( ) => {
  let opt_html = '<option value="0" selected> - Seleccionar Todo - </option>';
  locations.forEach(item => {
    opt_html += `<option value="${item.id}">${item.location.toUpperCase()}</option>`
  });
  return opt_html;
};

$('#ticket-detail-modal').on('show.bs.modal', async (e) => {
  const ticket_id = e.relatedTarget.dataset.ticket;
  const request = await getTicketDetailView(ticket_id);
  $('#ticket-detail').html(request);
});

$('#ticket-detail-modal').on('hidden.bs.modal', (e) => {
  $('#ticket-detail').html('');
});

$('#btn-search-filter').on('click', (e) => {
  listAllTickets();
});