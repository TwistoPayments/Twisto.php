<?php

namespace Twisto;


class ShortAddress implements BaseAddress
{
    /** @var string */
    public $name;

    /** @var string */
    public $phone_number;

    /** @var string */
    public $country;

    /**
     * @param string $name
     * @param string $country
     * @param string $phone_number
     */
    public function __construct($name, $country, $phone_number)
    {
        $this->name = $name;
        $this->country = $country;
        $this->phone_number = $phone_number;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return array(
            'type' => self::TYPE_SHORT,
            'name' => $this->name,
            'country' => $this->country,
            'phone_number' => $this->phone_number
        );
    }

    public static function deserialize($data)
    {
        return new self($data['name'], $data['country'], $data['phone_number']);
    }
}