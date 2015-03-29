// Pulled from https://github.com/DevinClark/angular-tweet-filter

angular.module('twitterFilters', ['ngSanitize'])
  .filter('linkUsername', function() {
    return function(text) {
      return '<a href="http://twitter.com/' + text.slice(1) + '">' + text + '</a>';
    };
  })
  .filter('linkHashtag', function() {
    return function(text) {
      return '<a href="http://twitter.com/search/%23' + text.slice(1) + '">' + text + '</a>';
    };
  })
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
  });

angular.module('twitter-client',['twitterFilters'])
.controller('TwitterFeedController', ['$scope','$http', '$filter', function($scope, $http, $filter) {


  $scope.formatDate = function (dateString){
    var date = Date.parse(dateString);
    date = $filter('date')(date, 'MMM d h:mm a');
    return date;
  };


  $scope.fetchTwitterData = function () {

    var base;

    if (window.location.host !== 'localhost') {
      base = window.location.origin;
    } else {
      base = 'http://localhost/scienceBarge';
    }

    var endpoint = '/wp-content/themes/scienceBarge/twitter.php?service=true';

    var resource = base+endpoint;

    $http.get(resource).success(function(twitterData){
      $scope.feed = twitterData;
      $scope.about = twitterData[0].user;
    });
  };

}]);