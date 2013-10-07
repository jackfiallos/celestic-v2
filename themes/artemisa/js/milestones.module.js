var Celestic = angular.module('celestic', []);

Celestic.config(
	function($routeProvider) {
	$routeProvider.when('/view/:id', {
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
	$scope.milestones = [];
	$scope.hasMilestones = false;
	$scope.milestonesForm = false;

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

	$scope.submitForm = function() {
		jQuery.ajax({
			type: 'POST',
			dataType:'json',
			url: jQuery('#milestones-form-create').attr('action'),
			data: jQuery('#milestones-form-create').serialize(),
			success:function(data){
				if (!data.success) {
					jQuery('#milestones-form-create .control-group').removeClass('error');
					jQuery('#milestones-form-create .help-inline').hide();
					for(var fields in data.error) {
						jQuery('#milestones-form-create #milestones-form-create_Milestones_'+fields).closest('.control-group').addClass('error');
						jQuery('#milestones-form-create #milestones-form-create_Milestones_'+fields).next().html('<label class="labelhelper" for="'+fields+'">'+data.error[fields][0]+'</label>').show();
					}
				}
				else {
					$scope.$apply(function() {
						$scope.milestones.push(data.milestones);
						$scope.milestonesForm = false;
					});
				}
			}
		});
	};
});

Celestic.controller('celestic.milestones.view.controller', function($scope, $route, $routeParams, sharedService) {
	$scope.milestone = {};
	$scope.milestonesForm = false;

	var id = ($routeParams.id || '');

	sharedService.broadcast(false);

	jQuery.ajax({
		type: 'POST',
		dataType:'json',
		url: CelesticParams.URL.view+'&id='+id,
		data: {
			YII_CSRF_TOKEN: CelesticParams.Forms.CSRF_Token
		},
		success:function(data) {
			$scope.$apply(function() {
				$scope.milestone = data.milestone;
				$scope.tasks = data.milestone.dataProviderTasks;
			});
		}
	});

	$scope.showHome = function() {
		sharedService.broadcast(true);
	};

	$scope.showUpdate = function() {
		$scope.milestonesForm = true;
	};

	$scope.submitForm = function() {
		jQuery.ajax({
			type: 'POST',
			dataType:'json',
			url: $scope.milestone.url,
			data: jQuery('#milestones-form-update').serialize(),
			success:function(data) {
				if (!data.success) {
					jQuery('#milestones-form-update .control-group').removeClass('error');
					jQuery('#milestones-form-update .help-inline').hide();
					for(var fields in data.error) {
						jQuery('#milestones-form-update #'+fields).closest('.control-group').addClass('error');
						jQuery('#milestones-form-update #'+fields).next().html('<label class="labelhelper" for="'+fields+'">'+data.error[fields][0]+'</label>').show();
					}
				}
				else {
					$scope.$apply(function() {
						$scope.milestone = data.milestone;
						$scope.milestonesForm = false;
					});
				}
			}
		});
	};
});