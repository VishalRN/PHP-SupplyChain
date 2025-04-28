<?php
	require("../includes/config.php");
	session_start();
	if(isset($_SESSION['manufacturer_login']) || isset($_SESSION['admin_login']) || isset($_SESSION['retailer_login'])) {
			$order_id = $_GET['id'];
			$query_selectOrderItems = "SELECT *,order_items.quantity AS quantity FROM orders,order_items,products WHERE order_items.order_id='$order_id' AND order_items.pro_id=products.pro_id AND order_items.order_id=orders.order_id";
			$result_selectOrderItems = mysqli_query($con,$query_selectOrderItems);
			$query_selectOrder = "SELECT date,status FROM orders WHERE order_id='$order_id'";
			$result_selectOrder = mysqli_query($con,$query_selectOrder);
			$row_selectOrder = mysqli_fetch_array($result_selectOrder);
		}
		else {
			header('Location:../index.php');
		}
?>

<!DOCTYPE html>
<html>
<head>
	<title> View Orders </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_retailer.inc.php");
		include("../includes/aside_retailer.inc.php");
	?>
	<section>
		<h1>Order Details</h1>
		<table class="table_infoFormat">
		<tr>
			<td style="font-weight: bold;"> Order No: </td>
			<td> <?php echo $order_id; ?> </td>
		</tr>
		<tr>
			<td style="font-weight: bold;"> Status: </td>
			<td>
			<?php
				if($row_selectOrder['status'] == 0) {
					echo "Pending";
				}
				else {
					echo "Completed";
				}
			?>
			</td>
		</tr>
		<tr>
			<td style="font-weight: bold;"> Date: </td>
			<td> <?php echo date("d-m-Y",strtotime($row_selectOrder['date'])); ?> </td>
		</tr>
		</table>
		<form action="" method="POST" class="form">
		<table class="table_invoiceFormat" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
    <thead>
        <tr>
            <th style="width: 5%; text-align: center; border-bottom: 1px solid #000; padding: 8px 5px;">S.No</th>
            <th style="width: 45%; text-align: left; border-bottom: 1px solid #000; padding: 8px 10px;">Products</th>
            <th style="width: 15%; text-align: right; border-bottom: 1px solid #000; padding: 8px 15px;">Unit Price</th>
            <th style="width: 15%; text-align: right; border-bottom: 1px solid #000; padding: 8px 15px;">Quantity</th>
            <th style="width: 20%; text-align: right; border-bottom: 1px solid #000; padding: 8px 10px;">Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $i = 1;
        $total_amount = 0;
        while($row_selectOrderItems = mysqli_fetch_array($result_selectOrderItems)): 
            $amount = $row_selectOrderItems['quantity'] * $row_selectOrderItems['pro_price'];
            $total_amount += $amount;
        ?>
        <tr>
            <td style="text-align: center; padding: 8px 5px;"><?php echo $i++; ?></td>
            <td style="text-align: left; padding: 8px 10px;"><?php echo htmlspecialchars($row_selectOrderItems['pro_name']); ?></td>
            <td style="text-align: right; padding: 8px 15px;"><?php echo number_format($row_selectOrderItems['pro_price'], 3); ?></td>
            <td style="text-align: right; padding: 8px 15px;"><?php echo htmlspecialchars($row_selectOrderItems['quantity']); ?></td>
            <td style="text-align: right; padding: 8px 10px;"><?php echo number_format($amount, 3); ?></td>
        </tr>
        <?php endwhile; ?>
        <tr style="height:40px;vertical-align:bottom;">
            <td colspan="4" style="text-align: right; border-top: 1px solid #000; padding-top: 10px; padding-right: 10px;">
                <b>Total Amount:</b>
            </td>
            <td style="text-align: right; border-top: 1px solid #000; padding-top: 10px; font-weight: bold;">
                <?php echo number_format($total_amount, 3); ?>
            </td>
        </tr>
    </tbody>
</table>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>