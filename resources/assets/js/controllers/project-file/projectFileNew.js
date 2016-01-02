angular.module('app.controllers')
	.controller('ProjectFileNewController',
		['$scope','$routeParams','$location','Url','appConfig','Upload',
		 function($scope,$routeParams,$location,Url,appConfig, Upload){
			
		$scope.projectFile = {
			project_id: $routeParams.id
		};
		
		$scope.save = function(){
			if($scope.form.$valid){
				var url = appConfig.baseUrl + 
					Url.getUrlFromUrlSymbol(appConfig.urls.projectFile,{
						id: $routeParams.id, 
						idFile: ''
						});
				
				Upload.upload({
		            url: url,
		            fields : {
		            	'file': $scope.projectFile.file, 
		            	'name': $scope.projectFile.name,
		            	'description': $scope.projectFile.description,
		            	'project_id': $routeParams.id
		            },
		            file: $scope.projectFile.file
		            
		        }).success(function (data, status, headers, config) {

					$location.path('/project/'+ $routeParams.id + '/files');

		        });
			}
		};
}]);