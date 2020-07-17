$(document).ready(function(){
	var offset = new Date().getTimezoneOffset();
	var timestamp = new Date().getTime();
	var utc_timestamp = timestamp + (60000 * offset);

	$('#time_zone_offset').val(offset); //selecting id time_zone_offset and setting value
	$('#utc_timestamp').val(utc_timestamp); //selecting id utc_timestamp and setting value

});