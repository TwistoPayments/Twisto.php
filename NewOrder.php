<?php

namespace Twisto;


class NewOrder {
  
     /**
     * @var Twisto\Address
     */
    public $billing_address;
    
    /**
     * @var Twisto\Address
     */
    public $delivery_address;
     
    /**
     * @var array
     */
    public $items;

    /**
     * @var number
     */
    public $total_price_vat;
    

    public function __construct(array $data) {
        $this->billing_address = $data['billing_address'];
        $this->delivery_address = isset($data['delivery_address']) ? $data['delivery_address'] : null;  
        $this->items = $data['items'];
        $this->total_price_vat = $data['total_price_vat'];
    }

    public function serialize() {
        $data = array(
            'total_price_vat' => $this->total_price_vat,
            'billing_address' => $this->billing_address->serialize(),
            'delivery_address' => $this->delivery_address->serialize(),
            'items' => array()
        );   
        
        foreach ($this->items as $item) {
            $data['items'][] = $item->serialize();
        }
        
        return $data;

    }
} 
