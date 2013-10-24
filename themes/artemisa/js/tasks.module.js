var Celestic = angular.module('celestic', []);

Celestic.config(
	function($routeProvider) {
	$routeProvider.otherwise({
		redirectTo: '/',
		controller: 'celestic.tasks.home.controller'
	});
});

/**
 * [description]
 * @param  {[type]} $scope        [description]
 * @param  {[type]} $http         [description]
 * @return {[type]}               [description]
 */
Celestic.controller('celestic.tasks.home.controller', function($scope, $http) {
	$scope.ishome = true;
	$scope.tasks = [];
	$scope.hasTasks = false;
	$scope.tasksForm = false;

	jQuery.ajax({
		type: 'POST',
		dataType:'json',
		url: CelesticParams.URL.home,
		data: {
			YII_CSRF_TOKEN: CelesticParams.Forms.CSRF_Token
		},
		success:function(data) {
			$scope.$apply(function() {
				if (data.tasks.length > 0) {
					$scope.hasTasks = true;
				}
				$scope.tasks = data.tasks;
			});
		}
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
						$scope.tasks.push(data.task);
						$scope.tasksForm = false;
					});
				}
			}
		});
	};
});