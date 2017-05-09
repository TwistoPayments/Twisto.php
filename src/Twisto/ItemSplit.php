<?php
namespace Twisto;

class ItemSplit
{
    /** @var string */
    public $product_id;

    /** @var int */
    public $quantity;

    /**
     * @param string $product_id
     * @param int $quantity
     */
    function __construct($product_id, $quantity)
    {
        $this->product_id = $product_id;
        $this->quantity = (int)$quantity;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return array(
            'product_id' => $this->product_id,
            'quantity' => $this->quantity
        );
    }

    public static function deserialize($data)
    {
        return new self($data['product_id'], $data['quantity']);
    }
}