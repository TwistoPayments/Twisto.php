<?php

namespace Twisto;


class Address
{
    /** @var string */
    public $name;

    /** @var string */
    public $street;

    /** @var string */
    public $city;

    /** @var string */
    public $zipcode;

    /** @var string */
    public $phone_number;

    /** @var string */
    public $country;

    /**
     * @param string $name
     * @param string $street
     * @param string $city
     * @param string $zipcode
     * @param string $country
     * @param string $phone_number
     */
    public function __construct($name, $street, $city, $zipcode, $country, $phone_number)
    {
        $this->name = $name;
        $this->street = $street;
        $this->city = $city;
        $this->zipcode = $zipcode;
        $this->country = $country;
        $this->phone_number = $phone_number;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return array(
            'name' => $this->name,
            'street' => $this->street,
            'city' => $this->city,
            'zipcode' => $this->zipcode,
            'country' => $this->country,
            'phone_number' => $this->phone_number
        );
    }

    public static function deserialize($data)
    {
        return new self($data['name'], $data['street'], $data['city'], $data['zipcode'], $data['country'], $data['phone_number']);
   }
}