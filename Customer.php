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
     * @param array $data
     */
    public function __construct(array $data) {
        $this->name = isset($data['name']) ? $data['name'] : null;
        $this->email = $data['email'];
        $this->facebook_id = isset($data['facebook_id']) ? $data['facebook_id'] : null;
        $this->date_registered = isset($data['date_registered']) ? (new \DateTime($data['date_registered'])) : null;
        $this->promo_score = isset($data['promo_score']) ? $data['promo_score'] : null;
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
        
        return $data;
    }
}