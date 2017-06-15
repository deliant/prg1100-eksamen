function initDatepicker(elem) {
  $(elem).datepicker({
    dateFormat: 'yy-mm-dd',
    prevText:'',
    nextText:'',
    minDate: "0",
    maxDate: "+365"
  });
}

function initTimepicker(elem) {
  $(elem).timepicker({
    timeFormat: 'HH:mm',
    interval: '15',
    minTime: '08',
    maxTime: '16',
    startTime: '08:00',
    dynamic: true,
    dropdown: true,
    scrollbar: true
  });
}

$(document).ready(function(){
  initDatepicker('#regDato, #endringDato, #velgDato');
});

$(document).ready(function(){
  initTimepicker('#regFraTidspunkt, #regTilTidspunkt, #endringFraTidspunkt, #endringTilTidspunkt');
});