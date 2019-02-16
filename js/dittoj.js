


// ALERTS USER OF ALL SELECTED FILES TO BE UPLOADED
function display_filenames() {
    let x = document.getElementById("uploadinput").files;
    let text = "";
    for (let z = 0; z < x.length; z++){
        text += "<div class=" + "\"alert alert-info\" role=\"alert\">" + x[z].name + " selected." + "</div>";
    }
    document.getElementById('filealert').innerHTML = text;
}

// ALERTS USER OF A SUCCESSFUL UPLOAD. APPENDS STRING PARAMETER TO SENT ALERT.
function display_success(successtext) {
    let text = "";
    text += "<div class=" + "\"alert alert-success\" role=\"alert\"><strong>Success!</strong>" + " File has been uploaded. " + successtext + "</div>";
    document.getElementById('filealert').innerHTML += text;
}

// ALERTS USER OF AN UNSUCCESSFUL UPLOAD. APPENDS STRING PARAMETER TO SENT ALERT.
function display_error(errortext) {
    let text = "";
    text += "<div class=" + "\"alert alert-danger\" role=\"alert\"><strong>Failure!</strong>" + " File has NOT been uploaded. " + errortext + "</div>";
    document.getElementById('filealert').innerHTML += text;
}


function display_upload_stats() {

}