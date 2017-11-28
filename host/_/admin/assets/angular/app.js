var app = angular.module('myApp', ['ui.bootstrap']);

app.filter('startFrom', function() {
    return function(input, start) {
        if(input) {
            start = +start; //parse to int
            return input.slice(start);
        }
        return [];
    }
});

/* For Client */
app.controller('userCrtl', function ($scope, $http, $timeout,$window) {
	 var showClient = function(){
      $http.get('ajax/getUsers.php').success(function(data){
            $scope.list = data;
			$scope.currentPage = 1; //current page
			$scope.entryLimit = 50; //max no of items to display in a page
			$scope.filteredItems = $scope.list.length; //Initially for no filter  
			$scope.totalItems = $scope.list.length;
         })
   };
   showClient(); //first load
   
   $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
    };
    $scope.filter = function() {
        $timeout(function() { 
            $scope.filteredItems = $scope.filtered.length;
        }, 10);
    };
    $scope.sort_by = function(predicate) {
        $scope.predicate = predicate;
        $scope.reverse = !$scope.reverse;
    };
	$scope.showconfirmbox = function(nstatus,name,uid,$event){
		 //$window.location.href = 'viewclientDetails.php?uid='+ uid;
		 if (confirm("Are you sure you want to "+nstatus+" the "+name+" ?")) {
			$http({
				url: 'ajax/getUsers.php',
				method: "POST",
				data:  $.param({'uid' : uid,'type':'checkStatus' }),
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				})
				.success(function(response) {
					if(response.status == 1){
						showClient();
						$scope.messageSuccess(response.msg);
					}
					
			});
          }
		else
		{
			 $event.preventDefault();
		}	
	 };	
	
	 $scope.deletedata = function (row) {
		 alert("hello");
    };
	
	 // function to display success message
    $scope.messageSuccess = function(msg){
        $('.alert-success > p').html(msg);
        $('.alert-success').show();
        $('.alert-success').delay(5000).slideUp(function(){
            $('.alert-success > p').html('');
        });
    };
	
});

/* for Article */
app.controller('ArticleCrtl', function ($scope, $http, $timeout,$window,$location) {
	var showArticle = function(){
      $http.get('ajax/getArticles.php').success(function(data){
            $scope.list = data;
			$scope.currentPage = 1; //current page
			$scope.entryLimit = 50; //max no of items to display in a page
			$scope.filteredItems = $scope.list.length; //Initially for no filter  
			$scope.totalItems = $scope.list.length;
         })
   };
   showArticle(); //first load
   
    $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
    };
    $scope.filter = function() {
        $timeout(function() { 
            $scope.filteredItems = $scope.filtered.length;
        }, 10);
    };
    $scope.sort_by = function(predicate) {
        $scope.predicate = predicate;
        $scope.reverse = !$scope.reverse;
    };
	
	 $scope.delete = function (row) {
		 if (confirm("Are you sure you want to delete this record?")) {
			$http({
				url: 'ajax/getArticles.php',
				method: "POST",
				data:  $.param({'id' : row.id,'type':'delete' }),
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				})
				.success(function(response) {
					if(response.status == 1){
						showArticle();
						$scope.messageSuccess(response.msg);
					}
					
			});
          }
		else
		{
			 $event.preventDefault();
		}	
    };
	
	// function to display success message
    $scope.messageSuccess = function(msg){
        $('.alert-success > p').html(msg);
        $('.alert-success').show();
        $('.alert-success').delay(5000).slideUp(function(){
            $('.alert-success > p').html('');
        });
    };
});


