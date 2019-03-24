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

let foldercount = 1;

function addfolderitem(foldername) {
    let text = "";
    text += '<a class="list-group-item" id="fold' + foldercount + '" onclick="changefold(' + foldercount + ');">' + foldername + '</a>';
    document.getElementById('folderlist').innerHTML += text;
    foldercount++;
}

function addaddfolder() {
    let text = '<a class="list-group-item" data-toggle="modal" data-target="#modalSubscriptionForm">+</a>';
    text += "";
    document.getElementById('folderlist').innerHTML += text;
}

function red() {
    window.location.replace("red.php");
}

function changefold(foldernum) {
    clearfileexplorer();
    for (let i=0; i <foldercount;i++) {
        document.getElementById('fold' + i).classList.remove('active');
    }
    document.getElementById('fold' + foldernum).classList.add('active');

    let text = '<?php $selectedpath = "';
    text += document.getElementById('fold' + foldernum).innerText;
    text += '"; loadfileexplorer($conn, $username, $selectedpath); ?>';

    document.body.innerHTML += text;
}

function clearfileexplorer() {
    document.getElementById("fileexplorer").innerHTML = "";
}