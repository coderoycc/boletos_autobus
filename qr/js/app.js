
const loadDetail = async ( ) => {
    const ticketId = getParam(window.location, 'data');
    const request = await getTicketDetailView(ticketId);
    document.getElementById('data-client').innerHTML = request;
};

loadDetail();