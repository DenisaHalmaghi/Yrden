
<?php


if (isset($data['orders']) && $orders = $data['orders']) {
    $viewUtil->displayOrders($orders, $viewUtil);
} else {
    echo $viewUtil->displayOrderDetails($data['orderDetails'], $viewUtil);
}
?>

