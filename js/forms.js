const isFormValidity = (form) => {
    let isValidity = true;
    // Limpiando los campos validos
    const validFields = form.querySelectorAll(':valid');
    validFields.forEach((field) => {
        cleanFeedBack(field);
    });
    // Marcando los campos invalidos
    const invalidFields = form.querySelectorAll(':invalid');
    invalidFields.forEach((field) => {
        // Eliminando feedback anterior
        const invField = document.getElementById(`if-${field.id}`);
        if(invField != null){
            field.parentNode.removeChild(invField);
        }
        // Creando el feedback
        const div = document.createElement('div');
        div.classList.add('invalid-feedback');
        div.id = `if-${field.id}`;
        console.log()
        div.textContent = field.validationMessage;
        field.parentNode.appendChild(div);
        isValidity = false;
        field.classList.add('is-invalid');
    });
    
    return isValidity;
};

/**
 * Limpieza de feedback de un campo
 */
const cleanFeedBack = (field) => {
    const invField = document.getElementById(`if-${field.id}`);
    if(invField != null){
        field.parentNode.removeChild(invField);
    }
    field.classList.remove('is-invalid');
}

const convertFormToURLSearchParams = (forms) => {
    const params = new URLSearchParams();
    forms.forEach((form) => {
        const formData = new FormData(form);
        for(let [name, value, type] of formData) {
            console.log(name, value);
            params.append(name, value);
        }
    });
    return params;
}

const convertToFormData = (data) => {
    const params = new URLSearchParams();
    Object.entries(data).forEach(([key, value]) => {
        params.append(key, value);
    });
    return params;
}