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

.controller('SocialFeedController', function($scope, $http, $filter, $q) {

  $scope.formatDate = function (dateString){
    var date = Date.parse(dateString);
    date = $filter('date')(date, 'MMM d h:mm a');
    return date;
  };

  /*
   * Generate with http://jelled.com/instagram/access-token
   * https://instagram.com/oauth/authorize/?client_id=2c90c392eca943d8b4c5ba2a7e9f5fd6&redirect_uri=http://localhost&response_type=token
   */

  new Instafeed({
    get: 'user',
    userId: 1774511928,
    accessToken: '1774511928.2c90c39.ab7f09b287a14b51b7111f8778502ecc',
    resolution: 'standard_resolution',
    template: '',
    success: function(response) {

      response = response.data.map(function (item) {
        item.source = 'instagram';
        item.date   =  new Date(item.created_time*1000);
        return item;
      });

      var data = response.sort(function(a,b) {
        if (a.date < b.date) return 1;
        if (a.date > b.date) return -1;
        return 0;
      });

      $scope.$apply(function () {
        $scope.feed = data;      
      });
    },
  }).run();

  function setFeedHeight() {
    
    // Query DOM elements
    var $socialFeed = document.querySelector('#socialFeed');
    var $content = document.querySelector('.content');

    // Now turn to jqLite selectors
    $socialFeed = angular.element($socialFeed);
    $content =    angular.element($content);

    var contentHeight = $content[0].offsetHeight;

    $socialFeed.css({
      'overflow':'hidden',
      'max-height': contentHeight + 'px',
    });

  }

  setFeedHeight();

});