const validateResponse = async (request) => {
    let response = {status: false, message: ''};
    if(request.ok){
        const text = await request.text();
        if(isJSON(text)){
            response = JSON.parse(text);
        }else{
            response.message = 'Problemas en el servidor.';
        }
        return(response);
    }else{
        response.message = 'No se pudo comunicar con el servidor.';
    }
    return response;
};

const isJSON = (data) => {
    try {
        JSON.parse(data);
    } catch (e) {
        return false;
    }
    return true;
}

const textToHtml = (text) => {
    const parser = new DOMParser();
    const html = parser.parseFromString(text, 'text/html');
    const node = html.body.childNodes[0];
    return node;
};
