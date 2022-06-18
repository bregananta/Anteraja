<?php

namespace Bregananta\Anteraja\Tests\Feature;

use Bregananta\Anteraja\Facades\Anteraja;
use Bregananta\Anteraja\Tests\TestCase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

class AnterajaTest extends TestCase
{

    /** @test */
    public function get_anteraja_service_rate_test()
    {
        Http::preventStrayRequests();

        Http::fake();

        Anteraja::getServiceRates('31.73.06', '31.73.06', 1000);

        Http::assertSent(function (Request $request) {
            return $request->hasHeaders([
                'Content-Type' => 'application/json',
                'access-key-id' => config('anteraja-config.anterajaAccessKeyId'),
                'secret-access-key' => config('anteraja-config.anterajaSecretAccessKey')]) &&
                $request['origin'] == '31.73.06' &&
                $request['destination'] == '31.73.06' &&
                $request['weight'] == 1000;
        });
    }

    /** @test  */
    public function pre_order_regular_service_test()
    {
        Http::preventStrayRequests();

        Http::fake();

        $shipper = [
            'name' => 'JuliShop',
            'phone' => '081234324283',
            'email' => 'julishop@gmail.com',
            'district' => '32.75.09',
            'address' => 'Jl Kampung Pulo Pinang Ranti',
            'postcode' => '13510',
            'geoloc' => ''
        ];

        $receiver = [
            'name' => 'JuliBuyer',
            'phone' => '012931232139819',
            'email' => 'julibuyer@gmail.com',
            'district' => '32.75.09',
            'address' => 'Jalan Halim Perdanakusuma, RT.3/RW.4, Halim Perdana Kusumah',
            'postcode' => '13610',
            'geoloc' => ''
        ];

        $items = [
            'item_name' => 'Laptop 2',
            'item_desc' => 'Laptop ROG',
            'item_category' => 'Elektronik',
            'item_quantity' => 1,
            'declared_value' => 15000000,
            'weight' => 1000
        ];

        Anteraja::preOrder('SSI-010000443620220402','REG', $shipper, $receiver,
            $items, 15000000, true, 'SSI-010000443620220402', 1000);

        Http::assertSent(function (Request $request) {
            return $request->hasHeaders([
                    'Content-Type' => 'application/json',
                    'access-key-id' => config('anteraja-config.anterajaAccessKeyId'),
                    'secret-access-key' => config('anteraja-config.anterajaSecretAccessKey')]) &&
                $request['booking_id'] == 'SSI-010000443620220402' &&
                $request['service_code'] == 'REG' &&
                $request['invoice_no'] == 'SSI-010000443620220402' &&
                $request['parcel_total_weight'] == 1000 &&
                $request['use_insurance'] == true &&
                $request['declared_value'] == 15000000 &&
                $request['shipper']['name'] == 'JuliShop' &&
                $request['shipper']['phone'] == '081234324283' &&
                $request['shipper']['email'] == 'julishop@gmail.com' &&
                $request['shipper']['district'] == '32.75.09' &&
                $request['shipper']['address'] == 'Jl Kampung Pulo Pinang Ranti' &&
                $request['shipper']['postcode'] == '13510' &&
                $request['shipper']['geoloc'] == '' &&
                $request['receiver']['name'] == 'JuliBuyer' &&
                $request['receiver']['phone'] == '012931232139819' &&
                $request['receiver']['email'] == 'julibuyer@gmail.com' &&
                $request['receiver']['district'] == '32.75.09' &&
                $request['receiver']['address'] == 'Jalan Halim Perdanakusuma, RT.3/RW.4, Halim Perdana Kusumah' &&
                $request['receiver']['postcode'] == '13610' &&
                $request['receiver']['geoloc'] == '' &&
                $request['items']['item_name'] == 'Laptop 2' &&
                $request['items']['item_desc'] == 'Laptop ROG' &&
                $request['items']['item_category'] == 'Elektronik' &&
                $request['items']['item_quantity'] == 1 &&
                $request['items']['declared_value'] == 15000000 &&
                $request['items']['weight'] == 1000;
        });
    }

    /** @test  */
    public function order_regular_service_test()
    {
        Http::preventStrayRequests();

        Http::fake();

        $shipper = [
            'name' => 'JuliShop',
            'phone' => '081234324283',
            'email' => 'julishop@gmail.com',
            'district' => '32.75.09',
            'address' => 'Jl Kampung Pulo Pinang Ranti',
            'postcode' => '13510',
            'geoloc' => ''
        ];

        $receiver = [
            'name' => 'JuliBuyer',
            'phone' => '012931232139819',
            'email' => 'julibuyer@gmail.com',
            'district' => '32.75.09',
            'address' => 'Jalan Halim Perdanakusuma, RT.3/RW.4, Halim Perdana Kusumah',
            'postcode' => '13610',
            'geoloc' => ''
        ];

        $items = [
            'item_name' => 'Laptop 2',
            'item_desc' => 'Laptop ROG',
            'item_category' => 'Elektronik',
            'item_quantity' => 1,
            'declared_value' => 15000000,
            'weight' => 1000
        ];

        Anteraja::order('SSI-010000443620220402','REG', $shipper, $receiver,
            $items, '2022-06-12 14:00:00', 15000000, true, 'SSI-010000443620220402', 1000);

        Http::assertSent(function (Request $request) {
            return $request->hasHeaders([
                    'Content-Type' => 'application/json',
                    'access-key-id' => config('anteraja-config.anterajaAccessKeyId'),
                    'secret-access-key' => config('anteraja-config.anterajaSecretAccessKey')]) &&
                $request['booking_id'] == 'SSI-010000443620220402' &&
                $request['service_code'] == 'REG' &&
                $request['invoice_no'] == 'SSI-010000443620220402' &&
                $request['parcel_total_weight'] == 1000 &&
                $request['use_insurance'] == true &&
                $request['declared_value'] == 15000000 &&
                $request['shipper']['name'] == 'JuliShop' &&
                $request['shipper']['phone'] == '081234324283' &&
                $request['shipper']['email'] == 'julishop@gmail.com' &&
                $request['shipper']['district'] == '32.75.09' &&
                $request['shipper']['address'] == 'Jl Kampung Pulo Pinang Ranti' &&
                $request['shipper']['postcode'] == '13510' &&
                $request['shipper']['geoloc'] == '' &&
                $request['receiver']['name'] == 'JuliBuyer' &&
                $request['receiver']['phone'] == '012931232139819' &&
                $request['receiver']['email'] == 'julibuyer@gmail.com' &&
                $request['receiver']['district'] == '32.75.09' &&
                $request['receiver']['address'] == 'Jalan Halim Perdanakusuma, RT.3/RW.4, Halim Perdana Kusumah' &&
                $request['receiver']['postcode'] == '13610' &&
                $request['receiver']['geoloc'] == '' &&
                $request['items']['item_name'] == 'Laptop 2' &&
                $request['items']['item_desc'] == 'Laptop ROG' &&
                $request['items']['item_category'] == 'Elektronik' &&
                $request['items']['item_quantity'] == 1 &&
                $request['items']['declared_value'] == 15000000 &&
                $request['items']['weight'] == 1000 &&
                $request['expect_time'] == '2022-06-12 14:00:00';
        });
    }

    /** @test */
    public function request_pickup_test()
    {
        Http::preventStrayRequests();
        Http::fake();

        Anteraja::requestPickup('10000001088274','2022-06-12 13:39:00');

        Http::assertSent(function (Request $request) {
            return $request->hasHeaders([
                    'Content-Type' => 'application/json',
                    'access-key-id' => config('anteraja-config.anterajaAccessKeyId'),
                    'secret-access-key' => config('anteraja-config.anterajaSecretAccessKey')]) &&
                $request['waybill_no'] == '10000001088274' &&
                $request['expect_time'] == '2022-06-12 13:39:00';
        });
    }

    /** @test */
    public  function cancel_order_test()
    {
        Http::preventStrayRequests();
        Http::fake();

        Anteraja::cancelOrder('10000001088274');

        Http::assertSent(function (Request $request) {
            return $request->hasHeaders([
                    'Content-Type' => 'application/json',
                    'access-key-id' => config('anteraja-config.anterajaAccessKeyId'),
                    'secret-access-key' => config('anteraja-config.anterajaSecretAccessKey')]) &&
                $request['waybill_no'] == '10000001088274';
        });
    }

    /** @test */
    public function tracking_test()
    {
        Http::preventStrayRequests();
        Http::fake();

        Anteraja::tracking('10000001088274');

        Http::assertSent(function (Request $request) {
            return $request->hasHeaders([
                    'Content-Type' => 'application/json',
                    'access-key-id' => config('anteraja-config.anterajaAccessKeyId'),
                    'secret-access-key' => config('anteraja-config.anterajaSecretAccessKey')]) &&
                $request['waybill_no'] == '10000001088274';
        });
    }

    /** @test */
    public function get_insurance_info_test()
    {
        Http::preventStrayRequests();
        Http::fake();

        Anteraja::insurance(15000000, 'elektronik');

        Http::assertSent(function (Request $request) {
            return $request->hasHeaders([
                    'Content-Type' => 'application/json',
                    'access-key-id' => config('anteraja-config.anterajaAccessKeyId'),
                    'secret-access-key' => config('anteraja-config.anterajaSecretAccessKey')]) &&
                $request['declared_value'] == 15000000 &&
                $request['item_category'] == 'elektronik';
        });
    }
}