<?php

namespace Twisto;


class Customer
{
    /** @var string */
    public $email;

    /** @var string */
    public $name;

    /** @var string */
    public $facebook_id;

    /**
     * @param string $email
     * @param string $name
     * @param string $facebook_id
     */
    public function __construct($email, $name=null, $facebook_id=null)
    {
        $this->email = $email;
        $this->name = $name;
        $this->facebook_id = $facebook_id;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return array(
            'email' => $this->email,
            'name' => $this->name,
            'facebook_id' => $this->facebook_id
        );
    }
}