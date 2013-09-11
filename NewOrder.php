<?php

namespace Twisto;


class NewOrder {
  
     /**
     * @var Address
     */
    public $billing_address;
    
    /**
     * @var Address
     */
    public $delivery_address;
     
    /**
     * @var OrderItem[]
     */
    public $items;

    /**
     * @var float
     */
    public $total_price_vat;

    /**
     * @param array $data
     */
    public function __construct(array $data) {
        $this->billing_address = $data['billing_address'];
        $this->delivery_address = isset($data['delivery_address']) ? $data['delivery_address'] : null;  
        $this->items = $data['items'];
        $this->total_price_vat = $data['total_price_vat'];
    }

    /**
     * @return array
     */
    public function serialize() {
        $data = array(
            'total_price_vat' => $this->total_price_vat,
            'billing_address' => $this->billing_address->serialize(),
            'items' => array()
        );

        if ($this->delivery_address) {
            $data['delivery_address'] = $this->delivery_address->serialize();
        }
        
        foreach ($this->items as $item) {
            $data['items'][] = $item->serialize();
        }
        
        return $data;

    }
} 
