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

$('#btn-delete-ticket').on('click', async ( ) => {
  const ACTION = 'ELIMINAR BOLETO';
  const form = document.getElementById('delete-ticket-form');
  const btnDelete = document.getElementById('btn-delete-ticket');
  btnDelete.disabled = true;
  if(isFormValidity(form)){
    const request = await deleteSoldTicket([form]);
    console.log(request);
    if(request.success){
      location.reload();
    }
    toast(ACTION, request.message, request.success ? 'success' : 'error');
    console.log(ACTION, request.message);
  }
  btnDelete.disabled = false;
});