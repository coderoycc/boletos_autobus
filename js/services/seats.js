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
const getCardTripData = async (params,level = '.') => {
    const URL = `${level}/components/trip_data_view.php`;
    const request = await fetch(URL, requestOptionsPost(params));
    return (await request.text());
};