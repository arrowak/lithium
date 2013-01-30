<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
?>
<!doctype html>
<html>
<head>
	<?php echo $this->html->charset();?>
	<title>Application &gt; <?php echo $this->title(); ?></title>
	<?php echo $this->html->style(array('debug','bootstrap', 'style', 'bootstrap-responsive')); ?>
	<?php echo $this->html->link('Icon', null, array('type' => 'icon')); ?>
</head>
<header class="">
	<header>
	<div class="navbar navbar-inverse" style="position: static;">
              <div class="navbar-inner">
                <div class="container">
                  <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </a>
                  <a class="brand" href="/login" style="color : #58ACFA !important;">Youdyog</a>
                  <div class="nav-collapse collapse navbar-inverse-collapse">
                   <?php if(isset($_SESSION['loginSuccess'])){?> 
                    <ul class="nav">
                      <li id="homeNav" class="navItem"><a href="/profile">Home</a></li>
                      <li id="aboutNav" class="navItem"><a href="#">About</a></li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Connections <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li id="friendsNav"><a href="/connections">Friends</a></li>
                          <li id="exploreGroupsNav"><a href="/getPublicGroups">Explore Groups</a></li>
                          <li id="myGroupsNav"><a href="/myGroups">My Groups</a></li>
                        </ul>
                      </li>
                      <?php if($_SESSION['role'] == "admin") { ?>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Administration <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li id="friendsNav"><a href="/admin/managecategories">Manage Interests</a></li>
                        </ul>
                      </li>
                      
                      <?php } ?>
                    </ul>
                  	
                  	<ul class="nav pull-right">
                    <li id="logoutNav" class="navItem"><a href="/logout" style="float:right;"> Logout </a></li>
                    </ul>
                    <div class="navbar-search pull-right">
                    	<form id="frmSearchUser" action = "" method = "post">
                   			<input type = "text" id = "txtSearchName" class = "pull-right search-query span2" placeholder = "Search User" style = "margin-top:0.5%;" />
							<div class="icon-search"></div>
						</form>
		    		</div>
		    
		    <?php } 
		    ?>
                  </div><!-- /.nav-collapse -->
                </div>
              </div><!-- /navbar-inner -->
            </div>
</header>

<body class="app">
	<div id="container" class="container">
		<div id="content">
			<?php echo $this->content(); ?>
		</div>
	</div>
</body>
<footer><center><hr style="width : 100%"> &COPY; Copyright. 2013. www.youdyog.in. All Rights Reserved. </center></footer>
<?php echo $this->html->script(array('jquery','admin','youdyog','bootstrap-dropdown','bootstrap-tab','bootstrap-collapse', 'bootstrap-modal')); ?>
	
</html>
