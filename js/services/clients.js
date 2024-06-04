/**
 * Obtener datos del cliente por CI
 */
const showClientByCi = async (ci) => {
    const URL = `../app/client/showByCi?ci=${ci}`;
    const request = await fetch(URL, requestOptionsGet());
    return (await validateResponse(request));
};
/**
 * Obtener datos del cliente por NIT
 */
const showClientByNit = async (nit) => {
    const URL = `../app/client/showByNit?nit=${nit}`;
    const request = await fetch(URL, requestOptionsGet());
    return (await validateResponse(request));
};
/**
 * Crear un nuevo cliente
 */
const createClient = async (form) => {
    const URL = `../app/client/create`;
    const params = convertFormToURLSearchParams(form);
    const request = await fetch(URL, requestOptionsPost(params));
    return (await validateResponse(request));
};
/**
 * Obtener listado de clientes registrados
 */
const getAllClientsView = async ( ) => {
    const URL = `../app/client/getAllClientsView`;
    const request = await fetch(URL, requestOptionsGet( ));
    return (await request.text());
};