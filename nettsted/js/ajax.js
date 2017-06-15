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
    xmlhttp.open("GET","libs/minside.php?action=registrerbruker",true);
    xmlhttp.send();
  }
}

function endreTimebestilling(str) {
  tidspunkt = document.getElementById("velgTidspunkt").value;
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
    xmlhttp.open("GET","libs/minside.php?action=endre&velgTidspunkt="+tidspunkt,true);
    xmlhttp.send();

    $.ajax({
      //... other ajax params,
      type: "GET",
      url: "libs/timebestilling.php",
      success: function(){
        //... success callback code
        initDatepicker('#endringDato');
      }
    });
  }
}

function listeboksVisLedigTimebestillingBehandler(str) {
  var dato = document.getElementById("endringDato").value;
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
    xmlhttp.open("GET","libs/minside.php?action=listeboksVisLedig&endringBehandler="+str+"&endringDato="+dato,true);
    xmlhttp.send();
  }
}

function listeboksVisLedigTimebestillingDato(str) {
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
    xmlhttp.open("GET","libs/minside.php?action=listeboksVisLedig&endringBehandler="+behandler+"&endringDato="+str,true);
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

function visUkesliste(str) {
  var behandler = document.getElementById("velgBehandler").value
  var dato = document.getElementById("velgDato").value
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
    xmlhttp.open("GET","libs/ukesliste.php?action=visUkesliste&velgBehandler="+behandler+"&velgDato="+dato,true);
    xmlhttp.send();

    $.ajax({
      //... other ajax params,
      type: "GET",
      url: "libs/ukesliste.php",
      success: function(){
        //... success callback code
        initDatepicker('#velgDato');
      }
    });
  }
}

function visDato(str) {
  var behandler = document.getElementById("velgBehandler").value;
  var dato = document.getElementById("velgDato").value;
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
    xmlhttp.open("GET","libs/ukesliste.php?action=visDato&velgBehandler="+behandler+"&velgDato="+dato,true);
    xmlhttp.send();
  }
}