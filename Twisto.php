<?php
namespace Twisto;

require_once 'BareCustomer.php';
require_once 'BareOrder.php';
require_once 'SharedDbResponse.php';
require_once 'CheckResponse.php';
require_once 'Address.php';
require_once 'BareAddress.php';
require_once 'Customer.php';
require_once 'Order.php';
require_once 'OrderItem.php';
require_once 'NewOrder.php';

class Twisto {
    /**
     * @var string
     */
    private $public_key;

    /**
     * @var string
     */
    private $secret_key;

    /**
     * @param null|string $public_key
     */
    public function Twisto($public_key = null) {
        $this->public_key = $public_key;
    }

    /**
     * @param string $key
     */
    public function setSecretKey($key) {
        $this->secret_key = $key;
    }

    /**
     * @param string $key
     */
    public function setPublicKey($key) {
        $this->public_key = $key;
    }

    /**
     * Encrypts data with AES-128-CBC and HMAC-SHA-256
     * @param string $data
     * @return string
     */
    private function encrypt($data) {
        $bin_key = pack("H*", substr($this->secret_key, 8));
        $aes_key = substr($bin_key, 0, 16);
        $salt = substr($bin_key, 16, 16);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_DEV_URANDOM);
        $encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $aes_key, $data, MCRYPT_MODE_CBC, $iv);
        $digest = hash_hmac('sha256', $data.$iv, $salt, true);
        return base64_encode($iv.$digest.$encrypted);
    }

    /**
     * Create encrypted precheck payload
     * @param BareCustomer $customer
     * @param BareOrder[] $orders
     * @return string
     */
    public function getPrecheckPayload(BareCustomer $customer, array $orders) {
        $payload = json_encode(array(
            'customer' => $customer->serialize(),
            'orders' => array_map(function($c) { return $c->serialize(); }, $orders)
        ));
        return $this->encrypt(gzcompress($payload, 9));
    }

    /**
     * Create check payload
     * @param Customer $customer
     * @param NewOrder $order
     * @return string
     */
    public function getCheckPayload(Customer $customer, NewOrder $order) {
        return json_encode(array(
            'customer' => $customer->serialize(),
            'order' => $order->serialize()
        ));
    }

}
