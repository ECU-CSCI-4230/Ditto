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

// DISPLAY REGISTRATION SUCCESS --OLD CODE--
function regSuccess() {
    let text = "";
    text += "<div class=" + "\"alert alert-success\" role=\"alert\" id=\"sucbadge\"><strong>Success!</strong>" + " REGISTRATION SUCCESSFUL ";
    text += " <a href=\"signIn.php\">CLICK HERE TO LOGIN</a></div>";
    document.getElementById('reg').innerHTML = text;
}

// VARIABLES KEEP TRACK(internally) of directory(or folder) names and count
let foldercount = 2;
let filecount = 0;
var foldernames = [];
var filenames = [];
foldernames.push('');
foldernames.push('#FS');
filenames.push('');

// ADDS FOLDER
function addfolderitem(foldername) {
    let text = "";
    text += '<a class="list-group-item" id="fold' + foldercount + '" onclick="changefold(' + foldercount + ');">' + foldername + '</a>';
    document.getElementById('folderlist').innerHTML += text;
    newexplorer();
    foldernames.push(foldername);
    foldercount++;
}

// ADDS "+" CREATE FOLDER TAB
function addaddfolder() {
    let text = '<a class="list-group-item" data-toggle="modal" data-target="#createDirForm">+</a>';
    text += "";
    document.getElementById('folderlist').innerHTML += text;
}

function red() {
    window.location.replace("red.php");
}

function addfiletoexplorer(dir, filename, filetype, lastmod, size, filePath, fileID) {
    let num = getfoldernum(dir);
    let text = '<li class="list-group-item" id="file' + filecount + '">' + filename +
        '<a class="btn btn-dark float-right" href="' + filePath + '"download="" role="button" >Download</a>' +
        '<a class="btn btn-danger float-right" href="#" role="button" onclick="prepDeleteModal(\'' + fileID  +'\',\'' + filePath + '\')">Delete</a>' +
        '<a class="btn btn-light float-right" href="#" role="button" onclick="prepFSModal(' + fileID + ')">FileShare</a>' +
        '<a class="btn btn-info float-right" href="#" role="button" onclick="prepMoveModal(\'' + fileID  +'\',\'' + filePath + '\',\'' + filename + '\')" >Move File</a>' +
        '</li>';
    document.getElementById('filelist' + num).innerHTML += text;
    filenames.push(filename);
    filecount++
}

function prepFSModal(ID) {
    let txt = '<i class="fas fa-user prefix grey-text"></i>' +
        '<input class="d-none" name="FS[]" value="' + ID + '" />' +
        '<input type="text" id="form3" class="form-control validate" name="FS[]">' +
        '<label data-error="wrong" data-success="right" for="form3">User Name</label>';

    document.getElementById('FSData').innerHTML = txt;

    $("#FSForm").modal().toggle();
}

function prepDeleteModal(ID, Path) {
    let txt = '<i class="fas fa-user prefix grey-text"></i>' +
        '<label data-error="wrong" data-success="right" for="form4">Are you Sure?</label>' +
        '<input type="hidden" name="delete[]" value="' + ID + '" />' +
        '<button class="btn btn-danger form-control" name="delete[]" value="' + Path +'">Confirm Delete<i class="fas fa-paper-plane-o ml-1"></i></button>';

    document.getElementById('delete').innerHTML = txt;

    $("#deleteForm").modal().toggle();
}

function prepMoveModal(ID, Path, Name) {
    let txt = '<i class="fas fa-user prefix grey-text"></i>' +
        '<input type="hidden" name="move[]" value="' + ID + '" />' +
        '<input type="hidden" name="move[]" value="' + Name + '" />' +
        '<button class="btn btn-dark form-control" name="move[]" value="' + Path +'">Confirm Move<i class="fas fa-paper-plane-o ml-1"></i></button>';

    document.getElementById('move').innerHTML = txt;

    $("#moveForm").modal().toggle();
}

// RETURNS FOLDER INDEX OF NAME
function getfoldernum(name){
    for (let i=0;i<=foldercount; i++) {
        if (name == foldernames[i]) {
            return i;
        }
    }
    return 0;
}

function getactivefolder() {
    for (let i=0;i<=foldercount; i++) {
        if (document.getElementById('fold' + i).classList.contains('active')) {
            return i;
        }
    }
    return 0;
}
function changefold(foldernum) {
    for (let i = 0; i < foldercount; i++) {
        document.getElementById('fold' + i).classList.remove('active');
    }
    document.getElementById('fold' + foldernum).classList.add('active');
    changeexplorer(foldernum);
}

function changeexplorer(exnum) {
    for (let i = 0; i < foldercount; i++) {
        document.getElementById('fileexplorer' + i).classList.add('d-none');
    }
    document.getElementById('fileexplorer' + exnum).classList.remove('d-none');
}

function clearfileexplorer() {
    document.getElementById("fileexplorer").innerHTML = "";
}

function newexplorer() {
    let text = '<div class="card-body d-none" id="fileexplorer' + foldercount + '"><ul class="list-group" id="filelist' + foldercount + '"></ul>';
    document.getElementById('explorer').innerHTML += text;
}

function adduploaddir(foldername) {
    let text = '<option value="' + foldername + '">' + foldername + '</option>';
    document.getElementById('uploadfolders').innerHTML += text;
}

$(document).ready(function() {
    $('#trigger').click(function () {
        $('#overlay').fadeIn(300);
    });
    $('#close').click(function () {
        $('#overlay').fadeOut(300);
    });
});
