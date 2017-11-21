<?php include("header.php"); 
$thisPage="Users";
?>

<style>
.edit_a
{
	height: 30px;
    margin-bottom: 10px;
    padding: 4px 0;
    text-align: center;
    width: 30px;
}
@media (max-width: 1200px)
{
	.overflowX
	{
		overflow:hidden;
		overflow-x:scroll;
	}
}
</style>
<div class="container">
	<div class="page-content">
			<div class="row">
			  <div class="col-md-3 col-lg-2">
				<?php include("left_navigation.php"); ?>
			  </div>
			  
			  <div class="col-md-9 col-lg-10">
			  
					<!-- breadcrumb-->
					<div class="row">
						 <div class="col-md-12 btn-group btn-breadcrumb">
							<span class="btn btn-default"><a href="index.php"><i class="glyphicon glyphicon-home"></i></a></span>
							<span class="btn btn-default active">Users</span>
						</div>
					</div>
				   <!-- close breadcrumbs -->
				 <div class="col-md-6 col-md-offset-7 text-right"> <a href='addUser.php' class="btn btn-primary">Add New User</a></div>    
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-4">
							<div class="row">
								<h2>Users Information</h2>
							</div>
						</div>
					</div>
				<!--<div class="col-md-1 col-md-offset-6"><a href='adduser.php' class="btn btn-primary">Add New user</a></div>-->
				</div>
					<div style="clear:both"></div>	
					 <!-- Filter -->
					 <div class="table-responsive" ng-app="myApp" ng-controller="userCrtl" ng-cloak>
					   <div class="row">
					   <div class="alert alert-danger none"><p></p></div>
						<div class="alert alert-success none"><p></p></div>
							<div class="col-md-2 mq-mb-10">
								<select ng-model="entryLimit" class="form-control">
									<option>5</option>
									<option>10</option>
									<option>20</option>
									<option>50</option>
									<option>100</option>
								</select>
							</div>
							<div class="col-md-3">
								<input type="text" ng-model="search" ng-change="filter()" placeholder="Search user.." class="form-control" />
							</div>
							<div class="col-md-4">
								<h5>Filtered {{ filtered.length }} of {{ totalItems}} total Users</h5>
							</div>
						</div>
						<br/>
						 
						  <div ng-show="filteredItems > 0" class="overflowX">
								<table class="table table-striped table-bordered">
								<thead>
								 <th>Id</th>
								 <th>Name</th>
								 <th>E-mail Address</th>
								 <th>Profile Image</th>
								 <th>URL</th>
								 <th>Status&nbsp;<a ng-click="sort_by('status');"><i class="glyphicon glyphicon-sort"></i></a></th>
								 <th>Action</th>
								</thead>
								<tbody>
									<tr ng-repeat="data in filtered = (list | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit" ng-click="view(data.uid)">
										<td>{{data.id}}</td>
										<td>{{data.name}}</td>
										<td>{{data.email}}</td>
										<td>
											<img ng-src="{{data.profile_image}}" width='100px' height='100px' ng-if="data.profile_image">
											 <span ng-if="!data.profile_image"><img ng-src="images/not-available.jpg" width='100px' height='100px'></span>
										</td>
										<td>{{data.url}}</td>
										<td>
											<a ng-if="data.status==0" ng-click="showconfirmbox('activate',data.name,data.id,$event); $event.stopPropagation();" title="Click to activate" class="btn btn-danger"> Deactive </a>
											<a ng-if="data.status==1" ng-click="showconfirmbox('deactivate',data.name,data.id,$event); $event.stopPropagation();" title="Click to deactivate" class="btn btn-primary"> Active </a>
										
										</td>
										<td>
										 <a title="Edit" href='editUser.php?uid={{data.id}}' class="btn btn-primary edit_a" ><i class="glyphicon glyphicon-edit"></i></a>
										</a>
										
										</td>
									</tr>
								</tbody>
								</table>
							</div>
							<div class="col-md-12" ng-show="filteredItems == 0">
								<div class="col-md-12">
									<h4>No Users found</h4>
								</div>
							</div>
							<div class="col-md-12" ng-show="filteredItems > 0">    
								<div pagination="" page="currentPage" on-select-page="setPage(page)" boundary-links="true" total-items="filteredItems" items-per-page="entryLimit" class="pagination-small" previous-text="&laquo;" next-text="&raquo;"></div>
								
								
							</div>
		
		
					</div>
					<!-- End Filter -->
				
				  
			</div>
		</div>
	</div>
</div>
	
 <script src="assets/angular/angular.min.js"></script>
 <script src="assets/angular/ui-bootstrap-tpls-0.10.0.min.js"></script>
 <script src="assets/angular/app.js"></script>
<?php include("footer.php"); ?>

