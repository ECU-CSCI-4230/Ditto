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

function loginSuccess() {
    let text = "";
    text += "<div class=" + "\"alert alert-success\" role=\"alert\"><strong>Success!</strong>" + " LOGIN SUCCESSFUL "  + "</div>";
    document.getElementById('reg').innerHTML = text;
}