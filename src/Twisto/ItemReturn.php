<?php
namespace Twisto;

class ItemReturn
{
    /** @var string */
    public $product_id;

    /** @var int */
    public $quantity;

    /**
     * @param string $product_id
     * @param int $quantity
     * @param float $price_vat
     */
    function __construct($product_id, $quantity, $price_vat = null)
    {
        $this->product_id = $product_id;
        $this->quantity = (int)$quantity;
        $this->price_vat = $price_vat;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        $data = array(
            'product_id' => $this->product_id,
            'quantity' => $this->quantity
        );

        if ($this->price_vat !== null)
            $data['price_vat'] = $this->price_vat;

        return $data;
    }
}