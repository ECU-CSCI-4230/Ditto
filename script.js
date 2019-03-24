// Show the Sign In Page
function showSignIn() {
  var x = document.getElementById("SignOrReg");
  x.style.display = "none";
  var y = document.getElementById("signIn");
  y.style.display = "block";
}

// Show the Reg Page
function showReg() {
  var x = document.getElementById("SignOrReg");
  x.style.display = "none";
  var y = document.getElementById("reg");
  y.style.display = "block";
}

function regSuccess() {
    let text = "";
    text += "<div class=" + "\"alert alert-success\" role=\"alert\" id=\"sucbadge\"><strong>Success!</strong>" + " REGISTRATION SUCCESSFUL ";
    text += " <a href=\"signIn.php\">CLICK HERE TO LOGIN</a></div>";
    document.getElementById('reg').innerHTML = text;
}

function addfiletoexplorer(filename, filetype, lastmod, size) {
    let text = '<li class="list-group-item file-desc">' + filename + '</li>'
    document.getElementById('fileexplorer').innerHTML += text;
}

function addfolderitem(foldername) {
    let text = "";
    text += '<a href="#" class="list-group-item">' + foldername + '</a>';
    document.getElementById('folderlist').innerHTML += text;
}

function addaddfolder() {
    let text = '<a class="list-group-item" data-toggle="modal" data-target="#modalSubscriptionForm">+</a>';
    document.getElementById('folderlist').innerHTML += text;
}

function red() {
    window.location.replace("red.php");
}