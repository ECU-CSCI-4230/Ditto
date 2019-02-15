function display_filenames() {
    let x = document.getElementById("uploadinput").files;
    let y = "";
    for (let z = 0; z < x.length; z++){
        y += "<div class=" + "\"alert alert-info\" role=\"alert\">" + x[z].name + " selected." + "</div>";
    }
    document.getElementById('filealert').innerHTML = y;
}
function display_success() {
    let b = "";
    b += "<div class=" + "\"alert alert-success\" role=\"alert\"><strong>Success!</strong>" + " File has been uploaded." + "</div>";
    document.getElementById('filealert').innerHTML = b;
}
function display_error(errortext) {
    let c = "";
    c += "<div class=" + "\"alert alert-danger\" role=\"alert\"><strong>Failure!</strong>" + " File has NOT been uploaded. " + errortext + "</div>";
    document.getElementById('filealert').innerHTML = c;
}