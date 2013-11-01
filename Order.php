<?php

namespace Twisto;


class Order {
    /**
     * @var string
     */
    public $order_id;

    /**
     * @var \DateTime
     */
    public $created;

    /**
     * @var Address
     */
    public $billing_address;
    
    /**
     * @var Address
     */
    public $delivery_address;

    /**
     * @var bool
     */
    public $total_price_vat;
     
    /**
     * @var bool
     */
    public $is_paid;

    /**
     * @var bool
     */
    public $is_shipped;
     
    /**
     * @var bool
     */
    public $is_delivered;
    
    /**
     * @var bool
     */
    public $is_returned;
    
     /**
     * @var OrderItem[]
     */
    public $items;

    /**
     * @param array $data
     */
    public function __construct(array $data) {
        $this->order_id = $data['order_id'];
        $this->created = new \DateTime($data['created']);
        $this->billing_address = $data['billing_address'];
        $this->delivery_address = isset($data['delivery_address']) ? $data['delivery_address'] : null;
        $this->total_price_vat = $data['total_price_vat'];
        $this->is_paid = $data['is_paid'];
        $this->is_shipped = $data['is_shipped'];
        $this->is_delivered = isset($data['is_delivered']) ? $data['is_delivered'] : null;
        $this->is_returned = isset($data['is_returned']) ? $data['is_returned'] : null;
        $this->items = $data['items'];
    }

    /**
     * @return array
     */
    public function serialize() {
        $data = array(
            'order_id' => $this->order_id,
            'created' => $this->created->format('c'), // ISO 8601
            'billing_address' => $this->billing_address->serialize(),
            'total_price_vat' => $this->total_price_vat,
            'is_paid' => $this->is_paid,
            'is_shipped' => $this->is_shipped,
            'items' => array()
        );

        if ($this->delivery_address !== null) {
            $data['delivery_address'] = $this->delivery_address->serialize();
        }

        if ($this->is_delivered !== null) {
            $data['is_delivered'] = $this->is_delivered;
        }

        if ($this->is_returned !== null) {
            $data['is_returned'] = $this->is_returned;
        }
        
        foreach ($this->items as $item) {
            $data['items'][] = $item->serialize();
        }
        
        return $data;

    }
}