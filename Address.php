<?php

namespace Twisto;


class Address {
    /**
     * @var string
     */
    public $name;
    
    /**
     * @var string
     */
    public $street;

    /**
     * @var string
     */
    public $city;

    /**
     * @var string
     */
    public $zipcode;

    /**
     * @var string
     */
    public $country;
    
    /**
    * @var array
    */
    public $phones;

    /**
     * @param array $data
     */
    public function __construct(array $data) {
        $this->name = $data['name'];
        $this->street = $data['street'];  
        $this->city = $data['city'];  
        $this->zipcode = $data['zipcode'];
        $this->country = isset($data['country']) ? $data['country'] : null;
        $this->phones = isset($data['phones']) ? $data['phones'] : null;
    }

    /**
     * @return array
     */
    public function serialize() {
        $data = array(
            'name' => $this->name,
            'street' => $this->street,
            'city' => $this->city, 
            'zipcode' => $this->zipcode
        );

        if ($this->country !== null)
            $data['country'] = $this->country;
        
        if($this->phones !== null) {
            $data['phones'] = array();
            foreach ($this->phones as $phone) {
                if ($phone != null && !in_array($phone, $data['phones']))
                    $data['phones'][] = $phone;
            }
        }
        
        return $data;
    }

}