(function ($){

	var options = {
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		editable: false
	};

	$('#calendar').fullCalendar(options);

})(jQuery);