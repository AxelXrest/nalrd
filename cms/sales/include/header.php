


<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
					<i class="icon-reorder shaded"></i>
				</a>

			  	<a class="brand" href="#">
			  		Nepal Airlink | CMS 
			  	</a>

				<div class="nav-collapse collapse navbar-inverse-collapse">
					<ul class="nav pull-right">
						

						<?php
								
								$aid2 = $_SESSION['aid'];
								$sql=mysqli_query($bd, "select fullname from tbl_users where id= '$aid2' ");
								while ($rw1=mysqli_fetch_array($sql)) {
								?>
								<li><a href="#">
									<?php echo $rw1['fullname'];
									?>
						</a></li>
								<?php
								}
?>

						<li class="nav-user dropdown">
						<div class="top-menu">
            	     	<ul class="nav pull-right top-menu">
                   		<li><a class="logout" href="../../index.php?_route=dashboard">Back To System</a></li>
            			</ul>
           				</div>
								
							</a>
							
						</li>
					</ul>
				</div><!-- /.nav-collapse -->
			</div>
		</div><!-- /navbar-inner -->
	</div><!-- /navbar -->
