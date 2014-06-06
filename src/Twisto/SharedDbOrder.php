<?php

namespace Twisto;


class SharedDbOrder
{
    /** @var string */
    public $order_id;

    /** @var \DateTime */
    public $date_created;

    /** @var float */
    public $total_price_vat;

    /**
     * @param string $order_id
     * @param \DateTime $date_created
     * @param float $total_price_vat
     */
    public function __construct($order_id, \DateTime $date_created, $total_price_vat)
    {
        $this->order_id = $order_id;
        $this->date_created = $date_created;
        $this->total_price_vat = $total_price_vat;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return array(
            'order_id' => $this->order_id,
            'date_created' => $this->date_created->format('c'), // ISO 8601
            'approx_total_price' => ($this->total_price_vat <= 500 ? 1 : 2)
        );
    }
}
