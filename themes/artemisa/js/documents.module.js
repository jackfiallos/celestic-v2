var Celestic = angular.module('celestic', []);

Celestic.config(
	function($routeProvider) {
	$routeProvider.when('/create', {
		templateUrl: 'http://celestic.local/?r=documents/default/create',
		controller: 'celestic.documents.create.controller'
	})
	.otherwise({
		redirectTo: '/',
		controller: 'celestic.documents.home.controller'
	});
});

/**
 * [description]
 * @param  {[type]} $rootScope [description]
 * @return {[type]}            [description]
 */
Celestic.factory('sharedService', function($rootScope) {
    return {
        broadcast: function(value) {
            $rootScope.$broadcast('handleBroadcast', value);
        }
    };
});

/**
 * [description]
 * @param  {[type]} $scope        [description]
 * @param  {[type]} $http         [description]
 * @param  {[type]} sharedService [description]
 * @return {[type]}               [description]
 */
Celestic.controller('celestic.documents.home.controller', function($scope, $http, sharedService) {
	$scope.ishome = true;
	
	$scope.$on('handleBroadcast', function(event, value) {
		$scope.ishome = value;
	});
});

/**
 * [description]
 * @param  {[type]} $scope        [description]
 * @param  {[type]} $http         [description]
 * @param  {[type]} sharedService [description]
 * @return {[type]}               [description]
 */
Celestic.controller('celestic.documents.create.controller', function($scope, $http, sharedService) {
	sharedService.broadcast(false);

	$scope.showHome = function() {
		sharedService.broadcast(true);
	};

	$scope.submitForm = function() {
		var fd = new FormData();

		var inputs = jQuery('#documents-form').serializeArray();
		for(var x in inputs) {
			fd.append(inputs[x].name, inputs[x].value);
		}
		fd.append('Documents[image]', jQuery('#Documents_image').val());

		jQuery.ajax({
			type: 'POST',
			processData: false,
			contentType: false,
			url: jQuery('#documents-form').attr('action'),
			data: fd,
			success:function(data){
				console.log(data);
			}
		});
	};
});