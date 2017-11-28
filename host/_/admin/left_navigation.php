<style>
.page-content .navbar .collapse{display:none;}
.page-content .navbar, .navbar-inverse {border-radius: 0;border: none;margin-bottom: 0;/*min-height: 80px;*/ }
.page-content .navbar-inverse{background-color:#FFF; }
.page-content .nav li {display: inline;color: white; }
.page-content .navbar-inverse .navbar-nav > li > a { color: #ffffff; font-family: Lato; font-size: 1.7em; font-weight: 300;padding: 30px 25px 33px 25px;}
.page-content .navbar-inverse .navbar-nav li a:hover {background-color: #444444; transition: 0.7s all linear; height: 100%; }
#bs-example-navbar-collapse-1{ height:auto !important;}
.page-content .navbar-collapse{ max-height: 100% !important;}
.page-content .sidebar .nav > li { border-bottom: 1px dashed #eee;margin: 0;}
.page-content .navbar-toggle{ border-color: #333 !important; background-color: #333;}
</style>
<div class="sidebar content-box" >
<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
  
      
      
       <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    
    
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav nav-pills nav-stacked span2">
                    <!-- Main menu -->
                    <li class='<?php echo ($_SERVER['PHP_SELF'] == "index.php" ? "current" : ""); ?>'><a href="index.php"><i class="glyphicon glyphicon-user"></i> Users</a></li>
					<li class='<?php echo ($_SERVER['PHP_SELF'] == "articles.php" ? "current" : ""); ?>'><a href="articles.php"><i class="glyphicon glyphicon-font"></i> Articles</a></li>
                    
                    
</ul>
    </div>
                
</nav>             
                
 </div>                   
