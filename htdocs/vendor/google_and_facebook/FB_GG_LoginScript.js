var myApp = angular.module("myApp", []);

myApp.controller('myController', ['$scope', function ($scope) {
    $scope.facebook = {
        username: "",
        email: ""
    };
    $scope.onFacebookLogin = function () {
        FB.login(function (response) {
            if(response.authResponse) {
                FB.api('/me', 'GET', {fields: 'email, name'}, function (response) {
                    $scope.$apply(function () {
                        $scope.facebook.username = response.name;
                        $scope.facebook.email = response.email;
                    })
                })
            } else {
                // error
            }
        }, {
            scope: 'email, user_likes',
            return_scopes: true
        });
    };
    $scope.gmail = {
        username: "",
        email: ""
    };
    $scope.onGoogleLogin = function () {
        var params = {
            'clientid': '320404164891-kr7gicgtt43cb7085ek16nafd8rs98vn.apps.googleusercontent.com',
            'cookiepolicy': 'single_host_origin',
            'callback': function (result) {
                if(result['status']['signed_in']) {
                    var request =gapi.client.plus.people.get(
                        {
                            'userId': 'me'
                        }
                    );
                    request.execute(function (resp) {
                        $scope.$apply(function () {
                            $scope.gmail.username = resp.displayName;
                            $scope.gmail.email = resp.emails[0].value;
                        })
                    });
                }
            },
            'approvalprompt': 'force',
            'scope': 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read'
        };

        gapi.auth.signIn(params);

    };
}]);