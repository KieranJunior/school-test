<?php
session_start();
if (!isset($_SESSION["user"])){
  header("Location:login.php"); // if user hasnt logged in it will send them back to the login page
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="search.css"> 
</head>
<body>

<header>
    <nav class="navigation">
        <a href="addtocart.php">Cart</>
        <a href="admin.php">Admin</a>
        <a href="#">Home</a>
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </nav>
</header>

<div class="container"> <!-- main container for the entire content -->
<form action="" method="get"> <!-- form for submitting a search request; action is empty to sumbmit to the same page-->
<div class="logo"> <!-- section for the logo -->
  <img class="joogle-logo" src="joogle.jpg"> <!-- logo image -->
  </div>


<div class="searchform"><input type="search" name="search" required></input></div> <!-- container for the search input field-->

<div class="buttons"><button>Search for products</button> <!-- button to search -->
  <p><a href="#">Home page</a></p>
  </div>
  </form>

  <?php


if(isset($_GET['search'])){ // if search bar 
    $search=$_REQUEST['search'];
$con = mysqli_connect("localhost","tlevel_kieran","Kjunior10.","tlevel_kieran");
$result = mysqli_query($con, "SELECT * FROM products_2 WHERE p_name LIKE '%$search%' ");  

?>

<h1>Search result on products: <?php echo $search; ?></h1>
<br>
< action="addtocart.php" method=get>
<table id="products_2">
  <tr>
    <th>Name</th>
    <th>Description</th>
    <th>Image</th>
	<th>Price </th>
  <th> Quantity</th>
	<th>Buy</th>
  </tr>
  <?php 
  while($row = mysqli_fetch_array($result))
{
  ?>  
  <tr>
    <td><?php echo $row['p_name']; ?></td>
    <td><?php echo $row['p_desc']; ?></td>
    <td><?php echo "<img src=" . $row['p_pic'] . " height=100px width=100px>"; ?></td>
	<td><?php echo $row['p_price']; ?></td>
  <td><?php echo $row['p_quantity']?></td>
	<td><button type="submit" name="addtocart">add to cart</button> 
	<input type=hidden name=pid value=<?php print $row['p_id']; ?> /></td>
  </tr>

<?php 
}
}

?>
  
  </table>
</form>
  
  
 <div class="footer">
  
  <span class="footer-left">
    <a href="#">Advertising</a>
    <a href="#">Business</a>
    <a href="#">About</a>
  </span>
  
  <span class="footer-right">
  <a href="#">Privacy</a>
    <a href="#">Terms</a>
    <a href="#">Settings</a>

  </span>
  </div>
  
</div>
</div>
</body>
  </html>
  
