<?php

function displayOrders($orders,$util)
{

    $statuses = array("Pending", "Complete");
    if (!mysql_num_rows($orders)) {
        echo " <p class='ta-c c-prm bold'>There are no orders here yet</p>";
        return;
    }
    while ($row = mysql_fetch_array($orders)) {
        $address = $util->buildAddressString($row);
        // print_r($row);
        // echo '<br>';
        // echo $row['OrderStatus'];
        $orderID = $row['OrderID'];
        $icon="check";
        $orderStatus= $row['OrderStatus'];
        if($orderStatus){
            $icon = "times";
        }
        $status = $statuses[$orderStatus];
        // if($row['Status']){
        //     $status="Complete";
        // }

        // $arrival = "Unknown";
        // if ($row['ArrivalDate']) {
        //     $arrival = $row['ArrivalDate'];
        // }
        echo "

        <div class='card mb-1'>
            <div class='card__header centeredRow space-between'>
                <p>
                    <span class='badge'>$status</span> 
                    <span>$${row['Total']}</span>
                   
                </p>
                <div>
                    <a class='btn btn-primary btn--xsmall d-ib' href='./?url=admin/updateOrder/$orderID/".!$orderStatus."'>
                        <i class='fas fa-$icon'></i>
                    </a>
                    <a class='btn btn-primary btn--xsmall d-ib' href='./?url=user/orders/$orderID'>
                            <i class='fas fa-list'></i>
                    </a>
                </div>
               
            </div>
            <div class='card__body'>
              
                <p class='card-text'><span class='eti'>Shipping address:</span> $address</p>
                <p><span class='eti'>Order Creation Time:</span> <time>${row['OrderDate']}</time> </p>
                
              
            </div>
        </div>";
    }
}

if (isset($data['orders']) && $orders = $data['orders']) {
    displayOrders($orders, $viewUtil);
} else {
    echo $viewUtil->displayOrderDetails($data['orderDetails']);
}
