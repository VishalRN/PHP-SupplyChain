<?php
require("../includes/config.php");
session_start();
$currentDate = date('Y-m-d');

if(!isset($_SESSION['manufacturer_login']) || $_SESSION['manufacturer_login'] != true) {
    header('Location:../index.php');
    exit();
}

$order_id = $_GET['id'] ?? null;
if(!$order_id) {
    die("Order ID not specified");
}

// Database queries with error handling
$querySelectDistributor = "SELECT dist_id, dist_name FROM distributor";
$resultDistributor = mysqli_query($con, $querySelectDistributor);
if(!$resultDistributor) {
    die("Error fetching distributors: " . mysqli_error($con));
}

$query_selectOrderItems = "SELECT *, order_items.quantity AS q 
                          FROM orders, order_items, products 
                          WHERE order_items.order_id='$order_id' 
                          AND order_items.pro_id=products.pro_id 
                          AND order_items.order_id=orders.order_id";
$result_selectOrderItems = mysqli_query($con, $query_selectOrderItems);
if(!$result_selectOrderItems) {
    die("Error fetching order items: " . mysqli_error($con));
}

$query_selectOrder = "SELECT date, status FROM orders WHERE order_id='$order_id'";
$result_selectOrder = mysqli_query($con, $query_selectOrder);
if(!$result_selectOrder) {
    die("Error fetching order details: " . mysqli_error($con));
}
$row_selectOrder = mysqli_fetch_array($result_selectOrder);

// Get the next invoice ID - improved query
$query_selectInvoiceId = "SHOW TABLE STATUS LIKE 'invoice'";
$result_selectInvoiceId = mysqli_query($con, $query_selectInvoiceId);
if(!$result_selectInvoiceId) {
    die("Error fetching invoice ID: " . mysqli_error($con));
}
$row_selectInvoiceId = mysqli_fetch_array($result_selectInvoiceId);
$nextInvoiceId = $row_selectInvoiceId['Auto_increment'] ?? 'N/A';
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
        <h1>Invoice Summary</h1>
        <table class="table_infoFormat">
            <tr>
                <td>Invoice No:</td>
                <td><?php echo htmlspecialchars($nextInvoiceId); ?></td>
            </tr>
            <tr>
                <td>Invoice Date:</td>
                <td><?php echo date('d-m-Y'); ?></td>
            </tr>
            <tr>
                <td>Order No:</td>
                <td><?php echo htmlspecialchars($order_id); ?></td>
            </tr>
            <tr>
                <td>Order Date:</td>
                <td><?php echo date("d-m-Y", strtotime($row_selectOrder['date'] ?? $currentDate)); ?></td>
            </tr>
        </table>
        
        <form action="insert_invoice.php" method="POST" class="form">
            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>" />
            <table class="table_invoiceFormat">
                <tr>
                    <th>Products</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
                <?php 
                $grandTotal = 0;
                mysqli_data_seek($result_selectOrderItems, 0);
                while($row = mysqli_fetch_array($result_selectOrderItems)): 
                    $amount = $row['q'] * $row['pro_price'];
                    $grandTotal += $amount;
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['pro_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['pro_price']); ?></td>
                        <td><?php echo htmlspecialchars($row['q']); ?></td>
                        <td><?php echo number_format($amount, 2); ?></td>
                    </tr>
                <?php endwhile; ?>
                <tr style="height:40px;vertical-align:bottom;">
                    <td colspan="3" style="text-align:right;">Grand Total:</td>
                    <td><?php echo number_format($grandTotal, 2); ?></td>
                </tr>
            </table>
            
            <br/>
            Ship via: &nbsp;&nbsp;&nbsp;&nbsp;
            <select name="distributor" required>
                <option value="" disabled selected>--- Select Distributor ---</option>
                <?php 
                mysqli_data_seek($resultDistributor, 0);
                while($row = mysqli_fetch_array($resultDistributor)): 
                ?>
                    <option value="<?php echo htmlspecialchars($row['dist_id']); ?>">
                        <?php echo htmlspecialchars($row['dist_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select> 
            <br/><br/>
            
            Comments: <textarea maxlength="400" name="txtComment" rows="5" cols="30"></textarea>
            <br><br>
            <input type="submit" value="Generate Invoice" class="submit_button" />
            
            <span class="error_message">
                <?php
                    if(isset($_SESSION['error'])) {
                        echo htmlspecialchars($_SESSION['error']);
                        unset($_SESSION['error']);
                    }
                ?>
            </span>
        </form>
    </section>
    <?php
        include("../includes/footer.inc.php");
    ?>
</body>
</html>