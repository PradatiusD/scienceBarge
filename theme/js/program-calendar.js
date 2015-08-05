(function ($){

  var options = {
    header: {
      left:   'prev,next today',
      center: 'title',
      right:  'month, agendaWeek, agendaDay'
    },
    editable: false,
    events: []
  };

  var url = window.location.href + "/?calendar";

  $.ajax(url).done(function (events) {

    function getISODate(dateOutput) {
      var unixTime = Number(dateOutput) * 1000;
      var date = new Date(unixTime);
      return date.toISOString();
    }

    options.events = events.map(function (evt){

      console.log(evt);

      var startTime = getISODate(evt.data["wpcf-end-date-time"][0]);
      var endTime   = getISODate(evt.data["wpcf-start-date-time"][0]);

      return {
        title: evt.title,
        start: startTime,
        end:   endTime,
        permalink: evt.permalink
      };
    });

    options.eventClick = function (calEvent, jsEvent, view) {
      window.open(calEvent.permalink, "_blank");
    };

    $('#calendar').fullCalendar(options);
  });

})(jQuery);