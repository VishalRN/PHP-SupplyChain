<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require("../includes/config.php");
require("../includes/validate_data.php");
session_start();

// Check authentication
if (!isset($_SESSION['manufacturer_login'])) {
    header('Location: ../index.php');
    exit();
}

// Initialize variables
$error = "";
$result_selectInvoice = null;

// Get retailer list
$querySelectRetailer = "SELECT *, area.area_id AS area_id FROM retailer, area WHERE retailer.area_id = area.area_id";
$resultSelectRetailer = mysqli_query($con, $querySelectRetailer);
if (!$resultSelectRetailer) {
    die("Database error: " . mysqli_error($con));
}

// Process search form
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['cmbFilter'])) {
    $filterType = $_POST['cmbFilter'];
    
    try {
        switch ($filterType) {
            case 'invoiceId':
                if (!empty($_POST['txtInvoiceId'])) {
                    $invoice_id = validate_number($_POST['txtInvoiceId']);
                    if ($invoice_id === 1) {
                        $invoice_id = (int)$_POST['txtInvoiceId'];
                        $query = "SELECT invoice.*, retailer.retailer_id, area.area_code, 
                                 (SELECT SUM(invoice_items.quantity * products.pro_price) 
                                  FROM invoice_items, products 
                                  WHERE invoice_items.invoice_id = invoice.invoice_id 
                                  AND invoice_items.product_id = products.pro_id) AS calculated_total
                                 FROM invoice, retailer, area 
                                 WHERE invoice.retailer_id = retailer.retailer_id 
                                 AND retailer.area_id = area.area_id 
                                 AND invoice.invoice_id = ?";
                        $stmt = mysqli_prepare($con, $query);
                        mysqli_stmt_bind_param($stmt, "i", $invoice_id);
                        mysqli_stmt_execute($stmt);
                        $result_selectInvoice = mysqli_stmt_get_result($stmt);
                    } else {
                        $error = "* Invalid ID";
                    }
                }
                break;
                
            case 'orderId':
                if (!empty($_POST['txtOrderId'])) {
                    $order_id = validate_number($_POST['txtOrderId']);
                    if ($order_id === 1) {
                        $order_id = (int)$_POST['txtOrderId'];
                        $query = "SELECT invoice.*, retailer.retailer_id, area.area_code,
                                 (SELECT SUM(invoice_items.quantity * products.pro_price) 
                                  FROM invoice_items, products 
                                  WHERE invoice_items.invoice_id = invoice.invoice_id 
                                  AND invoice_items.product_id = products.pro_id) AS calculated_total
                                 FROM invoice, retailer, area 
                                 WHERE invoice.retailer_id = retailer.retailer_id 
                                 AND retailer.area_id = area.area_id 
                                 AND invoice.order_id = ?";
                        $stmt = mysqli_prepare($con, $query);
                        mysqli_stmt_bind_param($stmt, "i", $order_id);
                        mysqli_stmt_execute($stmt);
                        $result_selectInvoice = mysqli_stmt_get_result($stmt);
                    } else {
                        $error = "* Invalid ID";
                    }
                }
                break;
                
            case 'retailer':
                if (!empty($_POST['cmbRetailer'])) {
                    $retailer_id = (int)$_POST['cmbRetailer'];
                    $query = "SELECT invoice.*, retailer.retailer_id, area.area_code,
                             (SELECT SUM(invoice_items.quantity * products.pro_price) 
                              FROM invoice_items, products 
                              WHERE invoice_items.invoice_id = invoice.invoice_id 
                              AND invoice_items.product_id = products.pro_id) AS calculated_total
                             FROM invoice, retailer, area 
                             WHERE invoice.retailer_id = retailer.retailer_id 
                             AND retailer.area_id = area.area_id 
                             AND invoice.retailer_id = ? 
                             ORDER BY invoice.invoice_id DESC";
                    $stmt = mysqli_prepare($con, $query);
                    mysqli_stmt_bind_param($stmt, "i", $retailer_id);
                    mysqli_stmt_execute($stmt);
                    $result_selectInvoice = mysqli_stmt_get_result($stmt);
                }
                break;
                
            case 'date':
                if (!empty($_POST['txtDate'])) {
                    $date = $_POST['txtDate'];
                    if (DateTime::createFromFormat('Y-m-d', $date) !== false) {
                        $query = "SELECT invoice.*, retailer.retailer_id, area.area_code,
                                 (SELECT SUM(invoice_items.quantity * products.pro_price) 
                                  FROM invoice_items, products 
                                  WHERE invoice_items.invoice_id = invoice.invoice_id 
                                  AND invoice_items.product_id = products.pro_id) AS calculated_total
                                 FROM invoice, retailer, area 
                                 WHERE invoice.retailer_id = retailer.retailer_id 
                                 AND retailer.area_id = area.area_id 
                                 AND invoice.date = ?";
                        $stmt = mysqli_prepare($con, $query);
                        mysqli_stmt_bind_param($stmt, "s", $date);
                        mysqli_stmt_execute($stmt);
                        $result_selectInvoice = mysqli_stmt_get_result($stmt);
                    } else {
                        $error = "* Invalid date format";
                    }
                }
                break;
                
            default:
                $error = "* Please select a valid search option";
        }
        
        // Check if any results were found
        if ($result_selectInvoice && mysqli_num_rows($result_selectInvoice) === 0) {
            $error = "* No invoices found with the selected criteria";
        }
        
    } catch (Exception $e) {
        $error = "* An error occurred while processing your request";
        error_log($e->getMessage());
    }
    
} else {
    // Default query - all invoices ordered by invoice_id descending
    $query = "SELECT invoice.*, retailer.retailer_id, area.area_code,
             (SELECT SUM(invoice_items.quantity * products.pro_price) 
              FROM invoice_items, products 
              WHERE invoice_items.invoice_id = invoice.invoice_id 
              AND invoice_items.product_id = products.pro_id) AS calculated_total
             FROM invoice, retailer, area 
             WHERE invoice.retailer_id = retailer.retailer_id 
             AND retailer.area_id = area.area_id
             ORDER BY invoice.invoice_id DESC";
    $result_selectInvoice = mysqli_query($con, $query);
    if (!$result_selectInvoice) {
        die("Database error: " . mysqli_error($con));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Invoices</title>
    <link rel="stylesheet" href="../includes/main_style.css">
    <link rel="stylesheet" href="css/smoothness/jquery-ui.css">
    <script type="text/javascript" src="../includes/jquery.js"></script>
    <script src="js/jquery-ui.js"></script>
</head>
<body>
    <?php
        include("../includes/header.inc.php");
        include("../includes/nav_manufacturer.inc.php");
        include("../includes/aside_manufacturer.inc.php");
    ?>
    
    <section>
        <h1>Invoices</h1>
        
        <form action="" method="POST" class="form">
            <div class="input-box">
                Search By: 
                <select name="cmbFilter" id="cmbFilter" required>
                    <option value="" disabled selected>-- Select Search Option --</option>
                    <option value="invoiceId">Invoice ID</option>
                    <option value="orderId">Order ID</option>
                    <option value="retailer">Retailer</option>
                    <option value="date">Date</option>
                </select>
            </div>
            
            <div class="input-box" id="invoiceIdBox" style="display:none;">
                <input type="text" name="txtInvoiceId" id="txtInvoiceId" placeholder="Enter Invoice ID">
            </div>
            
            <div class="input-box" id="orderIdBox" style="display:none;">
                <input type="text" name="txtOrderId" id="txtOrderId" placeholder="Enter Order ID">
            </div>
            
            <div class="input-box" id="retailerBox" style="display:none;">
                <select name="cmbRetailer" id="cmbRetailer">
                    <option value="" disabled selected>-- Select Retailer --</option>
                    <?php 
                    mysqli_data_seek($resultSelectRetailer, 0);
                    while($row = mysqli_fetch_assoc($resultSelectRetailer)): 
                    ?>
                    <option value="<?php echo htmlspecialchars($row['retailer_id']); ?>">
                        <?php echo htmlspecialchars($row['area_code']." (".$row['area_name'].")"); ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="input-box" id="dateBox" style="display:none;">
                <input type="text" id="datepicker" name="txtDate" placeholder="Select Date">
            </div>
            
            <input type="submit" class="submit_button" value="Search">
            <span class="error"><?php echo htmlspecialchars($error); ?></span>
        </form>
        
        <?php if ($result_selectInvoice && mysqli_num_rows($result_selectInvoice) > 0): ?>
        <table class="table_displayData">
            <tr>
                <th>Invoice ID</th>
                <th>Retailer</th>
                <th>Date</th>
                <th>Order ID</th>
                <th>Total Amount</th>
                <th>Details</th>
            </tr>
            <?php 
            $counter = 1;
            while($row = mysqli_fetch_assoc($result_selectInvoice)): 
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['invoice_id']); ?></td>
                <td><?php echo htmlspecialchars($row['area_code']); ?></td>
                <td><?php echo date("d-m-Y", strtotime($row['date'])); ?></td>
                <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                <td><?php echo number_format($row['calculated_total'], 2); ?></td>
                <td><a href="view_invoice_items.php?id=<?php echo $row['invoice_id']; ?>">Details</a></td>
            </tr>
            <?php 
            $counter++;
            endwhile; 
            ?>
        </table>
        <?php elseif (!empty($_POST)): ?>
            <p class="error">No invoices found matching your criteria.</p>
        <?php endif; ?>
    </section>
    
    <?php include("../includes/footer.inc.php"); ?>
    
    <script>
    $(function() {
        // Initialize datepicker
        $("#datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0",
            dateFormat: "yy-mm-dd"
        });
        
        // Show/hide search fields based on selection
        $("#cmbFilter").change(function() {
            var selected = $(this).val();
            $("#txtInvoiceId, #txtOrderId, #cmbRetailer, #datepicker").parent().hide();
            
            if (selected == "invoiceId") {
                $("#invoiceIdBox").show();
            } else if (selected == "orderId") {
                $("#orderIdBox").show();
            } else if (selected == "retailer") {
                $("#retailerBox").show();
            } else if (selected == "date") {
                $("#dateBox").show();
            }
        });
    });
    </script>
</body>
</html>