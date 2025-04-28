<?php
session_start();
require("../includes/config.php");

if(!isset($_SESSION['manufacturer_login'])) {
    header('Location:../index.php');
    exit();
}

try {
    $id = (int)$_GET['id']; // Basic sanitization
    
    // Start transaction
    mysqli_begin_transaction($con);
    
    // Check stock for all items first
    $stockOk = true;
    $checkQuery = "SELECT oi.pro_id, oi.quantity as ordered, p.quantity as available 
                   FROM order_items oi
                   JOIN products p ON oi.pro_id = p.pro_id
                   WHERE oi.order_id = ?";
    $stmt = $con->prepare($checkQuery);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while($row = $result->fetch_assoc()) {
        if($row['available'] < $row['ordered']) {
            $stockOk = false;
            break;
        }
    }
    
    if(!$stockOk) {
        throw new Exception("Insufficient stock for order");
    }
    
    // Update quantities
    $updateQuery = "UPDATE products p
                   JOIN order_items oi ON p.pro_id = oi.pro_id
                   SET p.quantity = p.quantity - oi.quantity
                   WHERE oi.order_id = ?";
    $stmt = $con->prepare($updateQuery);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    // Mark order as approved
    $confirmQuery = "UPDATE orders SET approved=1 WHERE order_id=?";
    $stmt = $con->prepare($confirmQuery);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    mysqli_commit($con);
    $_SESSION['message'] = "Order confirmed successfully";
    
} catch (Exception $e) {
    mysqli_rollback($con);
    $_SESSION['error'] = $e->getMessage();
}

header("Location: view_orders.php");
exit();