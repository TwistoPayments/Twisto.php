<?php
namespace Twisto;


class SharedDbResponse {
    /**
     * Set up streaming API
     */
    function __construct() {
        set_time_limit(0);
        @ob_end_clean();
        header("Content-Type: text/plain");
    }

    /**
     * @param BareCustomer $customer
     * @param BareOrder[] $orders
     */
    function add(BareCustomer $customer, array $orders) {
        echo json_encode(array(
            'customer' => $customer->serialize(),
            'orders' => array_map(function($order) {
                return $order->serialize();
            }, $orders)
        ));
        echo "\n";
        @ob_flush();
        @flush();
    }
}