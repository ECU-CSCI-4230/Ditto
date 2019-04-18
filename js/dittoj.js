


// ALERTS USER OF ALL SELECTED FILES TO BE UPLOADED
function display_filenames() {
    let x = document.getElementById("uploadinput").files;
    let text = "";
    for (let z = 0; z < x.length; z++){
        text += "<div class=" + "\"alert alert-info\" role=\"alert\">" + x[z].name + " selected." + "</div>";
    }
    document.getElementById('upload-notis').innerHTML = text;
}

function clear_notifications() {
    document.getElementById('upload-notis').innerHTML = "";
}

// ALERTS USER OF A SUCCESSFUL UPLOAD. APPENDS STRING PARAMETER TO SENT ALERT.
function display_success(successtext) {
    let text = "";
    text += "<div class=" + "\"alert alert-success\" role=\"alert\"><strong> Upload Success! </strong>" + successtext + "</div>";
    document.getElementById('upload-notis').innerHTML += text;
}

// ALERTS USER OF AN UNSUCCESSFUL UPLOAD. APPENDS STRING PARAMETER TO SENT ALERT.
function display_error(errortext) {
    let text = "";
    text += "<div class=" + "\"alert alert-danger\" role=\"alert\"><strong> Upload Failure! </strong>" + " " + errortext + "</div>";
    document.getElementById('upload-notis').innerHTML += text;
}

function display_upload_stats(name, size, type) {
    let text = "";
    text += "<div>";
    text += "<li class=" + "\"list-group-item\"><strong>Filename:</strong> " + name + " </li>";
    text += "<li class=" + "\"list-group-item\"><strong>Type:</strong> " + type + " </li>";
    text += "<li class=" + "\"list-group-item\"><strong>Size:</strong> " + size + " Kb </li>";
    text += "</div>";
    text += "<br>";
    document.getElementById('stats').innerHTML += text;
}