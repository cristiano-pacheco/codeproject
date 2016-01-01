angular.module('app.services')
.service('ProjectTask',['$resource','appConfig','$filter',function($resource, appConfig, $filter){

	function transformData(data){

		var obj = angular.copy(data);

		if(angular.isObject(data)){

			if(data.hasOwnProperty('due_date')) {
				obj.due_date = $filter('date')(obj.due_date, 'yyyy-MM-dd');
			}

			if(data.hasOwnProperty('start_date')) {
				obj.start_date = $filter('date')(obj.start_date, 'yyyy-MM-dd');
			}
			console.log(appConfig.utils.transformRequest(obj));
			return appConfig.utils.transformRequest(obj);
		}
		console.log(data);
		return data;
	};

	return $resource(appConfig.baseUrl + '/project/:id/task/:idTask',{
		id: '@id',
		idTask: '@idTask'
	},{
		update: {
			method:'PUT'
		},
		get: {
			method: 'GET',
			transformResponse: function(data, headers){

				var obj = appConfig.utils.transformResponse(data,headers);

				if(angular.isObject(obj)){
					if(obj.hasOwnProperty('due_date') && obj.due_date){
						var arrayDate = obj.due_date.split('-');
						var month = parseInt(arrayDate[1]) -1;
						obj.due_date = new Date(arrayDate[0],month,arrayDate[2]);
					}
					if(obj.hasOwnProperty('start_date') && obj.start_date){
						var arrayDate = obj.start_date.split('-');
						var month = parseInt(arrayDate[1]) -1;
						obj.start_date = new Date(arrayDate[0],month,arrayDate[2]);
					}
				}
				return obj;
			}
		},
		update: {
			method:'PUT',
			transformRequest: transformData
		},
		save: {
			method: 'POST',
			transformRequest: transformData
		},
	});
}]);