angular.module('app-module', ['bootstrap-modal','ui.bootstrap','block-ui']).factory('app', function($http,$timeout,$compile,bui) {

	function app() {

		var self = this;				

		self.data = function(scope) {

			scope.views = {};
			scope.views.currentPage = 1;

			scope.reg_jobseeker = {};
			scope.reg_jobseeker.SeekerID = 0;			
			
			scope.profiles = [];

		};

		self.list = function(scope) {
			
			bui.show();
			
			if (scope.$id > 2) scope = scope.$parent;			
			
			scope.currentPage = scope.views.currentPage;
			scope.pageSize = 25;
			scope.maxSize = 5;			
			
			$http({
			  method: 'GET',
			  url: 'handlers/profiles.php'
			}).then(function success(response) {
				
				scope.profiles = angular.copy(response.data);
				scope.filterData = scope.profiles;
				scope.currentPage = scope.views.currentPage;
				
				bui.hide();
				
			}, function error(response) {
				
			});			
			
			$('#content').load('lists/profiles.html',function() {
				$timeout(function() { $compile($('#content')[0])(scope); }, 500);
			});			
			
		};
		
		self.jobSeeker = function(scope,row) {			
			
			bui.show();
			
			$('#content').load('forms/profile.html',function() {
				$timeout(function() { $compile($('#content')[0])(scope); bui.hide(); }, 500);
			});				
			
		};
		
		self.cancel = function(scope) {
			
			scope.reg_jobseeker = {};
			scope.reg_jobseeker.SeekerID = 0;			
			
			self.list(scope);
			
		};
		
		self.delete = function(scope) {
			
		};
		
	};
	
	return new app();
	
});