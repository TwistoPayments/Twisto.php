<?php

namespace Twisto;


class OrderItem {
    /**
     * @var number
     */
    public $quantity;

    /**
     * @var string
     */
    public $name;

    /**
     * @var number
     */
    public $price;

    /**
     * @var number
     */
    public $price_vat;

    /**
     * @var number
     */
    public $vat;
     
    /**
     * @var bool
     */
    public $is_shipment;
     
    /**
     * @var bool
     */
    public $is_handling;

    /**
     * @var bool
     */
    public $is_payment;
    
    /**
     * @var array
     */
    public $categories;
    

    public function __construct(array $data) {
        $this->quantity = $data['quantity'];
        $this->name = $data['name'];
        $this->price = isset($data['price']) ? $data['price'] : null;
        $this->price_vat = $data['price_vat'];
        $this->vat = $data['vat'];
        $this->is_shipment = (isset($data['is_shipment']) and $data['is_shipment'] != 0) ? true : false;
        $this->is_handling = (isset($data['is_handling']) and $data['is_handling'] != 0) ? true : false;
        $this->is_payment = (isset($data['is_payment']) and $data['is_payment'] != 0) ? true : false;
        $this->categories = isset($data['categories']) ? $data['categories'] : null;
    }

    public function serialize() {
        $data = array(
            'quantity' => $this->quantity,
            'name' => $this->name,
            'price' => $this->price,
            'price_vat' => $this->price_vat,
            'vat' => $this->vat,
            'is_shipment' => ($this->is_shipment == false ? false : true),
            'is_handling' => ($this->is_handling == false ? false : true),
            'is_payment' => ($this->is_payment == false ? false : true),
            'categories' => array(),
        );

        if($this->categories) {
            foreach ($this->categories as $cat) {
                if($cat != null)
                    $data['categories'][] = $cat;
            }
        }
        
        return $data;
    }
} 
