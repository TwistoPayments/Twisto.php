<?php
namespace Twisto;


class Invoice
{
    /** @var \Twisto\Twisto */
    private $twisto;

    /** @var string */
    public $invoice_id;

    /** @var string **/
    public $parent_invoice_id;

    /** @var string */
    public $eshop_invoice_id;

    /** @var string */
    public $customer_email;

    /** @var BaseAddress */
    public $billing_address;

    /** @var BaseAddress */
    public $delivery_address;

    /** @var \DateTime */
    public $date_created;

    /** @var \DateTime */
    public $date_returned;

    /** @var \DateTime */
    public $date_cancelled;

    /** @var \DateTime */
    public $date_activated;

    /** @var \DateTime */
    public $date_paid;

    /** @var string */
    public $pdf_url;

    /** @var float */
    public $total_price_vat;

    /** @var Item[] */
    public $items;

    /**
     * @param Twisto $twisto
     * @param string $invoice_id
     */
    public function __construct(Twisto $twisto, $invoice_id)
    {
        $this->twisto = $twisto;
        $this->invoice_id = $invoice_id;
    }

    /**
     * Fetch invoice data from API
     */
    public function get()
    {
        $data = $this->twisto->requestJson('GET', 'invoice/' . urlencode($this->invoice_id) . '/');
        $this->deserialize($data);
    }


    /**
     * Perform cancel invoice API request
     */
    public function cancel()
    {
        $data = $this->twisto->requestJson('POST', 'invoice/' . urlencode($this->invoice_id) . '/cancel/');
        $this->deserialize($data);
    }

    /**
     * Perform activate invoice API request
     */
    public function activate()
    {
        $data = $this->twisto->requestJson('POST', 'invoice/' . urlencode($this->invoice_id) . '/activate/');
        $this->deserialize($data);
    }

    /**
     * Save invoice items
     */
    public function save()
    {
        $data = $this->twisto->requestJson('POST', 'invoice/' . urlencode($this->invoice_id) . '/edit/', $this->serialize());
        $this->deserialize($data);
    }

    /**
     * Create new invoice using transaction_id from check
     * @param Twisto $twisto
     * @param string $transaction_id
     * @param string $eshop_invoice_id
     * @return Invoice
     */
    public static function create(Twisto $twisto, $transaction_id, $eshop_invoice_id = null)
    {
        $data = array(
            'transaction_id' => $transaction_id
        );

        if ($eshop_invoice_id !== null) {
            $data['eshop_invoice_id'] = $eshop_invoice_id;
        }

        $data = $twisto->requestJson('POST', 'invoice/', $data);
        $invoice = new Invoice($twisto, null);
        $invoice->deserialize($data);
        return $invoice;
    }


    /**
     * Perform invoice return API request
     * @param ItemReturn[] $items
     * @param ItemDiscountReturn[] $discounts
     */
    public function returnItems($items, $discounts = null)
    {
        $data = array(
            'items' => array_map(function(ItemReturn $item) {
                return $item->serialize();
            }, $items)
        );

        if ($discounts !== null) {
            $data['discounts'] = array_map(function(ItemDiscountReturn $item) {
                return $item->serialize();
            }, $discounts);
        }

        $data = $this->twisto->requestJson('POST', 'invoice/' . urlencode($this->invoice_id) . '/return/', $data);
        $this->deserialize($data);
    }

    /**
     * Perform invoice return all API request
     */
    public function returnAll()
    {
        $data = $this->twisto->requestJson('POST', 'invoice/' . urlencode($this->invoice_id) . '/return/all/');
        $this->deserialize($data);
    }


    /**
     * Split invoice to new one
     * @param ItemSplit[] $items
     * @return JSON response with new invoice
     */
    public function splitItems($items)
    {
        $data = array(
            'items' => array_map(function(ItemSplit $item) {
                return $item->serialize();
            }, $items)
        );

        $data = $this->twisto->requestJson('POST', 'invoice/' . urlencode($this->invoice_id) . '/split/', $data);
        $split_invoice = new Invoice($this->twisto, null);
        $split_invoice->deserialize($data);
        $this->get();

        return $split_invoice;
    }


    private function deserialize($data)
    {
        $this->invoice_id = $data['invoice_id'];
        $this->eshop_invoice_id = $data['eshop_invoice_id'];
        $this->customer_email = $data['customer_email'];
        $this->parent_invoice_id = $data['parent_invoice_id'];

        if ($data['billing_address']['type'] == BaseAddress::TYPE_SHORT) {
            $this->billing_address = ShortAddress::deserialize($data['billing_address']);
        }
        else {
            $this->billing_address = Address::deserialize($data['billing_address']);
        }

        if ($data['delivery_address']['type'] == BaseAddress::TYPE_SHORT) {
            $this->delivery_address = ShortAddress::deserialize($data['delivery_address']);
        }
        else {
            $this->delivery_address = Address::deserialize($data['delivery_address']);
        }

        if ($data['date_created'])
            $this->date_created = new \DateTime($data['date_created']);

        if ($data['date_returned'])
            $this->date_returned = new \DateTime($data['date_returned']);

        if ($data['date_cancelled'])
            $this->date_cancelled = new \DateTime($data['date_cancelled']);

        if ($data['date_activated'])
            $this->date_activated = new \DateTime($data['date_activated']);

        if ($data['date_paid'])
            $this->date_paid = new \DateTime($data['date_paid']);

        $this->pdf_url = $data['pdf_url'];
        $this->total_price_vat = (float)$data['total_price_vat'];

        $this->items = array_map(function($item) {
            return Item::deserialize($item);
        }, $data['items']);
    }

    private function serialize()
    {
        $data = array();

        if ($this->eshop_invoice_id !== null)
            $data['eshop_invoice_id'] = $this->eshop_invoice_id;

        if ($this->items !== null) {
            $data['items'] = array_map(function(Item $item) {
                return $item->serialize();
            }, $this->items);
        }

        return $data;
    }
}
