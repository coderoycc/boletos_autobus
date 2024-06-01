var firstSeatLabel = 1;
var selectedID = null;
		
$(document).ready(async function() {

    const seatsRequest = await getDistributions();
    
    if(!seatsRequest.success){
        console.log(seatsRequest.message);
        return;
    }

    const floor1 = seatsRequest.data.floor2;
    const reserved = seatsRequest.data.reserved;
    const mapFloor = mapSeats(floor1);
    const unavailable = unavailableSeats(floor1, reserved);

    var $cart = $('#selected-seats'),
        $counter = $('#counter'),
        $total = $('#total'),
        sc = $('#seat-map').seatCharts({
        map: mapFloor,
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

                //let's create a new <li> which we'll add to the cart items
                $('<li>'+this.data().category+' Seat # '+this.settings.label+': <b>$'+this.data().price+'</b> <a href="#" class="cancel-cart-item">[cancel]</a></li>')
                    .attr('id', 'cart-item-'+this.settings.id)
                    .data('seatId', this.settings.id)
                    .appendTo($cart);
                
                /*
                    * Lets update the counter and total
                    *
                    * .find function will not find the current seat, because it will change its stauts only after return
                    * 'selected'. This is why we have to add 1 to the length and the current seat price to the total.
                    */
                $counter.text(sc.find('selected').length+1);
                $total.text(recalculateTotal(sc)+this.data().price);
                
                return 'selected';
            } else if (this.status() == 'selected') {
                resetSelected();
                //update the counter
                $counter.text(sc.find('selected').length-1);
                //and total
                $total.text(recalculateTotal(sc)-this.data().price);
            
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

    //this will handle "[cancel]" link clicks
    $('#selected-seats').on('click', '.cancel-cart-item', function () {
        //let's just trigger Click event on the appropriate seat, so we don't have to repeat the logic here
        sc.get($(this).parents('li:first').data('seatId')).click();
    });

    //let's pretend some seats have already been booked
    //sc.get(['1_2', '4_1', '7_1', '7_2']).status('unavailable');
    sc.get(unavailable).status('unavailable');

    $('#button-update-seats').on('click', async function() {
        const requestUpdateSeats = await getReservedSeats();
        if(requestUpdateSeats.success){
            resetSelected();
            const unavailable = unavailableSeats(floor1, requestUpdateSeats.data.reserved)
            sc.get(unavailable).status('unavailable');
        }
    });

    const tripId = getParam(window.location, 'trip_id');
    const cardRequest = await getCardTripData(tripId);
    $('#trip-data').html(cardRequest);
    $('#precio-asiento').val(parseFloat(seatsRequest.data.trip.base_price));
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
        const seat = document.getElementById(selectedID);
        selectedID = null;
        seat.click();
    }
}