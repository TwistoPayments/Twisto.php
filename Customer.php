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

    public function __construct(array $data) {
        $this->name = isset($data['name']) ? $data['name'] : null;
        $this->email = $data['email'];
        $this->facebook_id = isset($data['facebook_id']) ? $data['facebook_id'] : null;
        $this->date_registered = isset($data['date_registered']) ? (new \DateTime($data['date_registered'])) : null;
        $this->promo_score = isset($data['promo_score']) ? $data['promo_score'] : null;
    }

    public function serialize() {
        $data = array(
            'email' => trim(strtolower($this->email)),
            'promo_score' => $this->promo_score,
        );

        if ($this->name)
            $data['name'] = $this->name;

        if ($this->facebook_id)
            $data['facebook_id_hash'] = $this->facebook_id;
        
        if ($this->date_registered)
            $data['date_registered'] = $this->date_registered->format('c');
        
        return $data;
    }
}