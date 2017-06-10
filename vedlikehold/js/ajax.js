function endreBehandler(str) {
  if (str == "") {
    document.getElementById("endring").innerHTML = "";
    return;
  } else {
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp = new XMLHttpRequest();
    } else {
      // code for IE6, IE5
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("endring").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","libs/behandler.php?action=endre&brukernavn="+str,true);
    xmlhttp.send();
  }
}

function endreBilde(str) {
  if (str == "") {
    document.getElementById("endring").innerHTML = "";
    return;
  } else {
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp = new XMLHttpRequest();
    } else {
      // code for IE6, IE5
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("endring").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","libs/bilde.php?action=endre&bildenr="+str,true);
    xmlhttp.send();
  }
}

function endrePasient(str) {
  if (str == "") {
    document.getElementById("endring").innerHTML = "";
    return;
  } else {
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp = new XMLHttpRequest();
    } else {
      // code for IE6, IE5
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("endring").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","libs/pasient.php?action=endre&personnr="+str,true);
    xmlhttp.send();
  }
}

function listeboksTimebestilling(str) {
  var pasient = document.getElementById("pasient").value;
  if (str == "") {
    document.getElementById("timebestillingnr").innerHTML = "";
    return;
  } else {
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp = new XMLHttpRequest();
    } else {
      // code for IE6, IE5
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("timebestillingnr").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","libs/timebestilling.php?action=listeboks&pasient="+pasient+"&behandler="+str,true);
    xmlhttp.send();
  }
}

function endreTimebestilling(str) {
  if (str == "") {
    document.getElementById("endring").innerHTML = "";
    return;
  } else {
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp = new XMLHttpRequest();
    } else {
      // code for IE6, IE5
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("endring").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","libs/timebestilling.php?action=endre&timebestillingnr="+str,true);
    xmlhttp.send();
  }
}

function endreYrkesgruppe(str) {
  if (str == "") {
    document.getElementById("endring").innerHTML = "";
    return;
  } else {
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp = new XMLHttpRequest();
    } else {
      // code for IE6, IE5
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("endring").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","libs/yrkesgruppe.php?action=endre&yrkesgruppenr="+str,true);
    xmlhttp.send();
  }
}
