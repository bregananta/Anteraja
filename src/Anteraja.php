<?php

namespace Bregananta\Anteraja;

use Illuminate\Support\Facades\Http;

class Anteraja
{

    /**
     * @param $origin
     * @param $destination
     * @param $weight
     * @return string
     */
    public function getServiceRates($origin, $destination, $weight)
    {
        $body = [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight
        ];

        return $this->apiRequest('serviceRates', $body);
    }

    /**
     * @param $booking_id
     * @param $service_code
     * @param array $shipper
     * @param array $receiver
     * @param array $items
     * @param $declaredValue
     * @param bool $useInsurance
     * @param string $invoice_no
     * @param string $parcel_total_weight
     * @return string
     */
    public function preOrder($booking_id, $service_code, array $shipper, array $receiver, array $items, $declaredValue,
                             bool $useInsurance = false, string $invoice_no = '', string $parcel_total_weight = '')
    {
        $body = [
            'booking_id' => $booking_id,
            'invoice_no' => $invoice_no,
            'service_code' => $service_code,
            'parcel_total_weight' => $parcel_total_weight,
            'shipper' => $shipper,
            'receiver' => $receiver,
            'items' => $items,
            'use_insurance' => $useInsurance,
            'declared_value' => $declaredValue,
        ];

        return $this->apiRequest('preorder', $body);
    }

    /**
     * @param $booking_id
     * @param $service_code
     * @param array $shipper
     * @param array $receiver
     * @param array $items
     * @param $expectedPickupTime
     * @param $declaredValue
     * @param bool $useInsurance
     * @param string $invoice_no
     * @param $parcel_total_weight
     * @return string
     */
    public function order($booking_id, $service_code, array $shipper, array $receiver, array $items, $expectedPickupTime,
                          $declaredValue, bool $useInsurance = false, string $invoice_no = '', $parcel_total_weight = null)
    {
        $body = [
            'booking_id' => $booking_id,
            'invoice_no' => $invoice_no,
            'service_code' => $service_code,
            'parcel_total_weight' => $parcel_total_weight,
            'shipper' => $shipper,
            'receiver' => $receiver,
            'items' => $items,
            'use_insurance' => $useInsurance,
            'declared_value' => $declaredValue,
            'expect_time' => $expectedPickupTime
        ];

        return $this->apiRequest('order', $body);
    }

    /**
     * @param $waybillNo
     * @param $expectedTime
     * @return string
     */
    public function requestPickup($waybillNo, $expectedTime = null)
    {
        $body = [
            'waybill_no' => $waybillNo,
            'expect_time' => $expectedTime
        ];

        return $this->apiRequest('requestPickup', $body);
    }

    /**
     * @param $waybillNo
     * @return string
     */
    public function cancelOrder($waybillNo)
    {
        $body = [
            'waybill_no' => $waybillNo
        ];

        return $this->apiRequest('cancelOrder', $body);
    }

    /**
     * @param $waybillNo
     * @return string
     */
    public function tracking($waybillNo)
    {
        $body = [
            'waybill_no' => $waybillNo
        ];

        return $this->apiRequest('tracking', $body);
    }

    /**
     * @param $waybillNo
     * @param $itemCategory
     * @return string
     */
    public function insurance($declaredValue, $itemCategory)
    {
        $body = [
            'declared_value' => $declaredValue,
            'item_category' => $itemCategory
        ];

        return $this->apiRequest('insurance', $body);
    }

    /**
     * @param $path
     * @param $body
     * @return string
     */
    protected function apiRequest($path, $body)
    {
        $url = config('anteraja-config.anterajaBasePath') .'/'. $path;

        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'access-key-id' => config('anteraja-config.anterajaAccessKeyId'),
            'secret-access-key' => config('anteraja-config.anterajaSecretAccessKey')
        ])->post($url, $body)->body();
    }

}