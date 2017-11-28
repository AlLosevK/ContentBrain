<?php require('../config.php'); 
//if logged in redirect to members page
if($_SESSION['admin']!='admin' || empty($_SESSION['adminuser'])) { header('Location: login.php'); } 

$title = "Articles List";
?>

<?php include("header.php"); ?>

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
							<span class="btn btn-default active">Articles</span>
						</div>
					</div>
				   <!-- close breadcrumbs -->
				 <div class="col-md-6 col-md-offset-7 text-right"><a href='upload_csv_Article.php' class="btn btn-primary">Upload CSV</a> <a href='addArticle.php' class="btn btn-primary">Add New Article</a></div>  
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-4">
							<div class="row">
								<h2>Articles List</h2>
							</div>
						</div>
					</div>
				<!--<div class="col-md-1 col-md-offset-6"><a href='addClient.php' class="btn btn-primary">Add New Client</a></div>-->
				</div>
					<div style="clear:both"></div>	
					 <!-- Filter -->
					 <div class="table-responsive" ng-app="myApp" ng-controller="ArticleCrtl" ng-cloak>
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
								<input type="text" ng-model="search" ng-change="filter()" placeholder="Search Article.." class="form-control" />
							</div>
							<div class="col-md-4">
								<h5>Filtered {{ filtered.length }} of {{ totalItems}} total Articles</h5>
							</div>
						</div>
						<br/>
						 
						  <div ng-show="filteredItems > 0" class="overflowX">
								<table class="table table-striped table-bordered">
								<thead>
								 <th>Id</th>
								 <th>Type</th>
								 <th>Title</th>
								 <th>Action</th>
								</thead>
								<tbody>
									<tr ng-repeat="data in filtered = (list | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit">
										<td>{{data.id}}</td>
										<td>{{data.type}}</td>
										<td>{{data.title}}</td>
										<td>
										 <a title="Edit" href='editArticle.php?id={{data.id}}' class="btn btn-primary edit_a" ><i class="glyphicon glyphicon-edit"></i></a>
										</a>
										 <a title="Delete" class="btn btn-danger btncolor edit_a" ng-click="delete(data)"><i class="glyphicon glyphicon-trash"></i></a>
										</td>
										
									</tr>
								</tbody>
								</table>
							</div>
							<div class="col-md-12" ng-show="filteredItems == 0">
								<div class="col-md-12">
									<h4>No Articles found</h4>
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

