<?php

namespace Twisto;


class BareCustomer {
    public $email;
    public $facebook_id;

    public function __construct(array $data) {
        $this->email = $data['email'];
        $this->facebook_id = isset($data['facebook_id']) ? $data['facebook_id'] : null;
    }

    public function serialize() {
        $data = array(
            'email_hash' => md5(trim(strtolower($this->email))),
        );

        if ($this->facebook_id)
            $data['facebook_id_hash'] = md5($this->facebook_id);
		
        return $data;
    }
}