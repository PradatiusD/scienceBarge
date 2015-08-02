(function ($){

  var options = {
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month,agendaWeek,agendaDay'
    },
    editable: false,
    events: []
  };

  var url = window.location.href + "/?calendar";

  $.ajax(url).done(function (events) {
    options.events = events;
    $('#calendar').fullCalendar(options);
  });

})(jQuery);