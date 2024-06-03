/**
 * Crear un nuevo cliente
 */
const createSale = async (form) => {
    const URL = `../app/ticket/create`;
    const params = convertFormToURLSearchParams(form);
    const request = await fetch(URL, requestOptionsPost(params));
    return (await validateResponse(request));
};