const limpiarHTML = ( string ) => {
    string = string.replaceAll(/(\n)/g, "");
    string = string.replaceAll(/(\s\s)/g, "");
    string = string.trim();

    return string;
}

export default limpiarHTML;