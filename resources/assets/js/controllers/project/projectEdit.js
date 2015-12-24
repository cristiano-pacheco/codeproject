angular.module('app.controllers')
.controller('ProjectEditController',['$scope','$routeParams','$location','Project','Client','appConfig','$cookies',
                                     function($scope,$routeParams,$location,Project,Client,appConfig,$cookies){
	$scope.project = new Project.get({id: $routeParams.id});
	$scope.clients = Client.query();
	$scope.status = appConfig.project.status;
	
	$scope.save = function(){
		if($scope.form.$valid){
			
			$scope.project.owner_id = $cookies.getObject('user').id;
			
			Project.update({id: $scope.project.id},$scope.project,function(){
				$location.path('/projects');
			});
		}
	};
}]);