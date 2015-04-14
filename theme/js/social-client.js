// Pulled from https://github.com/DevinClark/angular-tweet-filter


angular.module('socialFilters', ['ngSanitize'])
  .filter('tweet', function() {
    return function(text) {
      var urlRegex = /((https?:\/\/)?[\w-]+(\.[\w-]+)+\.?(:\d+)?(\/\S*)?)/g;
      var twitterUserRegex = /@([a-zA-Z0-9_]{1,20})/g;
      var twitterHashTagRegex = /\B#(\w+)/g;

      text = text.replace(urlRegex," <a href='$&' target='_blank'>$&</a>").trim();
      text = text.replace(twitterUserRegex,"<a href='http://www.twitter.com/$1' target='_blank'>@$1</a>");
      text = text.replace(twitterHashTagRegex,"<a href='http://twitter.com/search/%23$1' target='_blank'>#$1</a>");

      return text;
    };
  })
  .filter('post', function() {
    return function(text) {
      var urlRegex = /((https?:\/\/)?[\w-]+(\.[\w-]+)+\.?(:\d+)?(\/\S*)?)/g;
      var instagramUserRegex = /@([a-zA-Z0-9_]{1,20})/g;
      var instagramHashTagRegex = /\B#(\w+)/g;

      text = text.replace(urlRegex," <a href='$&' target='_blank'>$&</a>").trim();
      text = text.replace(instagramUserRegex,"<a href='http://www.instagram.com/$1' target='_blank'>@$1</a>");
      text = text.replace(instagramHashTagRegex,"<a href='https://instagram.com/explore/tags/$1/' target='_blank'>#$1</a>");

      return text;
    };
  });


// Documentation at http://instafeedjs.com/
angular.module('social-client',['socialFilters'])

.controller('SocialFeedController', ['$scope','$http', '$filter', function($scope, $http, $filter) {

  $scope.formatDate = function (dateString){
    var date = Date.parse(dateString);
    date = $filter('date')(date, 'MMM d h:mm a');
    return date;
  };


  async.parallel([

    function fetchInstagramFeed (callback) {

      new Instafeed({
        get: 'user',
        userId: 1774511928,
        accessToken: '1774511928.2c90c39.680a9751b646476e82df1b5719e02261',
        resolution: 'standard_resolution',
        template: '',
        success: function(response) {

          response = response.data.map(function (item) {
            item.source = 'instagram';
            item.date   =  new Date(item.created_time*1000);
            return item;
          });

          callback(null, response);
        },
      }).run();

    },

    function fetchTwitterData (callback) {

      var base;

      if (window.location.host !== 'localhost') {
        base = window.location.origin;
      } else {
        base = 'http://localhost/scienceBarge';
      }

      var endpoint = '/wp-content/themes/scienceBarge/twitter.php?service=true';

      var resource = base + endpoint;

      $http.get(resource).success(function(twitterData){

        twitterData = twitterData.map(function (item) {
          item.source = 'twitter';
          item.date   = new Date(item.created_at);
          return item;
        });

        callback(null, twitterData)
      });

    }

    ], function displayData (err, data) {

      // Flatten the array
      data = data.reduce(function(a,b){return a.concat(b)});

      // Sort by date
      data = data.sort(function(a,b) {
        if (a.date < b.date) return 1;
        if (a.date > b.date) return -1;
        return 0;

      });

      console.log(data);

      // Add to controller scope
      $scope.feed = data;

  });




}]);