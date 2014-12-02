var fooApp = angular.module('fooApp', []);
"use strict";


fooApp.controller('MainCtrl', function ($scope, $rootScope) {
    $scope.test = "Hello World!";
});
