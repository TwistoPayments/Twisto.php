<?php

namespace Twisto;


class BareCustomer {
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $facebook_id;

    /**
     * @param array $data
     */
    public function __construct(array $data) {
        $this->email = $data['email'];
        $this->facebook_id = isset($data['facebook_id']) ? $data['facebook_id'] : null;
    }

    /**
     * @return array
     */
    public function serialize() {
        $data = array(
            'email_hash' => md5(trim(strtolower($this->email))),
        );

        if ($this->facebook_id)
            $data['facebook_id_hash'] = md5($this->facebook_id);

        return $data;
    }
}