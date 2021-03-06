<?php
//Turn off all error reporting
error_reporting(1);
session_start();
if(!isset($_SESSION["user"])){
    header("location:default.php");
    exit();
}
//Just to be sure that the manager SESSION variable is in database..to check illegal intruders.
$userID = preg_replace('#(^0-9)#i','',$_SESSION["id"]);//filter everything but numbers.
$username = preg_replace('#(^A-Za-z0-9)#i','',$_SESSION["user"]);//filter everything but numbers and letters.
$password = preg_replace('#(^A-Za-z0-9)#i','',$_SESSION["password"]);//filter everything but numbers and letters.
require "sitescripts/connect_mysql.php";
$username_query=mysql_query("SELECT una FROM users WHERE username='$username' AND password='$password'");
while ($row=mysql_fetch_array($username_query))
{
    $una= $row["una"];
}
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="Scripts\jquery-1.10.1.min.js" type="text/javascript"></script>
    
<meta charset="utf-8" />
    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,400italic" rel="stylesheet" type="text/css" />
    <link href="Content/bootstrap.min.css" rel="stylesheet" />
    <link href="Styles/headfoot.css" rel="stylesheet" />
    <link href="general.css" rel="stylesheet" />
    <script type="text/javascript" src="storescripts/jquery-1.10.1.min.js"></script>
    <script src="Scripts/bootstrap.min.js"></script>
   </head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="default.php"><span class="glyphicon glyphicon-euro"></span>&nbsp;EURO-GO</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <form class="navbar-form navbar-left" role="search">
                        <div class="form-group">    
                        <input type="search" class="form-control" placeholder="Search for a city">
                        
                        </div>
                        <button type="submit" class="btn btn-default">Explore</button>
                    </form>
                    
                   <!--<li><a href="signin.php"><span class="glyphicon glyphicon-log-in"></span>&nbsp;&nbsp;SIGN IN</a></li>
                    <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;SIGN UP</a></li>-->
                    
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="signin.php"><span class="glyphicon glyphicon-user"></span>&nbsp; &nbsp;<?php echo ucfirst($una); ?> <span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <li><a href="user_settings.php"><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SETTINGS</a></li>
                            <li class="divider"></li>
                            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LOGOUT</a></li>
                        </ul>
                        </li>
                    
                    <li><a href="#"><span class="glyphicon glyphicon-heart"></span>&nbsp;&nbsp;FAVOURITES</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">HELP&nbsp;<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">HOW GOEURO WORKS</a></li>
                            <li class="divider"></li>
                            <li><a href="#">ABOUT US</a></li>
                            <li class="divider"></li>
                            <li><a href="contact_us.php">CONTACT US</a></li>
                        </ul>
                    </li>
                </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    
    <div class="jumbotron">
<?php  
//echo $id1;
include "storescripts/connect_mysql.php";
$sql = mysql_query("SELECT * FROM cart WHERE username='$username'");
				$prod_count = mysql_num_rows($sql);
				if($prod_count>0){
					$dynamicTitle = "Image Not Available";
						$i = 0;
					while($row=mysql_fetch_array($sql)){
						$id=$row["id"];
						$imgid = $id."-img1.jpg";
						$l_name = $row["name"];
						$l_country = $row["country"];
						$l_city = $row["city"];
						$l_categ = $row["categ"];
						$date_added = strftime("%b %d,20%y",strtotime($row["date_added"]));
						
						$dynamic_list .= "<div class='col-md-12' style='border:10px solid grey;border-radius:12px;margin-top: 40px;'>
            <a href='c_view.php?id=".$id."' class='iframe'>
            <div class='row' '>
            <div class='col-md-4'>
            <div class='thumbnail'><img src='storeimages/landmarks/$imgid' alt='$dynamicTitle' /></div></div>
					<div class='col-md-5'>
                        <h3>Landmark Name:<p class='title'>$l_name</p></h3>
                        <h3>Landmark Country<p class='city'>".ucfirst($l_country)."</p></h3>
                        <h3>Landmark City<p class='city'>$l_city</p></h3>
                        <h3>Landmark Category<p class='city'>".$l_categ."</p></h3>
                    </div> 
                    <div class='col-md-3'>
                    	<a href='edit_landmark.php?deleteid=$l_name'><input type='button' class='btn btn-primary' style='height:40px;' value='REMOVE LANDMARK'></input></a>
                    </div>
                    </div></a></div> </br></br>";
						}
				}
				else{
					$dynamic_list = "No Landmarks here.Come back later.!!";
				}
?>

<div class="container">
            	<div id="grid">
            		<?php echo "<h2>".ucfirst($una)."'s Favourite Places.<h3>"?>
                    <?php echo $dynamic_list?>
                </div>
            </div>
</div>
  <!--<footer>
        <div class="footnav">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-centered emadd">
                        <label>Enter your e-mail address to recieve our updates:</label>&nbsp;&nbsp;
                        <input type="text" placeholder="Enter your email address" />
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-md-offset-1">
                        <h3>About</h3>
                        <ul>
                            <li>
                                <a href="#">Company</a>
                            </li>
                            <li>
                                <a href="#">Press</a>
                            </li>
                            <li>
                                <a href="#">Team</a>
                            </li>

                            <li>
                                <a href="#">Jobs</a>
                            </li>
                            <li>
                                <a href="#">Blog</a>
                            </li>

                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h3>Legal</h3>
                        <ul>
                            <li>
                                <a href="#">Policies</a>
                            </li>
                            <li>
                                <a href="#">Terms</a>
                            </li>
                            <li>
                                <a href="#">Privacy</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-md-offset-1">
                        <h3>Community</h3>
                        <ul>
                            <li>
                                <a href="#"> Why List</a>
                            </li>
                            <li>
                                <a href="#">Support</a>
                            </li>
                            <li>
                                <a href="#">Safety Tips</a>
                            </li>

                            <li>
                                <a href="#">Testimonials</a>
                            </li>
                            <li>
                                <a href="#">Wiki</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 social">
                    <h3>Connect with Us</h3>
                    <a class="soclogo" href="http://youtube.com">
                        <img src="images/youtube.png"></img>
                    </a>
                    <a class="soclogo" href="http://twitter.com">
                        <img src="images/twitter.png"></img>
                    </a>
                    <a class="soclogo" href="http://facebook.com">
                        <img src="images/facebook.png"></img>
                    </a>
                    <a class="soclogo" href="http://vimeo.com">
                        <img src="images/vimeo.png"></img>
                    </a>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-centered copyright">
                    <h4 style="color: white;text-align: center;">Copyright &copy; 2015 Euro-Go AB, Sweden</h4>
                </div>
            </div>
        </div>
    </footer>-->
</body>
</html>