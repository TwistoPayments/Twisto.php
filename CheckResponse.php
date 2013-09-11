<?php
namespace Twisto;


class CheckResponse {
    function add($customer, $orders) {
        echo json_encode(array(
            'customer' => $customer->serialize(),
            'orders' => array_map(function($order) {
                return $order->serialize();
            }, $orders)
        ));
        echo "\n";
    }
} 
