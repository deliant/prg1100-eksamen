function fjernMelding() {
  document.getElementById("validering").innerHTML="";
  document.getElementById("respons").innerHTML="";
}

function validerPersonnr(personnr) {
  var tegn1, tegn2, tegn3, tegn4, tegn5, tegn6, tegn7, tegn8, tegn9, tegn10, tegn11;
  var lovligPersonnr = true;
  if(personnr.length != 11) {
    lovligPersonnr = false;
  }
  else {
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
  var personnr = document.getElementById("regPersonnr").value;
  var lovligPersonnr = validerPersonnr(personnr);
  var feilMelding = "";
  if(!personnr) {
    feilMelding = "Personnr er ikke fyllt ut<br />";
  }
  if(lovligPersonnr) {
    return true;
  }
  else {
    feilMelding = "Personnr inneholder 11 tall og er unikt";
    document.getElementById("validering").innerHTML="<div class=\"alert alert-danger\" align=\"top\">"+feilMelding+"</div>";
    return false;
  }
}

function validerBrukerInnlogging() {
  var personnr = document.getElementById("personnr").value;
  var lovligPersonnr = validerPersonnr(personnr);
  var feilMelding = "";
  if(!personnr) {
    feilMelding = "Personnr er ikke fyllt ut<br />";
  }
  if(lovligPersonnr) {
    return true;
  }
  else {
    feilMelding = "Personnr inneholder 11 tall og er unikt";
    document.getElementById("validering").innerHTML="<div class=\"alert alert-danger\" align=\"top\">"+feilMelding+"</div>";
    return false;
  }
}

function validerTimebestillingRegistrering() {
  var dato = document.getElementById("regDato").value
  var lovligDato = validerDato(dato);
  var feilMelding = "";
  if(!dato) {
    feilMelding = "Dato er ikke fyllt ut<br />";
  }
  if(lovligDato) {
    return true;
  }
  else {
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
    feilMelding = "Dato er ikke fyllt ut<br />";
  }
  if(lovligDato) {
    return true;
  }
  else {
    feilMelding = "Dato fylles ut i format: ÅÅÅÅ-MM-DD (1970-05-30)";
    document.getElementById("validering").innerHTML="<div class=\"alert alert-danger\" align=\"top\">"+feilMelding+"</div>";
    return false;
  }
}