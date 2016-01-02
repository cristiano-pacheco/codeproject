angular.module('app.services')
.service('ProjectFile',['$resource','appConfig','Url',function($resource, appConfig, Url){
	var url = appConfig.baseUrl + '/project/:id/file/:idFile';
	return $resource(url,
		{id: '@id',idFile: '@idFile'},{
		update: {
			method:'PUT'
		},
		download: {
			url: url + '/download',
			method: 'GET'
		}
	});
}]);