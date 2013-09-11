<?php

namespace Twisto;


class BareAddress {
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
        $this->name = isset($data['name']) ? $data['name'] : null;
        $this->street = isset($data['street']) ? $data['street'] : null;  
        $this->city = isset($data['city']) ? $data['city'] : null;  
        $this->zipcode = $data['zipcode'];
        $this->country = isset($data['country']) ? $data['country'] : 'cz';  
        $this->phones_hash = $data['phones']; 
    }

    /**
     * @param string $phone
     * @return null|string
     */
    static private function normalizePhone($phone)
    {
        $phone = preg_replace('/(?<=.)\+/', '', $phone);
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        
        // prepend country dialing code when it isn't included
        if (strlen($phone) > 0 && $phone[0] != '+') {
            $phone = '+420' . $phone;
        }
        
        if (!preg_match('/^\+[0-9]{12}$/', $phone)) {
            return null;
        }

        return $phone;
    }

    /**
     * @return array
     */
    public function serialize() {
        $data = array(
            'name' => $this->name,
            'street' => $this->street,
            'city' => $this->city, 
            'zipcode' => $this->zipcode,
            'phones_hash' => array(),
            'country' => $this->country
        );

        if($this->phones_hash) {
            foreach ($this->phones_hash as $phone) {
                $phone = $this->normalizePhone($phone);
                if ($phone != null && !in_array($phone, $data['phones_hash']))
                    $data['phones_hash'][] = md5($phone);
            }
        }

        return $data;
    }

} 
