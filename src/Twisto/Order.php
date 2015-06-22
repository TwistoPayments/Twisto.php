<?php

namespace Twisto;


class Order
{
    /** @var \DateTime */
    public $date_created;

    /** @var BaseAddress */
    public $billing_address;

    /** @var BaseAddress */
    public $delivery_address;

    /** @var float */
    public $total_price_vat;

    /** @var Item[] */
    public $items;

    /**
     * @param \DateTime $date_created
     * @param BaseAddress $billing_address
     * @param BaseAddress $delivery_address
     * @param float $total_price_vat
     * @param Item[] $items
     */
    public function __construct(\DateTime $date_created, BaseAddress $billing_address, BaseAddress $delivery_address, $total_price_vat, $items)
    {
        $this->date_created = $date_created;
        $this->billing_address = $billing_address;
        $this->delivery_address = $delivery_address;
        $this->total_price_vat = (float)$total_price_vat;
        $this->items = $items;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return array(
            'date_created' => $this->date_created->format('c'), // ISO 8601
            'billing_address' => $this->billing_address->serialize(),
            'delivery_address' => $this->delivery_address->serialize(),
            'total_price_vat' => $this->total_price_vat,
            'items' => array_map(function (Item $order) {
                return $order->serialize();
            }, $this->items)
        );
    }
}