/*
$(function() { var
  //dates = $( "#ConferenceStartDate, #ConferenceEndDate" ).datepicker({
  dates = $( "#start-date, #end-date" ).datepicker({
    dateFormat: "yy-mm-dd", 
    defaultDate: "+1w", 
    changeMonth: true,
    numberOfMonths: 1, 
    onSelect: function( selectedDate ) { 
	      var option = this.id == "start-date" ? "minDate" : "maxDate",
	      instance = $( this ).data( "datepicker" ), 
	      date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings ); 
	      dates.not( this ).datepicker("option", option, date ); 
	  } 
      }); 
    });*/

//use HTML5 to set min date for end date
$(document).ready(function(){
  $('#start-date').on('change',function(e){
    $('#end-date').attr({'min':$(this).val()});
  });
});
