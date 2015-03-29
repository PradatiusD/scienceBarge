
// Pulled from https://github.com/DevinClark/angular-tweet-filter

angular.module('instagramFilters', ['ngSanitize'])
  .filter('linkUsername', function() {
    return function(text) {
      return '<a href="http://instagram.com/' + text.slice(1) + '">' + text + '</a>';
    };
  })
  .filter('linkHashtag', function() {
    return function(text) {
      return '<a href="https://instagram.com/explore/tags/' + text.slice(1) + '/">' + text + '</a>';
    };
  })
  .filter('post', function() {
    return function(text) {
      var urlRegex = /((https?:\/\/)?[\w-]+(\.[\w-]+)+\.?(:\d+)?(\/\S*)?)/g;
      var twitterUserRegex = /@([a-zA-Z0-9_]{1,20})/g;
      var twitterHashTagRegex = /\B#(\w+)/g;

      text = text.replace(urlRegex," <a href='$&' target='_blank'>$&</a>").trim();
      text = text.replace(twitterUserRegex,"<a href='http://www.twitter.com/$1' target='_blank'>@$1</a>");
      text = text.replace(twitterHashTagRegex,"<a href='https://instagram.com/explore/tags/$1/' target='_blank'>#$1</a>");

      return text;
    };
  });


// Documentation at http://instafeedjs.com/

angular.module('instagram-client',['instagramFilters'])
.controller('InstagramFeedController',['$scope','$http',function($scope, $http){

  $scope.feed = [];

  var userFeed = new Instafeed({
    get: 'user',
    userId: 1774511928,
    accessToken: '1774511928.2c90c39.680a9751b646476e82df1b5719e02261',
    resolution: 'standard_resolution',
    template: '',
    success: function(response) {
      $scope.feed = response.data;
      console.log($scope.feed);
      $scope.$apply();
    },
  }).run();

}]);

// angular.bootstrap(document.getElementById("instagramfeed"), ['instagram-client']);