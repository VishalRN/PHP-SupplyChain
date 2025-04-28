<?php
	require("../includes/config.php");
	session_start();
	if(isset($_SESSION['retailer_login'])) {
		if(isset($_GET['id'])){
			$invoice_id = $_GET['id'];
			$queryInvoiceItems = "SELECT *,invoice_items.quantity as quantity FROM invoice,invoice_items,products WHERE invoice.invoice_id='$invoice_id' AND invoice_items.product_id=products.pro_id AND invoice_items.invoice_id=invoice.invoice_id";
			$resultInvoiceItems = mysqli_query($con,$queryInvoiceItems);
			$querySelectInvoice = "SELECT * FROM invoice,retailer,distributor,area WHERE invoice_id='$invoice_id' AND invoice.retailer_id=retailer.retailer_id AND retailer.area_id=area.area_id AND invoice.dist_id=distributor.dist_id";
			$resultSelectInvoice = mysqli_query($con,$querySelectInvoice);
			$rowSelectInvoice = mysqli_fetch_array($resultSelectInvoice);
		}
	}
	else {
		header('Location:../index.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title> View Invoice Details </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
	<script type="text/javascript">     
        function PrintDiv() {
			document.getElementById("signature").style.display = "block";
			document.getElementById("footer").style.display = "block";
			var divToPrint = document.getElementById('divToPrint');
			var popupWin = window.open('', '_blank', '');
			popupWin.document.open();
			popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
			document.getElementById("signature").style.display = "none";
			document.getElementById("footer").style.display = "none";
			popupWin.document.close();
		}
     </script>
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_retailer.inc.php");
		include("../includes/aside_retailer.inc.php");
	?>
	<section>
	<div id="divToPrint" style="clear:both;" >
		<h1 style="text-align:center;">Sales Invoice</h1>
		<table class="table_infoFormat">
		<tr>
			<td><b> Invoice No: </b></td>
			<td> <?php echo $rowSelectInvoice['invoice_id']; ?> </td>
		</tr>
		<tr>
			<td><b> Order No: </b></td>
			<td> <?php echo $rowSelectInvoice['order_id']; ?> </td>
		</tr>
		<tr>
			<td><b> Retailer: </b></td>
			<td> <?php echo $rowSelectInvoice['area_code']; ?> </td>
		</tr>
		<tr>
			<td><b> Distributor: </b></td>
			<td> <?php echo $rowSelectInvoice['dist_name']; ?> </td>
		</tr>
		<tr>
			<td><b> Date: </b></td>
			<td> <?php echo date("d-m-Y",strtotime($rowSelectInvoice['date'])); ?> </td>
		</tr>
		</table>
		<form action="" method="POST" class="form">
		<table class="table_invoiceFormat" style="width: 100%; border-collapse: collapse; margin-top: 50px;">
    <thead>
        <tr>
            <th style="width: 5%; text-align: center; border-bottom: 1px solid #000; padding: 8px 5px;">Sr. No.</th>
            <th style="width: 45%; text-align: left; border-bottom: 1px solid #000; padding: 8px 10px;">Products</th>
            <th style="width: 15%; text-align: right; border-bottom: 1px solid #000; padding: 8px 15px;">Unit Price</th>
            <th style="width: 15%; text-align: right; border-bottom: 1px solid #000; padding: 8px 15px;">Quantity</th>
            <th style="width: 20%; text-align: right; border-bottom: 1px solid #000; padding: 8px 10px;">Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; while($rowInvoiceItems = mysqli_fetch_array($resultInvoiceItems)) { ?>
        <tr>
            <td style="text-align: center; padding: 8px 5px;"><?php echo $i; ?></td>
            <td style="text-align: left; padding: 8px 10px;"><?php echo htmlspecialchars($rowInvoiceItems['pro_name']); ?></td>
            <td style="text-align: right; padding: 8px 15px;"><?php echo number_format($rowInvoiceItems['pro_price'], 3, '.', ','); ?></td>
            <td style="text-align: right; padding: 8px 15px;"><?php echo htmlspecialchars($rowInvoiceItems['quantity']); ?></td>
            <td style="text-align: right; padding: 8px 10px;"><?php echo number_format($rowInvoiceItems['quantity']*$rowInvoiceItems['pro_price'], 3, '.', ','); ?></td>
        </tr>
        <?php $i++; } ?>
        <tr style="height:40px;vertical-align:bottom;">
            <td colspan="4" style="text-align: right; border-top: 1px solid #000; padding-top: 10px; padding-right: 10px;"><b>Grand Total:</b></td>
            <td style="text-align: right; border-top: 1px solid #000; padding-top: 10px; font-weight: bold;">
			<?php
					mysqli_data_seek($resultInvoiceItems,0);
					$rowInvoiceItems = mysqli_fetch_array($resultInvoiceItems);
					echo $rowInvoiceItems['total_amount'];
				?>			</td>
        </tr>
    </tbody>
</table>
		<br/><br/>
		<b>Comments:</b> <br/> <?php echo $rowSelectInvoice['comments']; ?>
		<br/><br/><br/><br/><br/><br/>
			<p id="signature" style="float:right;display:none;">(Authorized Signatory)</p>
			<p id="footer" style="clear:both;display:none;padding-bottom:20px;text-align:center;">Thank you for your Bussiness!</p>
		</div>
		<input type="button" value="Print Invoice" class="submit_button" onclick="PrintDiv();" />
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>




