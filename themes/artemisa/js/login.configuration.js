var Celestic = angular.module('celestic', ['ngCookies']);

Celestic.config(
	function($routeProvider) {
	$routeProvider.when('/home', {
		action: 'home'
	})
	.when('/forget', {
		action: 'forget'
	})
	.when('/new', {
		action: 'new'
	})
	.otherwise({
		redirectTo: 'home'
	});
});

/**
 * [description]
 * @param  {[type]} $scope       [description]
 * @param  {[type]} $http        [description]
 * @param  {[type]} $location    [description]
 * @param  {[type]} $route       [description]
 * @param  {[type]} $routeParams [description]
 * @param  {[type]} $cookies     [description]
 * @return {[type]}              [description]
 */
Celestic.controller('celestic.login.controller', function($scope, $http, $location, $route, $routeParams, $cookies) {

	/**
	 * [description]
	 * @param  {[type]} $currentRoute  [description]
	 * @param  {[type]} $previousRoute [description]
	 * @return {[type]}                [description]
	 */
	$scope.$on('$routeChangeSuccess', function($currentRoute, $previousRoute) {
		render();
	});

	/**
	 * [render description]
	 * @return {[type]} [description]
	 */
	render = function() {
		if ($route.current.action != 'undefined') {
			var renderAction = $route.current.action;
			$scope.renderAction = renderAction;
		}
	};
});