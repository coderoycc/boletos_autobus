/**
 * Crear un nuevo bus
 */
const createBus = async (form) => {
    const URL = `../app/bus/create`;
    const params = convertFormToURLSearchParams(form);
    const request = await fetch(URL, requestOptionsPost(params));
    return (await validateResponse(request));
};
/**
 * Actualizar Datos del bus
 */
const updateBus = async (form) => {
    const URL = `../app/bus/update`;
    const params = convertFormToURLSearchParams(form);
    const request = await fetch(URL, requestOptionsPost(params));
    return (await validateResponse(request));
};