<?php
	include("../includes/config.php");
	include("../includes/validate_data.php");
	session_start();
	if(isset($_SESSION['admin_login'])) {
		if($_SESSION['admin_login'] == true) {
			$name = $email = $phone = $address = "";
			$nameErr = $emailErr = $phoneErr = $requireErr = $confirmMessage = "";
			$nameHolder = $emailHolder = $phoneHolder = $addressHolder = "";
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				if(!empty($_POST['txtDistributorName'])) {
					$nameHolder = $_POST['txtDistributorName'];
					$resultValidate_name = validate_name($_POST['txtDistributorName']);
					if($resultValidate_name == 1) {
						$name = $_POST['txtDistributorName'];
					}
					else{
						$nameErr = $resultValidate_name;
					}
				}
				if(!empty($_POST['txtDistributorEmail'])) {
					$emailHolder = $_POST['txtDistributorEmail'];
					$resultValidate_email = validate_email($_POST['txtDistributorEmail']);
					if($resultValidate_email == 1) {
						$email = $_POST['txtDistributorEmail'];
					}
					else {
						$emailErr = $resultValidate_email;
					}
				}
				if(!empty($_POST['txtDistributorPhone'])) {
					$phoneHolder = $_POST['txtDistributorPhone'];
					$resultValidate_phone = validate_phone($_POST['txtDistributorPhone']);
					if($resultValidate_phone == 1) {
						$phone = $_POST['txtDistributorPhone'];
					}
					else {
						$phoneErr = $resultValidate_phone;
					}
				}
				if(!empty($_POST['txtDistributorAddress'])) {
					$address = $_POST['txtDistributorAddress'];
					$addressHolder = $_POST['txtDistributorAddress'];
				}
				if($name != null && $phone != null && $resultValidate_email ==1) {
					$query_addDistributor = "INSERT INTO distributor(dist_name,dist_email,dist_phone,dist_address) VALUES('$name','$email','$phone','$address')";
					if(mysqli_query($con,$query_addDistributor)) {
						echo "<script> alert(\"Distributor Added Successfully\"); </script>";
						header('Refresh:0');
					}
					else {
						$requireErr = "Adding Distributor Failed";
					}
				}
				else {
					$requireErr = "* Valid Name & Phone Number are compulsory";
				}
			}
		}
		else {
			header('Location:../index.php');
		}
	}
	else {
		header('Location:../index.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title> Add Distributor </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_admin.inc.php");
		include("../includes/aside_admin.inc.php");
	?>
	<section>
		<h1>Add Distributor</h1>
		<form action="" method="POST" class="form">
		<ul class="form-list">
		<li>
			<div class="label-block"> <label for="distributor:name">Name</label> </div>
			<div class="input-box"> <input type="text" id="distributor:name" name="txtDistributorName" placeholder="Name" value="<?php echo $nameHolder; ?>" required /> </div> <span class="error_message"><?php echo $nameErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="distributor:email">Email</label> </div>
			<div class="input-box"> <input type="text" id="distributor:email" name="txtDistributorEmail" placeholder="Email" value="<?php echo $emailHolder; ?>" required /> </div> <span class="error_message"><?php echo $emailErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="distributor:phone">Phone</label> </div>
			<div class="input-box"> <input type="text" id="distributor:phone" name="txtDistributorPhone" placeholder="Phone" value="<?php echo $phoneHolder; ?>" /> </div> <span class="error_message"><?php echo $phoneErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="distributor:phone">Alternative Phone Number</label> </div>
			<div class="input-box"> <input type="text" id="distributor:phone" name="txtDistributorPhone" placeholder="Phone" value="<?php echo $phoneHolder; ?>" /> </div> <span class="error_message"><?php echo $phoneErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="distributor:address">Address</label> </div>
			<div class="input-box"> <textarea type="text" id="distributor:address" name="txtDistributorAddress" placeholder="Address"><?php echo $addressHolder; ?></textarea> </div>
		</li>
		<li>
			<input type="submit" value="Add Distributor" class="submit_button" /> <span class="error_message"> <?php echo $requireErr; ?> </span><span class="confirm_message"> <?php echo $confirmMessage; ?> </span>
		</li>
		</ul>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>