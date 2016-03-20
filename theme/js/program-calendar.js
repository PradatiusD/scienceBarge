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

  var opening = moment("2016-03-21");

  for (var i = 0; i < 52; i++) {

    options.events.push({
      title: "Closed",
      start: opening.format('YYYY-MM-DD'),
      end:   opening.add(2, 'days').format('YYYY-MM-DD'),
      className: ["fc-disabled"],
      status: "closed",
      permalink: "#"
    });

    opening.add(5, 'days');
  }

  $.ajax(url).done(function (events) {

    function getISODate(dateOutput) {
      var unixTime = Number(dateOutput) * 1000;
      var date = new Date(unixTime);
      return date.toISOString();
    }

    var wp_events = events.map(function (evt) {

      var startTime = getISODate(evt.data["wpcf-end-date-time"][0]);
      var endTime   = getISODate(evt.data["wpcf-start-date-time"][0]);

      return {
        title: evt.title,
        start: startTime,
        end:   endTime,
        permalink: evt.permalink
      };
    });

    options.events = options.events.concat(wp_events);

    options.eventClick = function (calEvent, jsEvent, view) {

      if (calEvent.status !== "closed") {
        window.open(calEvent.permalink, "_blank");
      }
    };

    $('#calendar').fullCalendar(options);
  });

})(jQuery);