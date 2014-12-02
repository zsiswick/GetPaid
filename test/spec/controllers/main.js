'use strict';

describe('MainController test', function () {

    var scope;
    var controller;

    beforeEach(function () {
            angular.mock.module('ngRoute', []);
            angular.mock.module('ngAnimate', []);
            angular.mock.module('hmTouchEvents', []);
            angular.module('cwfApp', [ 'ngRoute', 'ngAnimate', 'hmTouchEvents' ]);

            angular.mock.inject(function ($rootScope, $controller) {
                scope = $rootScope.$new();
                controller = $controller('MainCtrl', {
                    $scope: scope
                });
            });
        });

        it('should display a list', function () {
            console.log('-------------- Run Test 1 | ' + scope);
            expect(scope.test).toBe("Hello World!");
        });

});
