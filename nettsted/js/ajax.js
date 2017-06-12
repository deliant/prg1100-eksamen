function ajaxMinsideRegistrering(str) {
  if (str == "") {
    document.getElementById("ajax").innerHTML = "";
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
        document.getElementById("ajax").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","libs/minside.php?action=ajaxReg",true);
    xmlhttp.send();
  }
}

function listeboksRegTimebestillingDato(str) {
  var behandler = document.getElementById("regBehandler").value;
  if (str == "") {
    document.getElementById("regTidspunkt").innerHTML = "";
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
        document.getElementById("regTidspunkt").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","libs/timebestilling.php?action=listeboksReg&regBehandler="+behandler+"&regDato="+str,true);
    xmlhttp.send();
  }
}

function listeboksRegTimebestillingBehandler(str) {
  var dato = document.getElementById("regDato").value;
  if (str == "") {
    document.getElementById("regTidspunkt").innerHTML = "";
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
        document.getElementById("regTidspunkt").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","libs/timebestilling.php?action=listeboksReg&regBehandler="+str+"&regDato="+dato,true);
    xmlhttp.send();
  }
}