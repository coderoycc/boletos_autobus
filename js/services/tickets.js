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
/**
 * Obtener detalles de la venta
 */
const getTicketDetailView = async (ticket_id) => {
    const URL = `../app/ticket/ticketDetail?ticket_id=${ticket_id}`;
    const request = await fetch(URL, requestOptionsGet( ));
    return (await request.text());
};
/**
 * Obtener detalles de la venta
 */
const getAllTicketsView = async (form) => {
    const URL = `../app/ticket/getAllTicketsView`;
    const params = convertFormToURLSearchParams(form);
    const request = await fetch(URL, requestOptionsPost(params));
    return (await request.text());
};
/**
 * Eliminar boleto vendido
 */
const deleteSoldTicket = async (form) => {
    const URL = `../app/ticket/deleteSoldTicket`;
    const params = convertFormToURLSearchParams(form);
    const request = await fetch(URL, requestOptionsPost(params));
    return (await validateResponse(request));
};
/**
 * Consolidar venta de boleto reservado
 */
const consolidateSale = async (form) => {
    const URL = `../app/ticket/consolidateSale`;
    const params = convertFormToURLSearchParams(form);
    const request = await fetch(URL, requestOptionsPost(params));
    return (await validateResponse(request));
};