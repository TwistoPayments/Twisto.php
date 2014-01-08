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
    public $is_discount;

    /**
     * @var bool
     */
    public $is_payment;
    
    /**
     * @var array
     */
    public $categories;

    /**
     * @var string
     */
    public $product_id;

    /**
     * @param array $data
     */
    public function __construct(array $data) {
        $this->quantity = $data['quantity'];
        $this->name = $data['name'];
        $this->price_vat = $data['price_vat'];
        $this->vat = $data['vat'];
        $this->is_shipment = isset($data['is_shipment']) ? $data['is_shipment'] : null;
        $this->is_payment = isset($data['is_payment']) ? $data['is_payment'] : null;
        $this->is_discount = isset($data['is_discount']) ? $data['is_discount'] : null;
        $this->categories = isset($data['categories']) ? $data['categories'] : null;
        $this->product_id = isset($data['product_id']) ? $data['product_id'] : null;
    }

    /**
     * @return array
     */
    public function serialize() {
        $data = array(
            'quantity' => $this->quantity,
            'name' => $this->name,
            'price_vat' => $this->price_vat,
            'vat' => $this->vat,
        );

        if ($this->is_shipment !== null)
            $data['is_shipment'] = $this->is_shipment;

        if ($this->is_payment !== null)
            $data['is_payment'] = $this->is_payment;

        if ($this->is_discount !== null)
            $data['is_discount'] = $this->is_discount;

        if($this->categories !== null) {
            $data['categories'] = array();
            foreach ($this->categories as $cat) {
                if($cat != null)
                    $data['categories'][] = $cat;
            }
        }

        if ($this->product_id !== null) {
            $data['product_id'] = $this->product_id;
        }
        
        return $data;
    }
} 
