/**
 * Obtener la distribucion de asientos en el bus
 */
const getReservedSeats = async ( ) => {
    const URL = `../reserved.php`;
    const request = await fetch(URL, requestOptionsGet());
    return (await validateResponse(request));
};
/**
 * Obtener datos del viaje
 */
const getCardTripData = async (trip_id) => {
    const URL = `../app/trip/cardData?id=${trip_id}`;
    const request = await fetch(URL, requestOptionsGet());
    return (await request.text());
};