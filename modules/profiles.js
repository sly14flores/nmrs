angular.module('app-module', ['bootstrap-modal','ui.bootstrap','block-ui','bootstrap-growl','bootstrap-modal','form-validator','window-open-post']).factory('app', function($http,$timeout,$compile,bui,growl,bootstrapModal,validate,printPost) {

	function app() {

		var self = this;				

		self.data = function(scope) {

			scope.formHolder = {};
			
			scope.views = {};
			scope.views.currentPage = 1;

			scope.views.list = true;
			
			scope.btns = {
				ok: {disabled: false, label: 'Save'},
				cancel: {disabled: false, label: 'Cancel'}
			};

			scope.reg_jobseeker = {};
			scope.reg_jobseeker.SeekerID = 0;			
			
			scope.profiles = [];
			
			var d = new Date();

			scope.months = [
				{month:"-",description:"All"},
				{month:"01",description:"January"},
				{month:"02",description:"February"},
				{month:"03",description:"March"},
				{month:"04",description:"April"},
				{month:"05",description:"May"},
				{month:"06",description:"June"},
				{month:"07",description:"July"},
				{month:"08",description:"August"},
				{month:"09",description:"September"},
				{month:"10",description:"October"},
				{month:"11",description:"November"},
				{month:"12",description:"December"}
			];

			scope.filter = {
				year: d.getFullYear(),
				month: scope.months[0]
			};

		};

		self.list = function(scope) {
			
			bui.show();
			
			if (scope.$id > 2) scope = scope.$parent;			
			
			scope.views.list = true;			
			
			scope.reg_jobseeker = {};
			scope.reg_jobseeker.SeekerID = 0;				
			
			scope.currentPage = scope.views.currentPage;
			scope.pageSize = 25;
			scope.maxSize = 5;			
			
			$http({
			  method: 'POST',
			  url: 'handlers/profiles.php',
			  data: scope.filter
			}).then(function success(response) {
				
				scope.profiles = angular.copy(response.data);
				scope.filterData = scope.profiles;
				scope.currentPage = scope.views.currentPage;
				
				bui.hide();
				
			}, function error(response) {
				
				bui.hide();

			});			
			
			$('#content').load('lists/profiles.html',function() {
				$timeout(function() { $compile($('#content')[0])(scope); }, 500);
			});			
			
		};
		
		function mode(scope,row) {
			
			if (row != null) {

				scope.btns = {
					ok: {disabled: false, label: 'Update'},
					cancel: {disabled: false, label: 'Close'}
				};				
			
			
			} else {
				
				scope.btns = {
					ok: {disabled: false, label: 'Save'},
					cancel: {disabled: false, label: 'Cancel'}
				};				
				
			};
			
		};
		
		self.jobSeeker = function(scope,row) {			
			
			bui.show();
			
			scope.views.list = false;
			
			mode(scope,row);
			
			$('#content').load('forms/profile.html',function() {
				$timeout(function() {
					
					$compile($('#content')[0])(scope);
					
					if (row != null) {
						
						$http({
						  method: 'POST',
						  url: 'handlers/view.php',
						  data: {where: {SeekerID: row.SeekerID}, model: model(scope,'reg_jobseeker',["SeekerID"])}
						}).then(function success(response) {
							
							scope.reg_jobseeker = angular.copy(response.data);
							if (scope.reg_jobseeker.DateRegistered) scope.reg_jobseeker.DateRegistered = new Date(scope.reg_jobseeker.DateRegistered);
							if (scope.reg_jobseeker.DateOfBirth) scope.reg_jobseeker.DateOfBirth = new Date(scope.reg_jobseeker.DateOfBirth);
							bui.hide();							
							
						}, function error(response) {
							
							bui.hide();				
							
						});
						
					} else {
						
						scope.reg_jobseeker = {};
						scope.reg_jobseeker.SeekerID = 0;						
						
					};
					
					bui.hide();
					
				}, 500);
			});						
			
		};
		
		self.cancel = function(scope) {			
			
			scope.reg_jobseeker = {};
			scope.reg_jobseeker.SeekerID = 0;			
			
			self.list(scope);
			
		};
		
		self.save = function(scope) {

			if (validate.form(scope,'reg_jobseeker')) {
				growl.show('danger',{from: 'top', amount: 55},'Some fields are required');				
				return;
			};

			$http({
			  method: 'POST',
			  url: 'handlers/save.php',
			  data: scope.reg_jobseeker
			}).then(function success(response) {
				
				bui.hide();
				if (scope.reg_jobseeker.SeekerID == 0) growl.show('success',{from: 'top', amount: 55},'New profile successfully added');				
				else growl.show('success',{from: 'top', amount: 55},'Profile info successfully updated');				
				self.list(scope);								
				
			}, function error(response) {
				
				bui.hide();				
				
			});				
			
		};
		
		self.delete = function(scope,row) {
			
			var onOk = function() {
				
				$http({
					method: 'POST',
					url: 'handlers/delete.php',
					data: {SeekerID: row.SeekerID}
				}).then(function mySuccess(response) {

					self.list(scope);

				}, function myError(response) {

				});

			};

			bootstrapModal.confirm(scope,'Confirmation','Are you sure you want to delete this profile?',onOk,function() {});			
			
		};

		function model(scope,form,model) {
			
			angular.forEach(scope.formHolder[form].$$controls,function (elem,i) {
				
				model.push(elem.$$attr.name);
				
			});
			
			return model;
			
		};
		
		self.export = function(scope) {
			
			printPost.show('export.php',scope.filter);
			
		};
		
	};
	
	return new app();
	
});