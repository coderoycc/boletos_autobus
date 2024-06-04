$(document).ready(() => loadAllClients());
const loadAllClients = async () => {
  const request = await getAllClientsView();
  document.getElementById('data-clients').innerHTML = request;
  $("#table-clients").DataTable({
    language: lenguaje,
    info: false,
    scrollX: true,
    columnDefs: [
      { orderable: false, targets: [1, 7] }
    ],
  })
};
