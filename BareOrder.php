<?php

namespace Twisto;


class BareOrder {
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
     * @var number
     */
    public $total_price_vat;

    /**
     * @var bool
     */
    public $is_paid;

    /**
     * @var bool
     */
    public $is_delivered;    

    /**
     * @var bool
     */
    public $is_returned;

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
        $this->is_shipped = $data['is_paid'];
        $this->is_delivered = isset($data['is_delivered']) ? $data['is_delivered'] : null;
        $this->is_returned = isset($data['is_returned']) ? $data['is_returned'] : null;
    }

    /**
     * @return array
     */
    public function serialize() {
        $data = array(
            'order_id' => $this->order_id,
            'created' => $this->created->format('c'), // ISO 8601
            'billing_address' => $this->billing_address->serialize(),
            'approx_total_price' => ($this->total_price_vat <= 500 ? 1 : 2),
            'is_paid' => $this->is_paid,
            'is_shipped' => $this->is_shipped,
            'is_delivered' => $this->is_delivered,
            'is_returned' => $this->is_returned,
        );

        if ($this->delivery_address)
            $data['delivery_address'] = $this->delivery_address->serialize();

        return $data;
    }
}