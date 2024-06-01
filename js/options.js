const requestOptionsPost = (params) => {
    return({
        method: 'POST',
        body: params,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
    });
}

const requestOptionsGet = () => {
    return({
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    });
}