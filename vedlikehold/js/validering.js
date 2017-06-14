function fjernMelding() {
  document.getElementById("validering").innerHTML="";
}

function validerBrukernavn(brukernavn) {
  var lovligBrukernavn = true;
  if(brukernavn.length > 20) {
    lovligBrukernavn = false;
  }
  return lovligBrukernavn;
}

function validerNavn(navn) {
  var regEx = navn.match(/\d+/g);
  var lovligNavn = true;
  if(navn.length > 50) {
    lovligNavn = false;
  }
  // Sjekk etter tall i navnet
  if(regEx != null) {
    lovligNavn = false;
  }
  return lovligNavn;
}

function validerBeskrivelse(beskrivelse) {
  var lovligBeskrivelse = true;
  if(beskrivelse.length > 255) {
    lovligBeskrivelse = false;
  }
  return lovligBeskrivelse;
}

function validerFilnavn(filnavn) {
  var lovligFilnavn = true;
  if(filnavn.length > 255) {
    lovligFilnavn = false;
  }
  return lovligFilnavn;
}

function validerTidspunkt(fratidspunkt, tiltidspunkt) {
  var fratime, framinutt, tiltime, tilminutt;
  var lovligTidspunkt = true;
  if(fratidspunkt.length > 5 || tiltidspunkt.length > 5) {
    lovligTidspunkt = false;
  } else {
    fratime = fratidspunkt.substr(0,2);
    framinutt = fratidspunkt.substr(3,2);
    tiltime = tiltidspunkt.substr(0,2);
    tilminutt = tiltidspunkt.substr(3,2);

    if(framinutt != "15"|| framinutt != "30" || framinutt != "45" || framinutt != "00" ||
      tilminutt != "15"|| tilminutt != "30" || tilminutt != "45" || tilminutt != "00") {
      confirm("Legge til irregulær time? " +fratime+framinutt+ " - " +tiltime+tilminutt)
    }
    if(fratime < "08" || fratime > "16" || tiltime < "08" || tiltime > "16") {
      lovligTidspunkt = false;
    }
  }
  return lovligTidspunkt;
}

function validerPersonnr(personnr) {
  var tegn1, tegn2, tegn3, tegn4, tegn5, tegn6, tegn7, tegn8, tegn9, tegn10, tegn11;
  var lovligPersonnr = true;
  if(personnr.length != 11) {
    lovligPersonnr = false;
  } else {
    tegn1 = personnr.substr(0,1);
    tegn2 = personnr.substr(1,1);
    tegn3 = personnr.substr(2,1);
    tegn4 = personnr.substr(3,1);
    tegn5 = personnr.substr(4,1);
    tegn6 = personnr.substr(5,1);
    tegn7 = personnr.substr(6,1);
    tegn8 = personnr.substr(7,1);
    tegn9 = personnr.substr(8,1);
    tegn10 = personnr.substr(9,1);
    tegn11 = personnr.substr(10,1);

    if(tegn1 < "0" || tegn1 > "9" || tegn2 < "0" || tegn2 > "9" || tegn3 < "0" || tegn3 > "9" ||
      tegn4 < "0" || tegn4 > "9" ||  tegn5 < "0" || tegn5 > "9" ||  tegn6 < "0" || tegn6 > "9" ||
      tegn7 < "0" || tegn7 > "9" ||  tegn8 < "0" || tegn8 > "9" ||  tegn9 < "0" || tegn9 > "9" ||
      tegn10 < "0" || tegn10 > "9" ||  tegn11 < "0" || tegn11 > "9") {
      lovligPersonnr = false;
    }
  }
  return lovligPersonnr;
}

function validerDato(dato) {
  var regEx = /^\d{4}-\d{2}-\d{2}$/;
  var lovligDato = false;
  if(dato.match(regEx)) {
    lovligDato = true;
  }
  return lovligDato;
}

function validerBrukerRegistrering() {
  var brukernavn = document.getElementById("regBrukernavn").value;
  var navn = document.getElementById("regNavn").value;
  var lovligBrukernavn = validerBrukernavn(brukernavn);
  var lovligNavn = validerNavn(navn);
  var feilMelding = "";
  if(!brukernavn) {
    feilMelding = "Brukernavn er ikke fyllt ut<br/>";
  }
  if(!navn) {
    feilMelding = "Navn er ikke fyllt ut<br/>";
  }
  if(!lovligBrukernavn) {
    feilMelding = "Brukernavn inneholder 20 tegn og er unikt<br/>";
  }
  if(!lovligNavn) {
    feilMelding = "Navn inneholder maks 50 bokstaver, ingen tall";
  }
  if(lovligBrukernavn && lovligNavn) {
    return true;
  } else {
    document.getElementById("validering").innerHTML="<div class=\"alert alert-danger\" align=\"top\">"+feilMelding+"</div>";
    return false;
  }
}

function validerBehandlerRegistrering() {
  var brukernavn = document.getElementById("regBrukernavn").value;
  var navn = document.getElementById("regNavn").value;
  var lovligBrukernavn = validerBrukernavn(brukernavn);
  var lovligNavn = validerNavn(navn);
  var feilMelding = "";
  if(!brukernavn) {
    feilMelding = "Brukernavn er ikke fyllt ut<br/>";
  }
  if(!navn) {
    feilMelding = "Navn er ikke fyllt ut<br/>";
  }
  if(!lovligBrukernavn) {
    feilMelding = "Brukernavn inneholder 20 tegn og er unikt<br/>";
  }
  if(!lovligNavn) {
    feilMelding = "Navn inneholder maks 50 bokstaver, ingen tall";
  }
  if(lovligBrukernavn && lovligNavn) {
    return true;
  } else {
    document.getElementById("validering").innerHTML="<div class=\"alert alert-danger\" align=\"top\">"+feilMelding+"</div>";
    return false;
  }
}

function validerBehandlerEndring() {
  var navn = document.getElementById("endringNavn").value;
  var lovligNavn = validerNavn(navn);
  var feilMelding = "";
  if(!navn) {
    feilMelding = "Navn er ikke fyllt ut<br/>";
  }
  if(lovligNavn) {
    return true;
  } else {
    feilMelding = "Navn inneholder maks 50 bokstaver, ingen tall";
    document.getElementById("validering").innerHTML="<div class=\"alert alert-danger\" align=\"top\">"+feilMelding+"</div>";
    return false;
  }
}

function validerBildeRegistrering() {
  var beskrivelse = document.getElementById("regBeskrivelse").value;
  var filnavn = document.getElementById("regFilnavn").value;
  var lovligBeskrivelse = validerBeskrivelse(beskrivelse);
  var lovligFilnavn = validerFilnavn(filnavn);
  var feilMelding = "";
  if(!beskrivelse) {
    feilMelding = "Beskrivelse er ikke fyllt ut<br/>";
  }
  if(!filnavn) {
    feilMelding = "Filnavn er ikke fyllt ut<br/>";
  }
  if(!lovligBeskrivelse) {
    feilMelding = "Beskrivelse inneholder maks 255 tegn<br/>";
  }
  if(!lovligFilnavn) {
    feilMelding = "Filnavn inneholder maks 255 tegn";
  }
  if(lovligBeskrivelse && lovligFilnavn) {
    return true;
  } else {
    document.getElementById("validering").innerHTML="<div class=\"alert alert-danger\" align=\"top\">"+feilMelding+"</div>";
    return false;
  }
}

function validerBildeEndring() {
  var beskrivelse = document.getElementById("endringBeskrivelse").value;
  var lovligBeskrivelse = validerBeskrivelse(beskrivelse);
  var feilMelding = "";
  if(!beskrivelse) {
    feilMelding = "Beskrivelse er ikke fyllt ut<br/>";
  }
  if(lovligBeskrivelse) {
    return true;
  } else {
    feilMelding = "Beskrivelse inneholder maks 255 tegn<br/>";
    document.getElementById("validering").innerHTML="<div class=\"alert alert-danger\" align=\"top\">"+feilMelding+"</div>";
    return false;
  }
}

function validerPasientRegistrering() {
  var navn = document.getElementById("regNavn").value;
  var personnr = document.getElementById("regPersonnr").value;
  var lovligNavn = validerNavn(navn);
  var lovligPersonnr = validerPersonnr(personnr);
  var feilMelding = "";
  if(!navn) {
    feilMelding = "Navn er ikke fyllt ut<br/>";
  }
  if(!personnr) {
    feilMelding = "Personnr er ikke fyllt ut<br/>";
  }
  if(!lovligNavn) {
    feilMelding = "Navn inneholder maks 50 bokstaver, ingen tall<br/>";
  }
  if(!lovligPersonnr) {
    feilMelding = "Personnr inneholder 11 tall og er unikt";
  }
  if(lovligNavn && lovligPersonnr) {
    return true;
  } else {
    document.getElementById("validering").innerHTML="<div class=\"alert alert-danger\" align=\"top\">"+feilMelding+"</div>";
    return false;
  }
}

function validerPasientEndring() {
  var navn = document.getElementById("regNavn").value;
  var lovligNavn = validerNavn(navn);
  var feilMelding = "";
  if(!navn) {
    feilMelding = "Navn er ikke fyllt ut<br/>";
  }
  if(!lovligNavn) {
    return true;
  } else {
    feilMelding = "Navn inneholder maks 50 bokstaver, ingen tall<br/>";
    document.getElementById("validering").innerHTML="<div class=\"alert alert-danger\" align=\"top\">"+feilMelding+"</div>";
    return false;
  }
}

function validerTimebestillingRegistrering() {
  var dato = document.getElementById("regDato").value
  var lovligDato = validerDato(dato);
  var feilMelding = "";
  if(!dato) {
    feilMelding = "Dato er ikke fyllt ut<br/>";
  }
  if(lovligDato) {
    return true;
  } else {
    feilMelding = "Dato fylles ut i format: ÅÅÅÅ-MM-DD (1970-05-30)";
    document.getElementById("validering").innerHTML="<div class=\"alert alert-danger\" align=\"top\">"+feilMelding+"</div>";
    return false;
  }
}

function validerTimebestillingEndring() {
  var dato = document.getElementById("endringDato").value
  var lovligDato = validerDato(dato);
  var feilMelding = "";
  if(!dato) {
    feilMelding = "Dato er ikke fyllt ut<br/>";
  }
  if(lovligDato) {
    return true;
  } else {
    feilMelding = "Dato fylles ut i format: ÅÅÅÅ-MM-DD (1970-05-30)";
    document.getElementById("validering").innerHTML="<div class=\"alert alert-danger\" align=\"top\">"+feilMelding+"</div>";
    return false;
  }
}

function validerTimeinndelingRegistrering() {
  var fratidspunkt = document.getElementById("regFraTidspunkt").value
  var tiltidspunkt = document.getElementById("regTilTidspunkt").value
  var lovligTidspunkt = validerTidspunkt(fratidspunkt, tiltidspunkt);
  var feilMelding = "";
  if(!fratidspunkt || !tiltidspunkt) {
    feilMelding = "Tidspunkt er ikke fyllt ut<br/>";
  }
  if(lovligTidspunkt) {
    return true;
  } else {
    feilMelding = "Tidspunkt fylles ut i format: HH:MM (16:30) og må være innenfor arbeidstid (08-16)";
    document.getElementById("validering").innerHTML="<div class=\"alert alert-danger\" align=\"top\">"+feilMelding+"</div>";
    return false;
  }
}

function validerTimeinndelingEndring() {
  var fratidspunkt = document.getElementById("endringFraTidspunkt").value
  var tiltidspunkt = document.getElementById("endringTilTidspunkt").value
  var lovligTidspunkt = validerTidspunkt(fratidspunkt, tiltidspunkt);
  var feilMelding = "";
  if(!fratidspunkt || !tiltidspunkt) {
    feilMelding = "Tidspunkt er ikke fyllt ut<br/>";
  }
  if(lovligTidspunkt) {
    return true;
  } else {
    feilMelding = "Tidspunkt fylles ut i format: HH:MM (16:30) og må være innenfor arbeidstid (08-16)";
    document.getElementById("validering").innerHTML="<div class=\"alert alert-danger\" align=\"top\">"+feilMelding+"</div>";
    return false;
  }
}

function validerYrkesgruppeRegistrering() {
  var navn = document.getElementById("regYrkesgruppe").value
  var lovligNavn = validerNavn(navn);
  var feilMelding = "";
  if(!navn) {
    feilMelding = "Yrkesgruppe er ikke fyllt ut<br/>";
  }
  if(lovligNavn) {
    return true;
  } else {
    feilMelding = "Navn inneholder maks 50 bokstaver, ingen tall";
    document.getElementById("validering").innerHTML="<div class=\"alert alert-danger\" align=\"top\">"+feilMelding+"</div>";
    return false;
  }
}

function validerYrkesgruppeEndring() {
  var navn = document.getElementById("endringYrkesgruppe").value
  var lovligNavn = validerNavn(navn);
  var feilMelding = "";
  if(!navn) {
    feilMelding = "Yrkesgruppe er ikke fyllt ut<br/>";
  }
  if(lovligNavn) {
    return true;
  } else {
    feilMelding = "Navn inneholder maks 50 bokstaver, ingen tall";
    document.getElementById("validering").innerHTML="<div class=\"alert alert-danger\" align=\"top\">"+feilMelding+"</div>";
    return false;
  }
}