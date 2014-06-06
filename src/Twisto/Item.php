<?php
namespace Twisto;

class Item
{
    /* Types */
    const TYPE_DEFAULT = 0;
    const TYPE_SHIPMENT = 1;
    const TYPE_PAYMENT = 2;
    const TYPE_DISCOUNT = 4;
    const TYPE_ROUND = 32;

    /** @var int */
    public $type;

    /** @var string */
    public $name;

    /** @var string */
    public $product_id;

    /** @var int */
    public $quantity;

    /** @var float */
    public $price_vat;

    /** @var float */
    public $vat;

    /** @var string */
    public $ean_code;

    /** @var string */
    public $isbn_code;

    /** @var string */
    public $issn_code;

    /**
     * @param int $type
     * @param string $name
     * @param string $product_id
     * @param int $quantity
     * @param float $price_vat
     * @param float $vat
     * @param string $ean_code
     * @param string $isbn_code
     * @param string $issn_code
     */
    function __construct($type, $name, $product_id, $quantity, $price_vat, $vat, $ean_code=null, $isbn_code=null, $issn_code=null)
    {
        $this->type = (int)$type;
        $this->name = $name;
        $this->product_id = $product_id;
        $this->quantity = (int)$quantity;
        $this->price_vat = (float)$price_vat;
        $this->vat = (float)$vat;
        $this->ean_code = $ean_code;
        $this->isbn_code = $isbn_code;
        $this->issn_code = $issn_code;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return array(
            'type' => $this->type,
            'name' => $this->name,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'price_vat' => $this->price_vat,
            'vat' => $this->vat,
            'ean_code' => $this->ean_code,
            'isbn_code' => $this->isbn_code,
            'issn_code' => $this->issn_code
        );
    }

    public static function deserialize($data)
    {
        return new self($data['type'], $data['name'], $data['product_id'], $data['quantity'], $data['price_vat'], $data['vat'], $data['ean_code'], $data['isbn_code'], $data['issn_code']);
    }
}