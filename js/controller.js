angular.module('app.controllers', [])
.controller('homeController', ['$scope', '$http', function($scope, $http) {
	$scope.results = {};

	$scope.search = function() {
		$scope.results = {};
		var newAddress = $scope.search.address.split(' ').join('+');
		
		$http.get('php/api/google_geocoding.php?address=' + newAddress).
			success(function(data) {
				//Error checking
				if(data.results.length < 1) {
					//No results found from address lookup

				} else if(data.results.length > 1) {
					//Multiple results from address lookup
					$scope.results.address = [];
					angular.forEach(data.results, function(value, key) {
						$scope.results.address.push(value);
					});
				} else {
					//Error checking passed
					$scope.results.address = data.results[0];
					$scope.results.address.county = $scope.find_address_county();
				}
			}).
			error(function(data) {
				console.log('Error with json');
			});
	}

	$scope.strip_to_address = function(key) {
		$scope.results.address = $scope.results.address[key];
		$scope.results.address.county = $scope.find_address_county();
	}

	$scope.find_address_county = function() {
		//Get rid of ng errors
		if(typeof($scope.results.address) == "undefined") return;
		else if(typeof($scope.results.address.address_components) == "undefined") return;

		for(var i = 0; i < $scope.results.address.address_components.length; i++) {
			var name = $scope.results.address.address_components[i].long_name;
			if(name.toLowerCase().indexOf("county") != -1) {
				return name;
			}
		}

		return false;
	}

	$scope.test_scrape = function() {
		var id = "38180500001940000";
		$http.get('php/web_scrape/dallas.php?account='+id).
			success(function(data) {
				$scope.results.property = data;
			}).
			error(function(data) {
				console.log("error getting county");
			});
	}
}]);