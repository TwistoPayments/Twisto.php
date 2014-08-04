<?php

namespace Twisto;


class SharedDbAddress
{
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
    public function __construct(array $data)
    {
        $this->street = isset($data['street']) ? $data['street'] : null;
        $this->city = isset($data['city']) ? $data['city'] : null;
        $this->zipcode = $data['zipcode'];
        $this->country = isset($data['country']) ? $data['country'] : null;
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
    public function serialize()
    {
        $data = array(
            'zipcode' => $this->zipcode
        );

        if ($this->street !== null)
            $data['street'] = $this->street;

        if ($this->city !== null)
            $data['city'] = $this->city;

        if ($this->country !== null)
            $data['country'] = $this->country;

        if ($this->phones_hash !== null) {
            $data['phones_hash'] = array();
            foreach ($this->phones_hash as $phone) {
                $phone = $this->normalizePhone($phone);
                if ($phone != null && !in_array($phone, $data['phones_hash']))
                    $data['phones_hash'][] = md5($phone);
            }
        }

        return $data;
    }

} 
