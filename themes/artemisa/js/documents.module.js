var Celestic = angular.module('celestic', []);

Celestic.config(
	function($routeProvider) {
	$routeProvider.when('/create', {
		templateUrl: CelesticParams.URL.create,
		controller: 'celestic.documents.create.controller'
	})
	.when('/view/:id', {
		templateUrl: CelesticParams.URL.view,
		controller: 'celestic.documents.view.controller'
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
		broadcast: function(value, newObject) {
			$rootScope.$broadcast('handleBroadcast', value, newObject);
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
	$scope.documents = null;
	$scope.labels = null;
	$scope.hasDocuments = false;
	$scope.timestamp = '';

	$scope.CreateHeader = function(timestamp) {
		showHeader = (timestamp != $scope.timestamp);
		$scope.timestamp = timestamp;
		return showHeader;
	};

	jQuery.ajax({
		type: 'POST',
		dataType:'json',
		url: CelesticParams.URL.home,
		data: {
			YII_CSRF_TOKEN: CelesticParams.Forms.CSRF_Token
		},
		success:function(data) {
			$scope.$apply(function() {
				if (data.documents.length > 0) {
					$scope.hasDocuments = true;
				}
				$scope.documents = data.documents;
				$scope.labels = data.labels;
			});
		}
	});
	
	$scope.$on('handleBroadcast', function(event, value, createdObject) {
		$scope.ishome = value;
		if (typeof(createdObject) != 'undefined') {
			$scope.documents.unshift(createdObject);
		}
	});
});

Celestic.controller('celestic.documents.view.controller', function($scope, $route, $routeParams, sharedService) {
	$scope.document_name = 'asdf';
	$scope.document_description = '';
	$scope.document_uploadDate = '';
	$scope.document_download = '';
	$scope.userUrl = '';
	$scope.userName = '';

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
				$scope.document_download = data.document_download;
				$scope.userUrl = data.userUrl;
				$scope.userName = data.userName;
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
Celestic.controller('celestic.documents.create.controller', function($scope, $http, $location, sharedService) {
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
		fd.append('Documents[image]', jQuery('#Documents_image').prop('files')[0]);

		var a = {
			description: "un documento del que desconozco su contenido",
			downloadLink: "/?r=documents/default/download&id=4",
			id: "4",
			imageType: "/themes/artemisa/images/icons/XLSX.png",
			name: "MAR-APM-PTE-002.xlsx",
			timestamp: "September 7, 2013",
			url: "/?r=documents/default/index#/view/4",
			userName: "Jack",
			userUrl: "/?r=documents/users/view&id=1"
		};

		jQuery.ajax({
			type: 'POST',
			dataType:'json',
			processData: false,
			contentType: false,
			url: jQuery('#documents-form').attr('action'),
			data: fd,
			success:function(data){
				if (!data.success) {
					for(var fields in data.error) {
						jQuery('#'+fields).closest('.control-group').addClass('error');
						jQuery('#'+fields).next().html(data.error[fields][0]);
					}
				}
				else {
					$scope.$apply(function() {
						$location.path('/');
						sharedService.broadcast(true, data.document);
					});
				}
			}
		});
	};
});