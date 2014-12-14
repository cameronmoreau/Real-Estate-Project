angular.module('app.controllers', [])
.controller('homeController', ['$scope', '$http', function($scope, $http) {
	$scope.showData = false;
	$scope.results = [];

	$scope.search = function() {
		$scope.showData = true;

		var newAddress = $scope.search.address.split(' ').join('+');
		
		$http.get('php/api_zillow_search.php?address=' + newAddress + '&zip=' + $scope.search.zip).
			success(function(data) {
				console.log(data);

				$scope.results = data;
				console.log($scope.results);
			}).
			error(function(data) {
				console.log("Error with json");
			});
	}
}]);