(function ($){

  function EventCalendar (options) {

    this.opening        = options.opening;
    this.requestFormURL = options.requestFormURL;

    this.calOptions = {
      header: {
        left:   'prev,next today',
        center: 'title',
        right:  'month, agendaWeek, agendaDay'
      },
      editable: false,
      events: [],
      eventClick: function (calEvent, jsEvent, view) {

        if (calEvent.status !== "closed") {
          window.open(calEvent.permalink, "_blank");
        }
      }
    };
  };

  EventCalendar.prototype.today = moment();

  EventCalendar.prototype.getWPDate = function (dateOutput) {

    var unixTime = Number(dateOutput) * 1000;
    var date = new Date(unixTime);
    return date.toISOString();
  }


  EventCalendar.prototype.fetchWPEvents = function (callback) {
    var url = window.location.href + "/?calendar";
    $.ajax(url).done(callback);
  }


  EventCalendar.prototype.addEvents = function (eventsArr) {
    this.calOptions.events = this.calOptions.events.concat(eventsArr);
  }


  EventCalendar.prototype.addCloseDates = function () {

    var closeDates = [];
    var opening    = moment(this.opening);

    for (var i = 0; i < 52; i++) {

      closeDates.push({
        title: "Closed",
        start: opening.format('YYYY-MM-DD'),
        end:   opening.add(1, 'days').format('YYYY-MM-DD'),
        className: ["fc-disabled"],
        status: "closed",
        permalink: "#"
      });

      opening.add(6, 'days');
    }

    this.addEvents(closeDates);    
  }

  EventCalendar.prototype.reformatDate = function (m) {
    return m.format("YYYY-MM-DDTHH:mm:ss");
  }


  EventCalendar.prototype.setUnavailableDates = function (wpEvents) {

    this.unavailable = {};
    this.unavailable.format = "YYYY-MM-DD";

    wpEvents = wpEvents || [];

    for (var i = 0; i < wpEvents.length; i++) {

      var e   = wpEvents[i];
      var key = moment(e.start).format(this.unavailable.format);

      this.unavailable[key] = {
        start: e.start,
        end:   e.end
      }
    }
  }


  EventCalendar.prototype.addFieldTripDates = function () {

    var openDates  = [];
    var timeStart  = moment(this.today);

    timeStart.minute(0);

    for (var i = 0; i < 365; i++) {

      timeStart.hour(9);
      timeStart.add(1, 'days');

      // Check if a Regular Trip Date
      var day = timeStart.format("dddd");
      var allowedDays = ['Wednesday','Thursday','Friday'];
      var isRegularBusinessDay = (allowedDays.indexOf(day) > -1);

      // Check if no other events
      var dateKey = timeStart.format(this.unavailable.format);
      var noCompetingEvents = this.unavailable[dateKey] ? false : true;

      if (isRegularBusinessDay && noCompetingEvents) {

        var e = {
          title: "Field trip available",
          start: this.reformatDate(timeStart),
          end:   this.reformatDate(timeStart.add(5, 'hours')),
          className: ["fc-available"],
          status: "available",
          permalink: "#"
        }

        e.permalink = this.requestFormURL + "?dor=" + this.today.format('MM/DD/YYYY')+ "&preferred_dates="+ moment(e.start).format('MM/DD/YY h:mma');

        openDates.push(e);

      }
    }

    this.addEvents(openDates);    
  }

  /* Configuration */
  var bargeCalendar = new EventCalendar({
    opening: "2016-03-21",
    requestFormURL: "/field-trip-request-form/"
  });

  bargeCalendar.fetchWPEvents(function (events) {

    var wpEvents = events.map(function (evt) {

      var times     = evt.data;
      var startTime = bargeCalendar.getWPDate(times["wpcf-start-date-time"][0]);
      var endTime   = bargeCalendar.getWPDate(times["wpcf-end-date-time"][0]);

      return {
        title: evt.title,
        start: startTime,
        end:   endTime,
        className: ["fc-activity"],
        permalink: evt.permalink
      };
    });

    bargeCalendar.addCloseDates();
    bargeCalendar.addEvents(wpEvents);
    bargeCalendar.setUnavailableDates(wpEvents);
    bargeCalendar.addFieldTripDates();



    $('#calendar').fullCalendar(bargeCalendar.calOptions);
  });


})(jQuery);