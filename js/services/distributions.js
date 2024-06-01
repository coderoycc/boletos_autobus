/**
 * Obtener la distribucion de asientos en el bus
 */
const getDistributions = async ( ) => {
    const URL = `../distributions.php`;
    const request = await fetch(URL, requestOptionsGet());
    return (await validateResponse(request));
};