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

function listeboksEndreTimebestilling(str) {
  var pasient = document.getElementById("velgPasient").value;
  if (str == "") {
    document.getElementById("velgTidspunkt").innerHTML = "";
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
        document.getElementById("velgTidspunkt").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","libs/timebestilling.php?action=listeboksEndre&velgPasient="+pasient+"&velgBehandler="+str,true);
    xmlhttp.send();
  }
}

function listeboksSlettTimebestilling(str) {
  var pasient = document.getElementById("slettPasient").value;
  if (str == "") {
    document.getElementById("slettTidspunkt").innerHTML = "";
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
        document.getElementById("slettTidspunkt").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","libs/timebestilling.php?action=listeboksSlett&slettPasient="+pasient+"&slettBehandler="+str,true);
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
    xmlhttp.open("GET","libs/timebestilling.php?action=endre&velgTidspunkt="+str,true);
    xmlhttp.send();
  }
}

function listeboksEndreTimeinndeling(str) {
  var behandler = document.getElementById("velgBehandler").value;
  if (str == "") {
    document.getElementById("velgTidspunkt").innerHTML = "";
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
        document.getElementById("velgTidspunkt").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","libs/timeinndeling.php?action=listeboksEndre&velgBehandler="+behandler+"&velgUkedag="+str,true);
    xmlhttp.send();
  }
}

function listeboksSlettTimeinndeling(str) {
  var behandler = document.getElementById("slettBehandler").value;
  if (str == "") {
    document.getElementById("slettTidspunkt").innerHTML = "";
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
        document.getElementById("slettTidspunkt").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","libs/timeinndeling.php?action=listeboksSlett&slettBehandler="+behandler+"&slettUkedag="+str,true);
    xmlhttp.send();
  }
}

function endreTimeinndeling(str) {
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
    xmlhttp.open("GET","libs/timeinndeling.php?action=endre&velgTidspunkt="+str,true);
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
