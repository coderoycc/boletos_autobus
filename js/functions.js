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

const getParam = (url, parametro) => {
    parametro = parametro.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    let regex = new RegExp("[\\?&]" + parametro + "=([^&#]*)");
    let results = regex.exec(url);
    return results === null
        ? ""
        : decodeURIComponent(results[1].replace(/\+/g, " "));
}

const executeBluetoothPrinter = (ticket) => {
    console.log(ticket);
    // EJECUTAR LA FUNCION DENTRO DEL METODO DE VENDER: 
    // vender(caso_evento_significativo, descripcion_evento)
    /*const ACCION = 'APP PRINTER';
    if (document.getElementById("manejoWebinventarioPrint")) {
      manejoWebinventarioPrint = $('#manejoWebinventarioPrint').val();
      if(manejoWebinventarioPrint == 'SI'){
        const SO = (navigator.userAgent.match(/Android/i) != null);
        if(SO){
          // Preparando datos para enviar a la aplicacion de impresion
          const dbName = getCookieValue('base_server');
          const server = getCookieValue('ipconfig');
          const deepLink = `app://printer.com/sale/${saleId}|${dbName}|${server}`;
          // Abriendo la aplicacion de Impresion
          window.location.href = deepLink;
        }
        console.log(ACCION, SO ? 'Ejecutando aplicación' : 'El Sistema Operativo no es Android.');
      }else{
        console.log(ACCION, "Sin permisos de impresion");
      }
    }else{
      console.log(ACCION, "input no definido");
    }*/
  }