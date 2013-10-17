var Celestic = angular.module('celestic', []);

Celestic.config(
	function($routeProvider) {
	$routeProvider.when('/view/:id', {
		templateUrl: CelesticParams.URL.view,
		controller: 'celestic.cases.view.controller'
	})
	.otherwise({
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
			url: jQuery('#cases-form-create').attr('action'),
			data: jQuery('#cases-form-create').serialize(),
			success:function(data){
				if (!data.success) {
					jQuery('#cases-form-create .control-group').removeClass('error');
					jQuery('#cases-form-create .help-inline').hide();
					for(var fields in data.error) {
						jQuery('#cases-form-create #cases-form-create_'+fields).closest('.control-group').addClass('error');
						jQuery('#cases-form-create #cases-form-create_'+fields).next().html('<label class="labelhelper" for="'+fields+'">'+data.error[fields][0]+'</label>').show();
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