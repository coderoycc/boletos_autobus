/**
 * Listar locaciones registradas
 */
const getAllLocations = async () => {
    const URL = `../app/location/all`;
    const request = await fetch(URL, requestOptionsGet( ));
    return (await validateResponse(request));
};