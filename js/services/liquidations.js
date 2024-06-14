/**
 * Visualizar datos de la liquidacion
 */
const showLiquidation = async (data) => {
    const URL = `../app/liquidation/getInfo`;
    const params = convertToFormData(data);
    const request = await fetch(URL, requestOptionsPost(params));
    return (await validateResponse(request));
};
/**
 * Crear un nuevo cliente
 */
const createLiquidation = async (form) => {
    const URL = `../app/liquidation/create`;
    const params = convertFormToURLSearchParams(form);
    const request = await fetch(URL, requestOptionsPost(params));
    return (await validateResponse(request));
};