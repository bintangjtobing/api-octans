<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use GuzzleHttp;
use App\Models\User;
use App\Helper\DatabaseHelper;

class PaymentController extends Controller
{
    public function store(Request $request)
    {

        // return ['tes'];
        $ch = curl_init();
        $secret_key = env('SECRETKEY_FLIP');
        $encoded_auth = base64_encode($secret_key . ":");
        $base_url = env('BASE_URL');

        curl_setopt($ch, CURLOPT_URL, $base_url."pwf/bill");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        $payloads = [
            "title" => 'bayar octans',
            "amount" => 10000,
            "type" => "SINGLE",
            "expired_date" => "2023-12-30 15:50",
            "redirect_url" => "", // Ganti dengan URL yang valid
            "is_address_required" => 0,
            "is_phone_number_required" => 0,
            'step' => 2,
            'sender_name' => 'bahari',
            'sender_email' => 'baharihari49@gmail.com',
            // 'sender_bank' => 'ovo',
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payloads));

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Basic " . $encoded_auth,
            "Content-Type: application/x-www-form-urlencoded"
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $dataResponse = json_decode($response);

        return $dataResponse;


        $payment = new Payment();

        $payment->title = $request->title;
        $payment->amount = $request->amount;
        $payment->status = 'pending';
        $payment->external_id = $dataResponse->link_id;
        $payment->url = $dataResponse->link_url;
        $payment->user_id = auth()->user()->id;

        if($payment->save()){
            $paymenId = Payment::where('user_id', auth()->user()->id)->value('id');
            User::where('id', auth()->user()->id)->update(['payment_id' => $paymenId]);
            return redirect('https://'.$dataResponse->link_url);
        }


    }

    public function changeStatus(Request $request)
    {
        $response = $request->data;
        $data = json_decode($response);

        $payment = Payment::where('external_id', $data->bill_link_id)->value('status');

        if ($payment == 'pending') {
            Payment::where('external_id', $data->bill_link_id)->update([
                'status' => strtolower($data->status),
                'langganan_berakhir' => DatabaseHelper::getNextMonth()
            ]);
        }

    }


    public function testPayment()
    {
        $ch = curl_init();
        $secret_key = env('SECRETKEY_FLIP');
        $encoded_auth = base64_encode($secret_key . ":");
        $base_url = env('BASE_URL');

        curl_setopt($ch, CURLOPT_URL, $base_url ."disbursement/bank-account-inquiry");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        $payloads = [
            "account_number" => "1212121214",
            "bank_code" => "bni",
            "amount" => "10000",
            "remark" => "some remark",
            "recipient_city" => "391",
            "beneficiary_email" => "test@mail.com,user@mail.com"
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payloads));

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Content-Type: application/x-www-form-urlencoded",
          "idempotency-key: idem-key-1",
          "X-TIMESTAMP: 2022-01-01T15:02:15+0700"
        ));

        curl_setopt($ch, CURLOPT_USERPWD, $secret_key.":");

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;

    }

    public function getBalance()
    {
        $ch = curl_init();
        $secret_key = env('SECRETKEY_FLIP');
        $encoded_auth = base64_encode($secret_key . ":");
        $base_url = env('BASE_URL');

        curl_setopt($ch, CURLOPT_URL, $base_url."general/balance");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Basic " . $encoded_auth,
            "Content-Type: application/x-www-form-urlencoded"
        ));

        curl_setopt($ch, CURLOPT_USERPWD, $secret_key.":");

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function createDisbrusment()
    {
        $client = new GuzzleHttp\Client();

        //$base_url = 'https://big.flip.id/api/v2';
        $base_url = env('BASE_URL');
        $secret_key = env('SECRETKEY_FLIP');

        $payload = [
            "account_number" => "5465327020",
            "bank_code" => "bca",
            "amount" => "21000000",
            "remark" => "test",
            "recipient_city" => "",
            "beneficiary_email" => "",
        ];

        $payload_acc_inq = [
            "account_number" => "<your_account_inq_number>",
            "bank_code" => "<bank_code_of_your_account>",
        ];

        $signature = DatabaseHelper::getSignature($payload);

        try {
            // Disbursement
            $response = $client->post($base_url. 'disbursement', [
                'form_params' => $payload,
                'auth' => [$secret_key.':',null],
                'headers' => [
                    'X-Signature' => $signature,
                    'idempotency-key' => 'bahari1234532', // Gantilah dengan kunci idempoten yang unik
                ]
            ]);

                return $response->getBody()->getContents();
            } catch (\Exception $e) {
                echo $e->getMessage();
            }

    }

    public function getDisbrusementById()
    {

        $client = new GuzzleHttp\Client();

        //$base_url = 'https://big.flip.id/api/v2';
        $base_url = env('BASE_URL');
        $secret_key = env('SECRETKEY_FLIP');

        $payload = [
            "id" => "127854"
        ];

        $payload_acc_inq = [
            "account_number" => "<your_account_inq_number>",
            "bank_code" => "<bank_code_of_your_account>",
        ];

        $signature = DatabaseHelper::getSignature($payload);

        try {
            // Disbursement
            $response = $client->get($base_url.'get-disbursement?id=127854', [
                'form_params' => $payload,
                'auth' => [$secret_key.':',null],
                'headers' => [
                    'X-Signature' => $signature,
                    'idempotency-key' => '2334567890', // Gantilah dengan kunci idempoten yang unik
                ]
            ]);

                return $response->getBody()->getContents();
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
    }

    public function getDisbrusementByIdempotency()
    {
        $client = new GuzzleHttp\Client();
        $base_url = env('BASE_URL');
        $secret_key = env('SECRETKEY_FLIP');

        $payload = [
            "idempotency-key" => "idem-key-3"
        ];

        $payload_acc_inq = [
            "account_number" => "<your_account_inq_number>",
            "bank_code" => "<bank_code_of_your_account>",
        ];


        $signature = DatabaseHelper::getSignature($payload);

        try {
            // Disbursement
            $response = $client->get($base_url.'get-disbursement?idempotency-key=idem-key-3', [
                'form_params' => $payload,
                'auth' => [$secret_key.':',null],
                'headers' => [
                    'X-Signature' => $signature,
                    // 'idempotency-key' => '2334567890', // Gantilah dengan kunci idempoten yang unik
                ]
            ]);

                return $response->getBody()->getContents();
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
    }

    public function getAllDisbrusment()
    {
        $client = new GuzzleHttp\Client();

        //$base_url = 'https://big.flip.id/api/v2';
        $base_url = env('BASE_URL');
        $secret_key = env('SECRETKEY_FLIP');

        $payload = [
            "pagination" => '10',
            "page" => '10',
            // "sort" => 'sort',
            // "attribute" => 'value'
        ];

        $signature = DatabaseHelper::getSignature($payload);

        try {
            // Disbursement
            $response = $client->get($base_url.'disbursement?pagination=10&page=10', [
                'form_params' => $payload,
                'auth' => [$secret_key.':',null],
                'headers' => [
                    'X-Signature' => $signature,
                    // 'idempotency-key' => '2334567890', // Gantilah dengan kunci idempoten yang unik
                ]
            ]);

                return $response->getBody()->getContents();
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
    }

    public function cityList()
    {
        $client = new GuzzleHttp\Client();

        $base_url = env('BASE_URL');
        $secret_key = env('SECRETKEY_FLIP');

        $payload = [];

        $signature = DatabaseHelper::getSignature($payload);

        try {
            // Disbursement
            $response = $client->get($base_url.'disbursement/city-list', [
                'form_params' => $payload,
                'auth' => [$secret_key.':',null],
                'headers' => [
                    'X-Signature' => $signature,
                    // 'idempotency-key' => '2334567890', // Gantilah dengan kunci idempoten yang unik
                ]
            ]);

                return $response->getBody()->getContents();
            } catch (\Exception $e) {
                echo $e->getMessage();
            }


    }

    public function countryList()
    {
        $client = new GuzzleHttp\Client();

        $base_url = env('BASE_URL');
        $secret_key = env('SECRETKEY_FLIP');

        $payload = [];

        $signature = DatabaseHelper::getSignature($payload);

        try {
            // Disbursement
            $response = $client->get($base_url.'disbursement/country-list', [
                'form_params' => $payload,
                'auth' => [$secret_key.':',null],
                'headers' => [
                    'X-Signature' => $signature,
                    // 'idempotency-key' => '2334567890', // Gantilah dengan kunci idempoten yang unik
                ]
            ]);

                return $response->getBody()->getContents();
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
    }


    public function cityAndCountryList()
    {
        $client = new GuzzleHttp\Client();

        $base_url = env('BASE_URL');
        $secret_key = env('SECRETKEY_FLIP');

        $payload = [];

        $signature = DatabaseHelper::getSignature($payload);

        try {
            // Disbursement
            $response = $client->get($base_url.'disbursement/city-country-list', [
                'form_params' => $payload,
                'auth' => [$secret_key.':',null],
                'headers' => [
                    'X-Signature' => $signature,
                    // 'idempotency-key' => '2334567890', // Gantilah dengan kunci idempoten yang unik
                ]
            ]);

                return $response->getBody()->getContents();
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
    }

    public function bankAccountInquiry()
    {
        $client = new GuzzleHttp\Client();

        $base_url = env('BASE_URL');
        $secret_key = env('SECRETKEY_FLIP');

        $payload_acc_inq = [
            "account_number" => "067201000299301",
            "bank_code" => "bri",
            "inquiry_key" => "aVncCDdKW9dciRvH9qSH"
        ];
        $signature_acc_inq= DatabaseHelper::getSignature($payload_acc_inq);

        try {
            //    Account Inquiry
        $response = $client->post($base_url.'disbursement/bank-account-inquiry', [
            'form_params' => $payload_acc_inq,
            'auth' => [$secret_key.':',null],
            'headers' => [
                'X-Signature' => $signature_acc_inq,
            ]
        ]);

                return $response->getBody()->getContents();
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
    }
}
