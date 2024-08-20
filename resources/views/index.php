<!DOCTYPE html>
<html lang="en-US">
<head>
   <title>The Amazing PHP - AngularJS Single-page Application with Lumen CRUD Services</title>
 
   <!-- Load Bootstrap CSS -->
   <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

   <div ng-app="myApp" ng-controller="usersCtrl">
      
      <!-- There will be a table, to dispay the data, here -->
	  <table class="table">
      <thead>
         <tr>
            <th>ID</th>
            <th>Kategori</th>
            <th>Name</th>
            <th>Alamat</th>
            <th>Latittude</th>
            <th>Longitude</th>
            <th>Content</th>
            <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add',0)">Add New User</button></th>
         </tr>
      </thead>
      <tbody>
         <tr ng-repeat="user in users">
            <td>{{ $index + 1 }}</td>
            <td>{{ user.kategori }}</td>
            <td>{{ user.nama }}</td>
            <td>{{ user.alamat }}</td>
            <td>{{ user.latittude }}</td>
            <td>{{ user.longitude }}</td>
            <td>{{ user.content }}</td>
            <td>
               <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit',user.id)">Edit</button>
               <button class="btn btn-danger btn-xs btn-delete" ng-click="confirmDelete(user.id)">Delete</button>
            </td>
         </tr>
      </tbody>
   </table>

      <!-- There will be a modal to pop-up a Form (One form used as a create and edit form) -->
   <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="myModalLabel">{{state}}</h4>
            </div>
            <div class="modal-body">
               <form class="form-horizontal">

                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-3 control-label">Name</label>
                     <div class="col-sm-9">
                        <input type="text" class="form-control" id="inputEmail3" placeholder="Fullname" value="{{name}}" ng-model="formData.name">
                     </div>
                  </div>

                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-3 control-label">Kategori</label>
                     <div class="col-sm-9">
                        <input type="text" class="form-control" id="inputEmail3" placeholder="Email Address" value="{{kategori}}" ng-model="formData.kategori">
                     </div>
                  </div>

                  <div class="form-group">
                     <label for="inputPassword3" class="col-sm-3 control-label">Alamat</label>
                     <div class="col-sm-9">
                        <input type="password" class="form-control" id="inputPassword3" placeholder="Leave empty to unchange" ng-model="formData.alamat">
                     </div>
                  </div>

                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-3 control-label">Latittude</label>
                     <div class="col-sm-9">
                        <input type="text" class="form-control" id="inputEmail3" placeholder="Phone Number" value="{{latittude}}" ng-model="formData.latittude">
                     </div>
                  </div>

                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-3 control-label">Longitude</label>
                     <div class="col-sm-9">
                        <textarea class="form-control" placeholder="Full Address" ng-model="formData.longitude">{{longitude}}</textarea>
                     </div>
                  </div>

               </form>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate,user_id)">Save changes</button>
            </div>
         </div>
      </div>
   </div>
   
   </div>
   <div ng-controller="MapController">
    <div id="map"></div>
    <div id="repeat" ng-repeat="marker in markers | orderBy : 'title'">
         <a id="country_container" href="#" ng-click="openInfoWindow($event, marker)">
         <label id="names" >{{marker.title}}</label></a>
    </div>
	</div>
   <!-- Load Javascript Libraries (AngularJS, JQuery, Bootstrap) -->
   <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="map.css">
	<script	src="http://maps.googleapis.com/maps/api/js?sensor=false&language=en"></script>
	<script type="text/javascript" src="map.js"></script>
   <!-- There will be our javascript Application here -->
	<script>
	   var app = angular.module('myApp', []);
	   app.controller('usersCtrl', function($scope, $http) {

		  /* The -R- part */
		  $http.get("http://10.10.10.215/read-users")
		  .success(function(response) {
			 $scope.users = response;
		  });
		  /* End of the -R- part */
			 
		  /* The -C- and -U- part */
			 $scope.save = function(modalstate,user_id){
				switch(modalstate){
				   case 'add': var url = "http://10.10.10.215/create-user"; break;
				   case 'edit': var url = "http://10.10.10.215/edit-user/"+user_id; break;
				   default: break;
				}
				$http({
				   method  : 'POST',
				   url     : url,
				   data    : $.param($scope.formData),  // pass in data as strings
				   headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
				}).
				success(function(response){
				   location.reload();
				}).
				error(function(response){
				   console.log(response);
				   alert('Incomplete Form');
				});
			 }
		  /* End of the -C- and -U- part */

		  /* The -D- Part */
			 $scope.confirmDelete = function(id){
				var isOkDelete = confirm('Is it ok to delete this?');
				if(isOkDelete){
				   $http.post('http://10.10.10.215/delete-user', {id:id}).
				   success(function(data){
					  location.reload();
				   }).
				   error(function(data) {
					  console.log(data);
					  alert('Unable to delete');
				   });
				} else {
				   return false;
				}
			 }
		  /* End of the -D- Part */

		  /* Show the modal */
		  $scope.toggle = function(modalstate,id) {
				$scope.modalstate = modalstate;
				switch(modalstate){
				   case 'add':
							   $scope.state = "Add New User";
							   $scope.user_id = 0;
							   $scope.kategori = '';
							   $scope.nama = '';
							   $scope.alamat = '';
							   $scope.latittude = '';
							   $scope.longitude = '';
							   break;
				   case 'edit':
							   $scope.state = "User Detail";
							   $scope.user_id = id;
							   $http.get("http://10.10.10.215/read-user/" + id)
							   .success(function(response) {
								  console.log(response);
								  $scope.formData = response;
							   });
							   break;
				   default: break;
				}
				
				//console.log(id);
				$('#myModal').modal('show');
			 }
	   });
	</script>
	
</body>
</html>