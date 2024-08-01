var trips = [];
$(document).ready(async () => {
  setTimeout(() => {
    loadTrips().then(() => {
      // listAllTickets();
      actualizarDatosViaje();
    });
  }, 1000);
});

const listAllTickets = async () => {
  const form = document.getElementById("data-filter-form");
  $("#list_tickets")
    .html(`<div class="w-100 d-flex justify-content-center"><div class="spinner-border text-primary" role="status">
    <span class= "visually-hidden" > Cargando...</span >
  </div></div>`);
  const request = await getAllTicketsView([form]);
  $("#list_tickets").html(request);
  $("#tickets-table").DataTable({
    order: [[1, "desc"]],
    language: lenguaje,
    info: false,
    scrollX: true,
  });
  $(".dataTables_filter").hide();
};

const loadTrips = async () => {
  const request = await getTrips();
  if (request.success) {
    trips = request.data;
    $("#trip_id").html(htmlTrips());
  }
};
$(document).on("change", "#trip_id", (e) => {
  actualizarDatosViaje();
});
function actualizarDatosViaje() {
  const selectedOption = document.querySelector("#trip_id").selectedOptions[0];
  if (selectedOption) {
    const driver = selectedOption.dataset.driver || "";
    const placa = selectedOption.dataset.placa || "";
    console.log(driver, placa);
    $("#driver_detail").val(driver + " - " + placa);
    listAllTickets();
  }
}
const htmlTrips = () => {
  const sel_trip = $("#current_trip_id").val() || "0";
  let opt_html = "";
  // let opt_html = '<option value="0" selected> - Seleccionar Todo - </option>';
  let primerElemento = true;
  trips.forEach((item) => {
    let date = item.departure_date.split("-");
    let time = item.departure_time.split(":");
    opt_html += `<option data-driver="${item.conductor}" data-placa="${
      item.placa
    }" value="${item.id}" ${primerElemento ? "selected" : ""}>${
      date[2] + "/" + date[1]
    } ${time[0] + ":" + time[1]} | ${item.destino}</option>`;
    primerElemento = false;
  });
  return opt_html;
};

$("#ticket-detail-modal").on("show.bs.modal", async (e) => {
  const client_id = e.relatedTarget.dataset.id;
  const request = await getTicketDetailView(client_id);
  $("#ticket-detail").html(request);
});

$("#ticket-detail-modal").on("hidden.bs.modal", (e) => {
  $("#ticket-detail").html("");
});

$("#ticket-consolidate-modal").on("show.bs.modal", async (e) => {
  const data = e.relatedTarget.dataset;
  let arraySeat = data.seat.split("-");
  let numberSeat = arraySeat.length;
  let soldPrice = (data.soldPrice * numberSeat).toFixed(2);
  $("#labelPrecioPagar").text("Precio a Pagar (" + numberSeat + " asientos)")
  $("#txt-client").text(data.client);
  $("#txt-advance").text(soldPrice);
  $("#txt-seat").text(data.seat);
  $("#client-id").val(data.id);
  $("#ticket-consolidate-price").val(numberSeat * data.price - soldPrice);
  $("#ticket-consolidate-price").prop("min", numberSeat * data.minPrice - soldPrice);
});

$("#ticket-consolidate-modal").on("hidden.bs.modal", (e) => {
  $("#txt-client").text("");
  $("#txt-advance").text("");
  $("#txt-seat").text("");
  $("#ticket-id").val("");
  $("#ticket-consolidate-price").prop("min", 0);
});

$("#btn-search-filter").on("click", (e) => {
  listAllTickets();
});

$("#ticket-delete-modal").on("show.bs.modal", async (e) => {
  const client_id = e.relatedTarget.dataset.id;
  document.getElementById("ticket-id-delete").value = client_id;
});

$("#ticket-delete-modal").on("hide.bs.modal", async (e) => {
  $("#ticket-password-confirm").val("");
  $("#ticket-id-delete").val("");
});

$("#btn-delete-ticket").on("click", async () => {
  const ACTION = "ELIMINAR BOLETO";
  const form = document.getElementById("delete-ticket-form");
  const btnDelete = document.getElementById("btn-delete-ticket");
  btnDelete.disabled = true;
  if (isFormValidity(form)) {
    const request = await deleteSoldTicket([form]);
    if (request.success) {
      location.reload();
    }
    toast(ACTION, request.message, request.success ? "success" : "error");
    console.log(ACTION, request.message);
  }
  btnDelete.disabled = false;
});

$("#btn-consolidate-ticket").on("click", async (e) => {
  const ACTION = "CONSOLIDAR VENTA";
  const btnConsolidate = document.getElementById("btn-consolidate-ticket");
  const form = document.getElementById("consolidate-ticket-form");
  btnConsolidate.disabled = true;
  let consolidatePrice = $("#ticket-consolidate-price").val();
  let txtSeat = $("#txt-seat").text();
  let arrayTxtSeat = txtSeat.split('-');
  let numberSeats = arrayTxtSeat.length;
  let consolidatePriceDiv = (consolidatePrice / numberSeats).toFixed(3);
  $("#ticket-consolidate-price-divided").val(consolidatePriceDiv);
  if (isFormValidity(form)) {
    const request = await consolidateSale([form]);
    if (request.success) {
      executeBluetoothPrinter(request.data.ticket);
      setTimeout(() => {
          location.reload();
      }, 200);
      setTimeout(() => location.reload(), 1000);
    }
    toast(ACTION, request.message, request.success ? "success" : "error");
    console.log(ACTION, request.message);
  }
  btnConsolidate.disabled = false;
});
