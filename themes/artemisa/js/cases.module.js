var Celestic = angular.module('celestic', []);

Celestic.config(
	function($routeProvider) {
	$routeProvider.when('/view/:id', {
		templateUrl: CelesticParams.URL.view,
		controller: 'celestic.cases.view.controller'
	}).otherwise({
		redirectTo: '/',
		controller: 'celestic.cases.home.controller'
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
Celestic.controller('celestic.cases.home.controller', function($scope, $http, sharedService) {
	$scope.ishome = true;
	$scope.cases = [];
	$scope.hasCases = false;
	$scope.casesForm = false;

	jQuery.ajax({
		type: 'POST',
		dataType:'json',
		url: CelesticParams.URL.home,
		data: {
			YII_CSRF_TOKEN: CelesticParams.Forms.CSRF_Token
		},
		success:function(data) {
			$scope.$apply(function() {
				if (data.cases.length > 0) {
					$scope.hasCases = true;
				}
				$scope.cases = data.cases;
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
			url: jQuery('#'+CelesticParams.Forms.createForm).attr('action'),
			data: jQuery('#'+CelesticParams.Forms.createForm).serialize(),
			success:function(data){
				if (!data.success) {
					jQuery('#'+CelesticParams.Forms.createForm+' .control-group').removeClass('error');
					jQuery('#'+CelesticParams.Forms.createForm+' .help-inline').hide();
					for(var fields in data.error) {
						jQuery('#'+CelesticParams.Forms.createForm+' #'+fields).closest('.control-group').addClass('error');
						jQuery('#'+CelesticParams.Forms.createForm+' #'+fields).next().html('<label class="labelhelper" for="'+fields+'">'+data.error[fields][0]+'</label>').show();
					}
				}
				else {
					$scope.$apply(function() {
						$scope.cases.push(data.case);
						$scope.casesForm = false;
					});
				}
			}
		});
	};
});

Celestic.controller('celestic.cases.view.controller', function($scope, $route, $routeParams, sharedService) {
	$scope.case = {};
	$scope.casesForm = false;

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
				$scope.case = data.case;
			});
		}
	});

	$scope.showHome = function() {
		sharedService.broadcast(true);
	};

	$scope.showUpdate = function() {
		$scope.casesForm = true;
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
						$scope.case = data.case;
						$scope.casesForm = false;
					});
				}
			}
		});
	};
});