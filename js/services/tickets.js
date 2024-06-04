/**
 * Crear un nuevo cliente
 */
const createSale = async (form) => {
    const URL = `../app/ticket/create`;
    const params = convertFormToURLSearchParams(form);
    const request = await fetch(URL, requestOptionsPost(params));
    return (await validateResponse(request));
};
/**
 * Obtener los asientos vendidos
 */
const getReservedSeats = async (trip_id) => {
    const URL = `../app/ticket/reservedSeats?trip_id=${trip_id}`;
    const request = await fetch(URL, requestOptionsGet( ));
    return (await validateResponse(request));
};