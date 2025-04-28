<?php
require("../includes/config.php");
session_start();

$currentDate = date('Y-m-d');
$order_id = $_POST['order_id'];

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!isset($_POST['distributor'])) {
        $_SESSION['error'] = "* Please choose distributor";
        header("Location:generate_invoice.php?id=$order_id");
        exit();
    }

    $comment = isset($_POST['txtComment']) ? trim($_POST['txtComment']) : "";
    $dist_id = $_POST['distributor'];

    // Get order details with error handling
    $query_selectOrder = "SELECT * FROM orders WHERE order_id='$order_id'";
    $result_selectOrder = mysqli_query($con, $query_selectOrder);

    if(!$result_selectOrder || mysqli_num_rows($result_selectOrder) == 0) {
        die("Error: Order not found or query failed: " . mysqli_error($con));
    }

    $row_selectOrder = mysqli_fetch_assoc($result_selectOrder);
    $retailer_id = $row_selectOrder['retailer_id'];
    $total_amount = $row_selectOrder['total_amount'];

    // Start transaction to ensure both invoice and items are inserted
    mysqli_begin_transaction($con);

    try {
        // Insert invoice first
        $queryInsertInvoice = "INSERT INTO invoice(order_id, retailer_id, dist_id, date, total_amount, comments) 
                             VALUES('$order_id', '$retailer_id', '$dist_id', '$currentDate', '$total_amount', '$comment')";
        
        if(!mysqli_query($con, $queryInsertInvoice)) {
            throw new Exception("Failed to create invoice: " . mysqli_error($con));
        }

        $invoice_id = mysqli_insert_id($con); // Get the auto-generated invoice ID

        // Insert invoice items
        $query_selectOrderItems = "SELECT * FROM order_items WHERE order_id='$order_id'";
        $result_selectOrderItems = mysqli_query($con, $query_selectOrderItems);

        if(!$result_selectOrderItems) {
            throw new Exception("Failed to get order items: " . mysqli_error($con));
        }

        while($row_selectOrderItems = mysqli_fetch_assoc($result_selectOrderItems)) {
            $product_id = $row_selectOrderItems['pro_id'];
            $quantity = $row_selectOrderItems['quantity'];
            
            $queryInsertInvoiceItems = "INSERT INTO invoice_items(invoice_id, product_id, quantity) 
                                      VALUES('$invoice_id', '$product_id', '$quantity')";
            
            if(!mysqli_query($con, $queryInsertInvoiceItems)) {
                throw new Exception("Failed to insert invoice item: " . mysqli_error($con));
            }
        }

        // Update order status
        $queryUpdateStatus = "UPDATE orders SET status=1 WHERE order_id='$order_id'";
        if(!mysqli_query($con, $queryUpdateStatus)) {
            throw new Exception("Failed to update order status: " . mysqli_error($con));
        }

        // Commit transaction if all queries succeeded
        mysqli_commit($con);
        
        $_SESSION['success'] = "Invoice Generated Successfully";
        header("Location: view_invoice_items.php?id=$invoice_id");
        exit();

    } catch (Exception $e) {
        // Rollback transaction if any query failed
        mysqli_rollback($con);
        die("Error: " . $e->getMessage());
    }
}
?>