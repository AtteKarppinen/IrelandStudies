$('#date_picker').datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '-150:+0',
    dateFormat: 'dd/mm/yy',
    minDate: (new Date(1890, 1, 1)),
    maxDate: (new Date())
  });