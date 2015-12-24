angular.module('app.services')
.service('Project',['$resource','appConfig','$filter','$httpParamSerializer',function($resource, appConfig,$filter,$httpParamSerializer){
	
	function transformData(data){
		if(angular.isObject(data) && data.hasOwnProperty('due_date')){
			var obj = angular.copy(data);
			obj.due_date = $filter('date')(obj.due_date,'yyyy-MM-dd');
			return appConfig.utils.transformRequest(obj);
		}
		return data;
	};
	
	return $resource(appConfig.baseUrl + '/project/:id',{id: '@id'},{

		update: {
			method:'PUT',
			transformRequest: transformData
		},
		save: {
			method: 'POST',
			transformRequest: transformData
		},
		get: {
			method: 'GET',
			transformResponse: function(data, headers){
				var obj = appConfig.utils.transformResponse(data,headers);
				if(angular.isObject(obj) && obj.hasOwnProperty('due_date')){
					var arrayDate = obj.due_date.split('-');
					var month = parseInt(arrayDate[1]) -1;
					obj.due_date = new Date(arrayDate[0],month,arrayDate[2]);
				}
				return obj;
			}
		}
	});
}]);