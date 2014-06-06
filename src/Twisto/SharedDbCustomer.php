<?php

namespace Twisto;


class SharedDbCustomer
{
    /** @var string */
    public $email;

    /** @var string */
    public $facebook_id;

    /**
     * @param string $email
     * @param string $facebook_id
     */
    public function __construct($email, $facebook_id)
    {
        $this->email = $email;
        $this->facebook_id = $facebook_id;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        $data = array(
            'email_hash' => md5(trim(strtolower($this->email))),
        );

        if ($this->facebook_id !== null)
            $data['facebook_id_hash'] = md5($this->facebook_id);

        return $data;
    }
}