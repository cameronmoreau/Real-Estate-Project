<!DOCTYPE html>
<html>
<head>
	<title>Real Estate Website</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body ng-app="app" ng-controller="homeController">
	<div class="wrapper">
		<h1>Hello</h1>

		<form ng-submit="search()">
			Search
			<input type="text" placeholder="Address" ng-model="search.address" />
			<input type="text" placeholder="Zipcode" ng-model="search.zip" />
			<input type="submit" />
		</form>

		<table ng-show="showData">
			<tr>
				<td>Response</td>
				<td>{{ results.message.text }}</td>
			</tr>
		</table>
	</div>

	<script type="text/javascript" src="bower_components/angular/angular.js"></script>
	<script type="text/javascript" src="bower_components/angular-route/angular-route.js"></script>
	<script type="text/javascript" src="js/app.js"></script>
	<script type="text/javascript" src="js/controller.js"></script>
</body>
</html>