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

function listeboksRegTimebestilling(str) {
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

function listeboksVisLedigTimebestilling(str) {
  var behandler = document.getElementById("endringBehandler").value;
  if (str == "") {
    document.getElementById("endringTidspunkt").innerHTML = "";
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
        document.getElementById("endringTidspunkt").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","libs/timebestilling.php?action=listeboksVisLedig&endringBehandler="+behandler+"&endringDato="+str,true);
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

    $.ajax({
      //... other ajax params,
      type: "GET",
      url: "libs/timebestilling.php",
      success: function(){
        //... success callback code
        initDatepicker('#regDato, #endringDato');
      }
    });
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

    $.ajax({
      //... other ajax params,
      type: "GET",
      url: "libs/timeinndeling.php",
      success: function(){
        //... success callback code
        initTimepicker('#regFraTidspunkt, #regTilTidspunkt, #endringFraTidspunkt, #endringTilTidspunkt');
      }
    });
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
