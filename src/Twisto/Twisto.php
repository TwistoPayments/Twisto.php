<?php
namespace Twisto;


class Twisto
{
    /** @var string */
    private $public_key;

    /** @var string */
    private $secret_key;

    /** @var string  */
    private $api_url = 'https://api.twisto.cz/v2/';

    /**
     * @param string $public_key
     */
    public function Twisto($public_key = null)
    {
        $this->public_key = $public_key;
    }

    /**
     * @param string $key
     */
    public function setSecretKey($key)
    {
        $this->secret_key = $key;
    }

    /**
     * @param string $key
     */
    public function setPublicKey($key)
    {
        $this->public_key = $key;
    }

    /**
     * @param string $api_url
     */
    public function setApiUrl($api_url)
    {
        $this->api_url = $api_url;
    }

    /**
     * Encrypt data with AES-128-CBC and HMAC-SHA-256
     * @param string $data
     * @return string
     */
    private function encrypt($data)
    {
        $bin_key = pack("H*", substr($this->secret_key, 8));
        $aes_key = substr($bin_key, 0, 16);
        $salt = substr($bin_key, 16, 16);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_DEV_URANDOM);
        $encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $aes_key, $data, MCRYPT_MODE_CBC, $iv);
        $digest = hash_hmac('sha256', $data . $iv, $salt, true);
        return base64_encode($iv . $digest . $encrypted);
    }

    /**
     * Compress data and prefix them with payload length
     * @param string $data
     * @return string
     */
    private function compress($data)
    {
        $gz_data = gzcompress($data, 9);
        return pack("N", strlen($gz_data)) . $gz_data;
    }

    /**
     * Perform API request and decode response JSON
     * @param string $method
     * @param string $url
     * @param array $data
     * @return mixed
     * @throws Error
     */
    public function requestJson($method, $url, $data = null)
    {
        $response = $this->request($method, $url, $data);

        $json = json_decode($response, true);
        if ($json === null) {
            throw new Error('API responded with invalid JSON');
        }

        return $json;
    }


    /**
     * Perform API request
     * @param string $method
     * @param string $url
     * @param array $data
     * @return mixed
     * @throws Error
     */
    public function request($method, $url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: {$this->public_key},{$this->secret_key}"
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, $this->api_url . $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

        if ($data !== null) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            throw new Error('Curl error: ' . curl_error($curl));
        }

        $info = curl_getinfo($curl);
        if ($info['http_code'] != 200) {
            throw new Error('API responded with wrong status code (' . $info['http_code'] . ')', json_decode($response));
        }

        return $response;
    }

    /**
     * Create check payload
     * @param Customer $customer
     * @param Order $order
     * @param Order[] $previous_orders
     * @return string
     */
    public function getCheckPayload(Customer $customer, Order $order, $previous_orders)
    {
        $payload = json_encode(array(
            'random_nonce' => uniqid('', true),
            'customer' => $customer->serialize(),
            'order' => $order->serialize(),
            'previous_orders' => array_map(function (Order $item) {
                return $item->serialize();
            }, $previous_orders)
        ));
        return $this->encrypt($this->compress($payload));
    }
}
