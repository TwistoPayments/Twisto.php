<?php
namespace Twisto;


class CheckResponse {
    /**
     * @param Customer $customer
     * @param Order[] $orders
     */
    function add(Customer $customer, array $orders) {
        echo json_encode(array(
            'customer' => $customer->serialize(),
            'orders' => array_map(function($order) {
                return $order->serialize();
            }, $orders)
        ));
        echo "\n";
    }
} 
