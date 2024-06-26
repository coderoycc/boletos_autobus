/**
 * Obtener la distribucion de asientos en el bus
 */
const getDataDistributions = async (trip_id) => {
  const URL = `../app/trip/getDataDistribution?trip_id=${trip_id}`;
  const request = await fetch(URL, requestOptionsGet());
  return (await validateResponse(request));
};
const getTrips = async () => {
  const URL = `../app/trip/get_all`;
  const request = await fetch(URL, requestOptionsGet());
  return (await validateResponse(request));
}