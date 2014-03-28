<?php

namespace Twisto;


class Customer {
     /**
     * @var string
     */
    public $name;
    
    /**
     * @var string
     */
    public $email;
    
    /**
     * @var string
     */
    public $facebook_id;
    
    /**
     * @var DateTime
     */
    public $date_registered;
    
    /**
     * @var number
     */
    public $promo_score;

    /**
     * @var string
     */
    public $customer_id;

    /**
     * @param array $data
     */
    public function __construct(array $data) {
        $this->name = isset($data['name']) ? $data['name'] : null;
        $this->email = $data['email'];
        $this->facebook_id = isset($data['facebook_id']) ? $data['facebook_id'] : null;
        $this->date_registered = isset($data['date_registered']) ? (new \DateTime($data['date_registered'])) : null;
        $this->promo_score = isset($data['promo_score']) ? $data['promo_score'] : null;
        $this->customer_id = isset($data['customer_id']) ? $data['customer_id'] : null;
    }

    /**
     * @return array
     */
    public function serialize() {
        $data = array(
            'email' => trim(strtolower($this->email))
        );

        if ($this->name !== null)
            $data['name'] = $this->name;

        if ($this->facebook_id !== null)
            $data['facebook_id'] = $this->facebook_id;

        if ($this->date_registered !== null)
            $data['date_registered'] = $this->date_registered->format('c');

        if ($this->promo_score !== null)
            $data['promo_score'] = $this->promo_score;

        if ($this->customer_id !== null)
            $data['customer_id'] = $this->customer_id;

        return $data;
    }
}