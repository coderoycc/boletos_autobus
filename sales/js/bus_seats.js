var firstSeatLabel = 1;
var selectedID = null;
var typeSeat = "upper";
var seats_selected = new Map();
var seatData = {
  id: 0,
  seat_number: "0",
  trip_id: "0",
  owner_name: "",
  created_at: "",
  price: 0.0,
};

$(document).ready(async function () {
  const tripId = getParam(window.location, "trip_id");
  $("#trip-id").val(tripId);

  const requestDataDistributions = await getDataDistributions(tripId);

  if (!requestDataDistributions.success) {
    console.log(requestDataDistributions.message);
    return;
  }
  loadLocations(requestDataDistributions.data.trip.location_id_dest);
  $("#precio-asiento").prop(
    "min",
    requestDataDistributions.data.trip.min_price
  );

  const floor1 = requestDataDistributions.data.floor1;

  const sold = requestDataDistributions.data.sold;
  const reserved = requestDataDistributions.data.reserved;
  const mapFloorUpper = mapSeats(floor1);
  const unavailable = unavailableSeats(floor1, reserved);
  const solds = unavailableSeats(floor1, sold);

  var sc = $("#seat-map-upper").seatCharts({
    map: mapFloorUpper,
    seats: {
      f: {
        price: 100,
        classes: "bg-info", //your custom CSS class
        category: "First Class",
      },
      e: {
        price: 40,
        classes: "economy-class", //your custom CSS class
        category: "Economy Class",
      },
    },
    naming: {
      top: false,
      left: false,
      getLabel: function (character, row, column) {
        return floor1[row - 1][column - 1];
      },
    },
    legend: {
      node: $("#legend"),
      items: [
        ["f", "available", "First Class"],
        ["e", "available", "Economy Class"],
        ["f", "unavailable", "Already Booked"],
      ],
    },
    click: function () {
      if (this.status() == "available") {
        resetSelected();
        const label = this.settings.label;
        seats_selected.set(label, "SELECTED");
        seatsRecalculate();
        generateInputHtml(label);
        return "selected";
      } else if (this.status() == "selected") {
        resetSelected();
        const label = this.settings.label;
        seats_selected.delete(label);
        $("#cart-item-" + this.settings.id).remove();
        seatsRecalculate();
        deleteInputHtml(label);
        return "available";
      } else if (
        this.status() == "unavailable" ||
        this.status() == "reserved"
      ) {
        showTooltip(this.settings.label, this.settings.id);
        return this.status();
      } else {
        return this.style();
      }
    },
  });

  //let's pretend some seats have already been booked
  //sc.get(['1_2', '4_1', '7_1', '7_2']).status('unavailable');

  sc.get(unavailable).status("reserved");
  sc.get(solds).status("unavailable");
  /**
   * PISO 2
   * */
  const floor2 = requestDataDistributions.data.floor2;
  if (floor2.length > 0) {
    const mapFloorLower = mapSeats(floor2);
    const unavailableLower = unavailableSeats(floor2, reserved);
    const soldsLower = unavailableSeats(floor2, sold);
    var sc_lower = $("#seat-map-lower").seatCharts({
      map: mapFloorLower,
      seats: {
        f: {
          //
          price: 100,
          classes: "bg-custom", //your custom CSS class
          category: "First Class",
        },
        e: {
          // libre
          price: 40,
          classes: "economy-class", //your custom CSS class
          category: "Economy Class",
        },
      },
      naming: {
        top: false,
        left: false,
        getLabel: function (character, row, column) {
          return floor2[row - 1][column - 1];
        },
      },
      legend: {
        node: $("#legend"),
        items: [
          ["f", "available", "First Class"],
          ["e", "available", "Economy Class"],
          ["f", "unavailable", "Already Booked"],
        ],
      },
      click: function () {
        if (this.status() == "available") {
          resetSelected();
          const label = this.settings.label;
          seats_selected.set(label, "SELECTED");
          seatsRecalculate();
          generateInputHtml(label);
          return "selected";
        } else if (this.status() == "selected") {
          resetSelected();
          const label = this.settings.label;
          seats_selected.delete(label);
          $("#cart-item-" + this.settings.id).remove();
          seatsRecalculate();
          deleteInputHtml(label);
          return "available";
        } else if (
          this.status() == "unavailable" ||
          this.status() == "reserved"
        ) {
          showTooltip(this.settings.label, this.settings.id);
          return this.status();
        } else {
          return this.style();
        }
      },
    });
    sc_lower.get(unavailableLower).status("reserved");
    sc_lower.get(soldsLower).status("unavailable");
  }
  /**
   * ACTUALIZAR DISPONIBILIDAD DE ASIENTOS
   */
  $("#button-update-seats").on("click", async function () {
    const ACTION = "ACTUALIZAR ASIENTOS";
    const requestUpdateSeats = await getReservedSeats(tripId);
    if (requestUpdateSeats.success) {
      resetSelected();
      const unavailable = unavailableSeats(
        floor1,
        requestUpdateSeats.data.reserved
      );
      sc.get(unavailable).status("unavailable");
      const unavailableLower = unavailableSeats(
        floor2,
        requestUpdateSeats.data.reserved
      );
      sc_lower.get(unavailableLower).status("unavailable");
    }
    toast(
      ACTION,
      requestUpdateSeats.message,
      requestUpdateSeats.success ? "success" : "error"
    );
  });
  /**
   * DATOS DEL VIAJE
   */
  const cardRequest = await getCardTripData(tripId);
  $("#trip-data").html(cardRequest);
  $("#precio-asiento").val(
    parseFloat(requestDataDistributions.data.trip.price)
  );
  /**
   * CONFIGURACION DE DATOS DEL VIAJE
   */
  $('input[type=radio][name="status"]').change((e) => {
    const value = e.target.value;
    if (value == "VENDIDO") {
      $("#precio-asiento").prop(
        "min",
        requestDataDistributions.data.trip.min_price
      );
      $("#precio-asiento").prop("required", true);
      $("#precio-asiento").val(
        parseFloat(requestDataDistributions.data.trip.price)
      );
    } else if (value == "RESERVA") {
      $("#precio-asiento").prop("min", 0);
      $("#precio-asiento").prop("required", false);
      $("#precio-asiento").val(0);
    }
  });
});
$(document).on("keyup", "#precio-asiento", seatsRecalculate);
const mapSeats = (floor) => {
  let map = [];
  floor.forEach((row) => {
    mapRow = "";
    row.forEach((column) => {
      mapRow += column != null && column != "P" && column != "T" ? "e" : "_";
    });
    map.push(mapRow);
  });
  return map;
};

const unavailableSeats = (floor, arr_seats) => {
  let unavailable = [];
  floor.forEach((row, indexRow) => {
    row.forEach((column, indexColumn) => {
      if (arr_seats.includes(column)) {
        unavailable.push(indexRow + 1 + "_" + (indexColumn + 1));
      }
    });
  });
  return unavailable;
};

const resetSelected = () => {
  if (selectedID != null && selectedID != "") {
    document.getElementById("numero-asiento").value = "";
    const seat = $(`#container-${typeSeat}-floor`).find(`#${selectedID}`);
    selectedID = null;
    seat.click();
  }
};

function seatsRecalculate() {
  const value =
    $("#precio-asiento").val() == "" ? 0 : $("#precio-asiento").val();
  const precio = parseFloat(value);
  const cantidad = seats_selected.size;
  const total = cantidad * precio;
  $("#total_amount").html(total.toFixed(2));
  showSeats();
}
function showSeats() {
  const seats = Array.from(seats_selected.keys()).join("-");
  $("#numero-asiento").val(seats);
}

$('input[type=radio][name="options-floor"]').change((e) => {
  resetSelected();
  const value = e.currentTarget.value;
  typeSeat = value;
  if (value == "upper") {
    $(`#container-upper-floor`).show();
    $(`#container-lower-floor`).hide();
  } else {
    $(`#container-upper-floor`).hide();
    $(`#container-lower-floor`).show();
  }
});
function generateInputHtml(seatNumber) {
  let html = `
  <div id="i_seat_${seatNumber}">
    <div class="text-secondary fw-bold">
    <span>Asiento Nro. ${seatNumber}</span>
    </div>
    <div class="form-label text-secondary fw-semibold d-flex justify-content-between">
      <span>Nombre</span>
      <span>CI/PPT</span>
      <span>¿Menor?</span>
    </div>
    <div class="mb-3">
    <div class="input-group">
      <input type="hidden" name="seat_number[]" value="${seatNumber}">
      <input type="text" class="form-control" name="name_passenger[${seatNumber}]" placeholder="Nombre" >
      <input type="text" class="form-control" name="ci_passenger[${seatNumber}]" placeholder="Cédula de indentidad/pasaporte" >
      <div class="input-group-text">
        <input class="form-check-input mt-0" type="checkbox" name="minor[${seatNumber}]">
      </div>
    </div>
    </div>
  </div>`;
  $("#passenger_inputs").append(html);
}
function deleteInputHtml(seatNumber) {
  $(`#i_seat_${seatNumber}`).remove();
}
async function showTooltip(seatNumber, id) {
  if (seatData.seat_number != seatNumber)
    seatData = await getDataTicket(seatNumber);
  const fecha = new Date(seatData.created_at);
  var fechaFormateada =
    ("0" + fecha.getDate()).slice(-2) +
    "/" +
    ("0" + (fecha.getMonth() + 1)).slice(-2) +
    "/" +
    fecha.getFullYear() +
    " " +
    ("0" + fecha.getHours()).slice(-2) +
    ":" +
    ("0" + fecha.getMinutes()).slice(-2);
  const bgColor = seatData.status == "RESERVA" ? "#0d6efd" : "#444444";
  $.toast({
    text: [
      `<h6>${seatData.client.toUpperCase()} (${seatData.owner_name.toUpperCase()})</h6>`,
      `<h6>${fechaFormateada}</h6>`,
      `<h6>Bs. ${seatData.price.toFixed(2)}</h6>`,
    ],
    heading: `<h5>Asiento ${seatNumber} <b>${seatData.status}</b></h5><hr>`,
    showHideTransition: "fade",
    allowToastClose: true,
    hideAfter: 5000,
    bgColor,
    textColor: "#eeeeee",
    stack: false,
    position: "mid-center",
    loader: true,
    loaderBg: "#9EC600",
  });
}
async function getDataTicket(seat_number) {
  const trip_id = getParam(window.location, "trip_id");
  const res = await $.ajax({
    url: `../app/ticket/get_data_ticket`,
    data: { seat_number, trip_id },
    type: "GET",
    dataType: "JSON",
  });
  return res.data[0];
}
