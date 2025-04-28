<?php
require("../includes/config.php");
session_start();

// Check authorization
if(!isset($_SESSION['manufacturer_login']) && !isset($_SESSION['admin_login']) && !isset($_SESSION['retailer_login'])) {
    header('Location:../index.php');
    exit();
}

// Validate and sanitize order ID
$order_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$order_id) {
    die("Invalid order ID");
}

// Use prepared statements to prevent SQL injection
$query_selectManOrderItems = "SELECT *, order_items.quantity as quantity 
                             FROM orders, order_items, products 
                             WHERE order_items.order_id=? 
                             AND order_items.pro_id=products.pro_id 
                             AND order_items.order_id=orders.order_id";
$stmt = mysqli_prepare($con, $query_selectManOrderItems);
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$result_selectManOrderItems = mysqli_stmt_get_result($stmt);

$query_selectManOrder = "SELECT date, approved, status FROM orders WHERE order_id=?";
$stmt = mysqli_prepare($con, $query_selectManOrder);
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$result_selectManOrder = mysqli_stmt_get_result($stmt);
$row_selectManOrder = mysqli_fetch_array($result_selectManOrder);

if (!$row_selectManOrder) {
    die("Order not found");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Orders</title>
    <link rel="stylesheet" href="../includes/main_style.css">
</head>
<body>
    <?php
        include("../includes/header.inc.php");
        include("../includes/nav_manufacturer.inc.php");
        include("../includes/aside_manufacturer.inc.php");
    ?>
    <section>
        <h1>Order Details</h1>
        <table class="table_infoFormat">
            <tr>
                <td style="font-weight: bold;">Order No:</td>
                <td><?php echo htmlspecialchars($order_id); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Status:</td>
                <td>
                    <?php echo $row_selectManOrder['status'] == 0 ? "Pending" : "Completed"; ?>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Date:</td>
                <td><?php echo date("d-m-Y", strtotime($row_selectManOrder['date'])); ?></td>
            </tr>
        </table>
        
        <form action="" method="POST" class="form">
        <table class="table_invoiceFormat" style="width: 100%; border-collapse: collapse;">
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
        $total_amount = 0;
        $counter = 1;
        while($row = mysqli_fetch_array($result_selectManOrderItems)): 
            $amount = $row['quantity'] * $row['pro_price'];
            $total_amount += $amount;
        ?>
        <tr>
            <td style="text-align: center; vertical-align: top; padding: 8px 5px;"><?php echo $counter++; ?></td>
            <td style="text-align: left; vertical-align: top; padding: 8px 10px;"><?php echo htmlspecialchars($row['pro_name']); ?></td>
            <td style="text-align: right; vertical-align: top; padding: 8px 15px;"><?php echo number_format($row['pro_price'], 2); ?></td>
            <td style="text-align: right; vertical-align: top; padding: 8px 15px;"><?php echo htmlspecialchars($row['quantity']); ?></td>
            <td style="text-align: right; vertical-align: top; padding: 8px 10px; font-weight: bold;"><?php echo number_format($amount, 2); ?></td>
        </tr>
        <?php endwhile; ?>
        <tr style="height:40px;vertical-align:bottom;">
            <td colspan="4" style="text-align: right; border-top: 1px solid #000; padding-top: 10px; padding-right: 10px;"><b>Total Amount:</b></td>
            <td style="text-align: right; border-top: 1px solid #000; padding-top: 10px; font-weight: bold;"><?php echo number_format($total_amount, 2); ?></td>
        </tr>
    </tbody>
</table>
            
            <?php if($row_selectManOrder['approved'] == 0): ?>
                <a href="confirm_order.php?id=<?php echo $order_id; ?>">
                    <input type="button" value="Confirm Order" class="submit_button"/>
                </a>
            <?php elseif($row_selectManOrder['status'] == 0): ?>
                <a href="generate_invoice.php?id=<?php echo $order_id; ?>">
                    <input type="button" value="Generate Invoice" class="submit_button"/>
                </a>
            <?php endif; ?>
        </form>
    </section>
    <?php include("../includes/footer.inc.php"); ?>
</body>
</html>