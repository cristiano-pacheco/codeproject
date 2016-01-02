angular.module('app.controllers')
.controller('ProjectMemberRemoveController',
	['$scope','$location','$routeParams','ProjectMember', function($scope,$location,$routeParams,ProjectMember){
			
		$scope.projectMember = new ProjectMember.get({
			id: $routeParams.id,
			idProjectMember: $routeParams.idProjectMember
		});

		$scope.remove = function(){
			$scope.projectMember.$delete({
				id: $routeParams.id,
				idProjectMember: $routeParams.idProjectMember
			}).then(function(){
				$location.path('/project/'+ $routeParams.id + '/members');
			});
		};
}]);