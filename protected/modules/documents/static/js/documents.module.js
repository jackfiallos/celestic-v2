var Celestic = angular.module('celestic', []);

Celestic.config(
	function($routeProvider) {
	$routeProvider.when('/#create', {
		templateUrl: 'http://celestic.local/documents/create',
		controller: 'celestic.documents.controller'
	})
	.when('/', {
		templateUrl: 'http://celestic.local/documents/create',
		controller: 'celestic.documents.controller'
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
Celestic.controller('celestic.documents.controller', function($scope, $http) {
	console.log('as');
	// $http({
	// 	headers: {
	// 		'Content-Type': 'application/x-www-form-urlencoded'
	// 	},
	// 	url:'/documents/create',
	// 	method: 'GET',
	// 	data: $.param({
	// 		"auth": 1,
	// 		"state": 'West Bengal'
	// 	})
	// }).success(function(data) {
	// 	$scope.view = data;
	// });
});