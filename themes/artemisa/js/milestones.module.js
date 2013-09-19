var Celestic = angular.module('celestic', []);

Celestic.config(
	function($routeProvider) {
	$routeProvider.when('/create', {
		templateUrl: CelesticParams.URL.create,
		controller: 'celestic.milestones.create.controller'
	})
	.when('/view/:id', {
		templateUrl: CelesticParams.URL.view,
		controller: 'celestic.milestones.view.controller'
	})
	.otherwise({
		redirectTo: '/',
		controller: 'celestic.milestones.home.controller'
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
Celestic.controller('celestic.milestones.home.controller', function($scope, $http, sharedService) {
	$scope.ishome = true;
	$scope.milestones = null;
	$scope.hasMilestones = false;

	jQuery.ajax({
		type: 'POST',
		dataType:'json',
		url: CelesticParams.URL.home,
		data: {
			YII_CSRF_TOKEN: CelesticParams.Forms.CSRF_Token
		},
		success:function(data) {
			$scope.$apply(function() {
				if (data.milestones.length > 0) {
					$scope.hasMilestones = true;
				}
				$scope.milestones = data.milestones;
			});
		}
	});
	
	$scope.$on('handleBroadcast', function(event, value) {
		$scope.ishome = value;
	});
});

Celestic.controller('celestic.milestones.view.controller', function($scope, $route, $routeParams, sharedService) {
	$scope.document_name = 'asdf';
	$scope.document_description = '';
	$scope.document_uploadDate = '';
	$scope.user_id = '';

	var id = ($routeParams.id || '');

	sharedService.broadcast(false);

	$scope.showHome = function() {
		sharedService.broadcast(true);
	};

	jQuery.ajax({
		type: 'POST',
		dataType:'json',
		url: CelesticParams.URL.view+'&id='+id,
		data: {
			YII_CSRF_TOKEN: CelesticParams.Forms.CSRF_Token
		},
		success:function(data) {
			$scope.$apply(function() {
				$scope.document_name = data.document_name;
				$scope.document_description = data.document_description;
				$scope.document_uploadDate = data.document_uploadDate;
				$scope.user_id = data.user_id;
			});
		}
	});
});

/**
 * [description]
 * @param  {[type]} $scope        [description]
 * @param  {[type]} $http         [description]
 * @param  {[type]} sharedService [description]
 * @return {[type]}               [description]
 */
Celestic.controller('celestic.milestones.create.controller', function($scope, $http, $location, sharedService) {
	sharedService.broadcast(false);

	$scope.showHome = function() {
		sharedService.broadcast(true);
	};

	$scope.submitForm = function() {
		jQuery.ajax({
			type: 'POST',
			dataType:'json',
			url: jQuery('#milestones-form').attr('action'),
			data: jQuery('#milestones-form').serialize(),
			success:function(data){
				if (!data.success) {
					jQuery('.milestones .control-group').removeClass('error');
					jQuery('.milestones .help-inline').hide();
					for(var fields in data.error) {
						jQuery('#'+fields).closest('.control-group').addClass('error');
						jQuery('#'+fields).next().html(data.error[fields][0]).show();
					}
				}
				else {
					$scope.$apply(function() {
						$location.path('/');
						sharedService.broadcast(true);
					});
				}
			}
		});
	};
});