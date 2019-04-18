

// // DISPLAY REGISTRATION SUCCESS --OLD CODE--
// function regSuccess() {
//     let text = "";
//     text += "<div class=" + "\"alert alert-success\" role=\"alert\" id=\"sucbadge\"><strong>Success!</strong>" + " REGISTRATION SUCCESSFUL ";
//     text += " <a href=\"signIn.php\">CLICK HERE TO LOGIN</a></div>";
//     document.getElementById('reg').innerHTML = text;
// }

/*
    VARIABLES KEEP TRACK(internally) of directory(or folder) names and count
*/
let foldercount = 2;
let filecount = 0;
var foldernames = [];
var filenames = [];
foldernames.push('');
foldernames.push('#FS');
filenames.push('');


/*
    ADDS FOLDER TO PAGE WITH GIVEN NAME
*/
function addfolderitem(foldername) {

    // Adds viewable folder tab
    let text = '<a class="list-group-item" id="fold' + foldercount + '" onclick="changefold(' + foldercount + ');">' + foldername + '</a>';
    document.getElementById('folderlist').innerHTML += text;

    // Adds folder to input options in file command pop-up
    let text2 = '<option value="' + foldername + '">' + foldername + '</option>';
    document.getElementById('uploadfolders').innerHTML += text2;

    // Adds file explorer, assigned by numbers in sequential order...
    newexplorer();
    foldernames.push(foldername);
    foldercount++;
}


/*
    ADDS "+" CREATE FOLDER "CLICKABLE" TAB
*/
function addaddfolder() {
    let text = '<a class="list-group-item" data-toggle="modal" data-target="#createDirForm">+</a>';
    text += "";
    document.getElementById('folderlist').innerHTML += text;
}


/*
    REDIRECTS CURRENT PAGE TO INDEX
*/
function red() {
    window.location.replace("red.php");
}

/*
    ADDS USER OWNED FILE AND BUTTONS TO VIEW. Adds an individual file to the specified folder.
    File is added to file explorer via sequentially assigned number to each explorer
*/
function addfiletoexplorer(dir, filename, filetype, lastmod, size, filePath, fileID) {

    let num = getfoldernum(dir);

    let text = '<li class="list-group-item" id="file' + filecount + '">' + filename +
        '<div style="display:inline-block; float:right;"><a class="btn btn-outline-dark float-right" href="' + filePath + '"download="" role="button" >Download</a>' +
        '<a class="btn btn-outline-danger float-right" href="#" role="button" onclick="prepDeleteModal(\'' + fileID  +'\',\'' + filePath + '\')">Delete</a>' +
        '<a class="btn btn-outline-success float-right" href="#" role="button" onclick="prepFSModal(' + fileID + ')">Share</a>' +
        '<a class="btn btn-outline-info float-right" href="#" role="button" onclick="prepMoveModal(\'' + fileID  +'\',\'' + filePath + '\',\'' + filename + '\')" >Move</a></div>' +
        '</li>';
    document.getElementById('filelist' + num).innerHTML += text;
    filenames.push(filename);
    filecount++
}

/*
    ADDS SHARED FILE(RECEIVED) WITH BUTTONS TO VIEW. Adds an individual file to the specified folder.
*/
function addfiletoexplorer2(dir, filename, filetype, lastmod, size, filePath, fileID, fileowner) {

    let num = getfoldernum(dir);

    let text = '<li class="list-group-item" id="file' + filecount + '">' + filename +
        '<div style="display:inline-block; float:right;"><a class="btn btn-outline-dark float-right" href="' + filePath + '"download="" role="button" >Download</a>' +
        '<div style="text-emphasis: dot; float: right; margin-right: 15px;">Owner: ' + fileowner + '    ' +
        '</li>';
    document.getElementById('filelist' + num).innerHTML += text;
    filenames.push(filename);
    filecount++
}


/*
    ADDS INPUT FORM DATA TO FILE-SHARE POPUP WINDOW
*/
function prepFSModal(ID) {
    let txt = '<i class="fas fa-user prefix grey-text"></i>' +
        '<input class="d-none" name="FS[]" value="' + ID + '" />' +
        '<input type="text" id="form3" class="form-control validate" name="FS[]">' +
        '<label data-error="wrong" data-success="right" for="form3">User Name</label>';

    document.getElementById('FSData').innerHTML = txt;

    $("#FSForm").modal().toggle();
}


/*
    ADDS INPUT FORM DATA TO DELETE FILE POPUP WINDOW
*/
function prepDeleteModal(ID, Path) {
    let txt = '<i class="fas fa-user prefix grey-text"></i>' +
        '<label data-error="wrong" data-success="right" for="form4">Are you Sure?</label>' +
        '<input type="hidden" name="delete[]" value="' + ID + '" />' +
        '<button class="btn btn-danger form-control" name="delete[]" value="' + Path +'">Confirm Delete<i class="fas fa-paper-plane-o ml-1"></i></button>';

    document.getElementById('delete').innerHTML = txt;

    $("#deleteForm").modal().toggle();
}

/*
    ADDS INPUT FORM DATA TO MOVE-FILE POPUP WINDOW
*/
function prepMoveModal(ID, Path, Name) {
    let txt = '<i class="fas fa-user prefix grey-text"></i>' +
        '<input type="hidden" name="move[]" value="' + ID + '" />' +
        '<input type="hidden" name="move[]" value="' + Name + '" />' +
        '<button class="btn btn-dark form-control" name="move[]" value="' + Path +'">Confirm Move<i class="fas fa-paper-plane-o ml-1"></i></button>';

    document.getElementById('move').innerHTML = txt;

    $("#moveForm").modal().toggle();
}


/*
   Returns forder-number that corresponds with the name given as parameter
*/
function getfoldernum(name){
    for (let i=0;i<=foldercount; i++) {
        if (name == foldernames[i]) {
            return i;
        }
    }
    return 0;
}

/*
    Returns forder-number of the folder(directory) that is currently open in view
*/
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
