var firstSeatLabel = 1;
var selectedID = null;
var typeSeat = 'upper';
		
$(document).ready(async function() {

    const tripId = getParam(window.location, 'trip_id');
    $('#trip-id').val(tripId);
    
    const requestDataDistributions = await getDataDistributions(tripId);
    
    if(!requestDataDistributions.success){
        console.log(requestDataDistributions.message);
        return;
    }

    $('#precio-asiento').prop('min', requestDataDistributions.data.trip.min_price);

    const floor1 = requestDataDistributions.data.floor1;
    
    const reserved = requestDataDistributions.data.reserved;
    const mapFloorUpper = mapSeats(floor1);
    const unavailable = unavailableSeats(floor1, reserved);

    var sc = $('#seat-map-upper').seatCharts({
        map: mapFloorUpper,
        seats: {
            f: {
                price   : 100,
                classes : 'first-class', //your custom CSS class
                category: 'First Class'
            },
            e: {
                price   : 40,
                classes : 'economy-class', //your custom CSS class
                category: 'Economy Class'
            }					
        
        },
        naming : {
            top : false,
            left: false,
            getLabel : function (character, row, column) {
                return floor1[row - 1][column - 1];
            },
        },
        legend : {
            node : $('#legend'),
            items : [
                [ 'f', 'available',   'First Class' ],
                [ 'e', 'available',   'Economy Class'],
                [ 'f', 'unavailable', 'Already Booked']
            ]					
        },
        click: function () {
            if (this.status() == 'available') {
                resetSelected();
                const id = this.settings.id;
                selectedID = id;
                const label = this.settings.label;
                $('#numero-asiento').val(label);
                $('#documento-cliente').click( );
                $('#documento-cliente').focus( );
                return 'selected';
            } else if (this.status() == 'selected') {
                resetSelected();
                //remove the item from our cart
                $('#cart-item-'+this.settings.id).remove();
                //seat has been vacated
                return 'available';
            } else if (this.status() == 'unavailable') {
                //seat has been already booked
                return 'unavailable';
            } else {
                return this.style();
            }
        }
    });

    //let's pretend some seats have already been booked
    //sc.get(['1_2', '4_1', '7_1', '7_2']).status('unavailable');
    sc.get(unavailable).status('unavailable');
    /**
     * PISO 2
     * */
    const floor2 = requestDataDistributions.data.floor2;
    if(floor2.length > 0){
        const mapFloorLower = mapSeats(floor2);
        const unavailableLower = unavailableSeats(floor2, reserved);
        var sc_lower = $('#seat-map-lower').seatCharts({
            map: mapFloorLower,
            seats: {
                f: {
                    price   : 100,
                    classes : 'first-class', //your custom CSS class
                    category: 'First Class'
                },
                e: {
                    price   : 40,
                    classes : 'economy-class', //your custom CSS class
                    category: 'Economy Class'
                }					
            
            },
            naming : {
                top : false,
                left: false,
                getLabel : function (character, row, column) {
                    return floor2[row - 1][column - 1];
                },
            },
            legend : {
                node : $('#legend'),
                items : [
                    [ 'f', 'available',   'First Class' ],
                    [ 'e', 'available',   'Economy Class'],
                    [ 'f', 'unavailable', 'Already Booked']
                ]					
            },
            click: function () {
                if (this.status() == 'available') {
                    resetSelected();
                    const id = this.settings.id;
                    selectedID = id;
                    const label = this.settings.label;
                    $('#numero-asiento').val(label);
                    $('#documento-cliente').click( );
                    $('#documento-cliente').focus( );
                    return 'selected';
                } else if (this.status() == 'selected') {
                    resetSelected();
                    //remove the item from our cart
                    $('#cart-item-'+this.settings.id).remove();
                    //seat has been vacated
                    return 'available';
                } else if (this.status() == 'unavailable') {
                    //seat has been already booked
                    return 'unavailable';
                } else {
                    return this.style();
                }
            }
        });
        sc_lower.get(unavailableLower).status('unavailable');
    }
    /**
     * ACTUALIZAR DISPONIBILIDAD DE ASIENTOS
     */
    $('#button-update-seats').on('click', async function() {
        const ACTION = 'ACTUALIZAR ASIENTOS';
        const requestUpdateSeats = await getReservedSeats(tripId);
        if(requestUpdateSeats.success){
            resetSelected();
            const unavailable = unavailableSeats(floor1, requestUpdateSeats.data.reserved);
            sc.get(unavailable).status('unavailable');
            const unavailableLower = unavailableSeats(floor2, requestUpdateSeats.data.reserved);
            sc_lower.get(unavailableLower).status('unavailable');
        }
        $.toast({
            heading: ACTION,
            text: requestUpdateSeats.message,
            icon: requestUpdateSeats.success ? 'success' : 'error',
            loader: true,
            position: 'top-right',
        });
    });
    /**
     * DATOS DEL VIAJE
     */
    const cardRequest = await getCardTripData(tripId);
    $('#trip-data').html(cardRequest);
    $('#precio-asiento').val(parseFloat(requestDataDistributions.data.trip.price));
});

function recalculateTotal(sc) {
    var total = 0;

    //basically find every selected seat and sum its price
    sc.find('selected').each(function () {
        total += this.data().price;
    });
    
    return total;
}

const mapSeats = (floor) => {
    let map = [];
    floor.forEach((row) => {
        mapRow = '';
        row.forEach((column) => {
            mapRow += (column != null && column != 'P' && column != 'T') ? 'e' : '_';
        });
        map.push(mapRow);
    });
    return map;
}

const unavailableSeats = (floor, reserved) => {
    let unavailable = [];
    floor.forEach((row, indexRow) => {
        row.forEach((column, indexColumn) => {
            if(reserved.includes(column)){
                unavailable.push((indexRow + 1) + '_' + (indexColumn + 1));
            }
        });
    });
    return unavailable;
}
		
const resetSelected = () => {
    if(selectedID != null && selectedID != ''){
        document.getElementById('numero-asiento').value = '';
        const seat = $(`#container-${typeSeat}-floor`).find(`#${selectedID}`);
        selectedID = null;
        seat.click();
    }
}

$('input[type=radio][name="options-floor"]').change((e) => {
    resetSelected();
    const value = e.currentTarget.value;
    typeSeat = value;
    if(value == 'upper'){
        $(`#container-upper-floor`).show();
        $(`#container-lower-floor`).hide();
    }else{
        $(`#container-upper-floor`).hide();
        $(`#container-lower-floor`).show();
    }
});