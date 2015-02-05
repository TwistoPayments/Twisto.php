<?php
namespace Twisto;

class ItemDiscountReturn
{
    /** @var string */
    public $product_id;

    /** @var float */
    public $price_vat;

    /**
     * @param string $product_id
     * @param float $price_vat
     */
    function __construct($product_id, $price_vat)
    {
        $this->product_id = $product_id;
        $this->price_vat = $price_vat;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return array(
            'product_id' => $this->product_id,
            'price_vat' => $this->price_vat
        );
    }
}