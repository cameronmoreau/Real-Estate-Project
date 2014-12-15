<!DOCTYPE html>
<html lang="en">
<head>
	<title>Real Estate Website</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body ng-app="app" ng-controller="homeController">
	<div class="container-fluid">
		<h1>Hello</h1>
		<p>Go ahead an try searching for a specific location. Don't worry about any special formatting, we'll know what you mean.</p>

		<div class="row">
			<div class="col-md-12">
				<form ng-submit="search()" class="input-group">
					<input type="text" placeholder="Address" ng-model="search.address" class="form-control">
					<div class="input-group-btn">
						<input type="submit" value="Search" class="btn btn-default">
					</div>
				</form>
			</div>
		</div>

		<!-- Multiple Results from search -->
		<div class="row" ng-show="results.address.length > 1">
			<div class="col-md-12">
				<h3>Multiple Results Found <small>Select the one you really meant</small></h3>
				<table class="table table-hover">
					<tr ng-repeat="(key, value) in results.address">
						<td>
							<strong>{{ value.formatted_address }}</strong><br>
							<span ng-repeat="types in value.types">{{ types }} </span>
						</td>
						<td>
							<button class="btn btn-default" ng-click="strip_to_address(key)">
								<i class="glyphicon glyphicon-ok"></i>
							</button>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<!-- Selected Address -->
		<div class="row" ng-show="results.address.formatted_address">
			<!-- Address Info -->
			<div class="col-md-6">
				<h3>Selected Address</h3>
				<table class="table table-striped">
					<tr>
						<td>Address</td>
						<td>{{ results.address.formatted_address }}</td>
					</tr>
					<tr>
						<td>County</td>
						<td>{{ results.address.county }}</td>
					</tr>
					<tr>
						<td>Coords</td>
						<td>
							<strong>Lat:</strong> {{ results.address.geometry.location.lat }},<br>
							<strong>Lng:</strong> {{ results.address.geometry.location.lng }}
						</td>
					</tr>
				</table>
			</div>

			<!-- Address Map -->
			<h3>Map</h3>
		</div>
	</div>

	<script type="text/javascript" src="bower_components/angular/angular.js"></script>
	<script type="text/javascript" src="bower_components/angular-route/angular-route.js"></script>
	<script type="text/javascript" src="js/app.js"></script>
	<script type="text/javascript" src="js/controller.js"></script>
</body>
</html>