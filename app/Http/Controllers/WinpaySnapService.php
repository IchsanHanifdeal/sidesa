<?php

namespace App\Http\Controllers;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WinpaySnapService
{

    protected $signature;

    protected $apiUrl;
    protected $client;

    protected $listenerUrl = "";
    protected $callbackUrl = "";

    private $lastLogId = null;

    public function __construct()
    {
        $this->apiUrl = "dev";
        $this->client = new \GuzzleHttp\Client();
    }

    private function getCurl($requestUrl, $fields, $headers = [], $request_form = 'form_params', $verb = 'GET')
    {
        $data = ['http_errors' => false];
        if (!empty($fields)) {
            $data[$request_form] = $fields;
        }
        if (!empty($headers)) {
            $data['headers'] = $headers;
        }
        $response = $this->client->request($verb, $requestUrl, $data);
        // $dataXml = new \SimpleXMLElement($response->getBody());
        $data = $response->getBody();
        $dataArray = json_decode($data, true);
        return $dataArray;
    }
    public function getAvailableChannels()
    {
        return collect(DB::table('winpay_channel')->where('status', 1)->get())->map(function ($item) {
            return (array)$item;
        });
    }



    public function setPayment($data)
    {

        $payment = collect($this->getAvailableChannels())->where('code_snap', $data['channel'])->first();

        $payload = [];
        $httpMethod = "POST";
        $endpointUrl = "";
        if($payment['code_snap'] == 'QRIS'){
            $payload = [
                "partnerReferenceNo" =>  $data['ref'],
                "amount" => [
                    "value" => (string)floatval($data['amount']),
                    "currency" => "IDR"
                ],
                "validityPeriod" => $data['expired'],
                "additionalInfo" => [
                    "isStatic" => false
                ]
            ];
            $endpointUrl = "/v1.0/qr/qr-mpm-generate";
        }else{
            $payload = [
                "customerNo" => $data['sku'],
                "virtualAccountName" => $data['name'],
                "trxId" => $data['ref'],
                "totalAmount" => [
                    "value" => (string)floatval($data['amount']),
                    "currency" => "IDR"
                ],
                "virtualAccountTrxType" => "c",
                "expiredDate" => $data['expired'],
                "additionalInfo" => [
                    "channel" => $payment['code_snap']
                ]
            ];
            $endpointUrl = "/v1.0/transfer-va/create-va";
        }

        $this->lastLogId = DB::table('winpay_log')->insertGetId([
            'log_type' => 'SEND',
            'log_data' => json_encode($payload),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $dateTime = new DateTime();
        $dateTime->setTimezone(new DateTimeZone('+07:00')); // Set the timezone to +07:00

        $formattedTimestamp = $dateTime->format('Y-m-d\TH:i:sP'); // Format the date
        $signature = $this->generateSignature($endpointUrl, $payload, $formattedTimestamp, $httpMethod);

        $apiRequestUrl = $this->apiUrl . $endpointUrl;

        $response = $this->getCurl($apiRequestUrl, $payload, array(
            'Content-Type' => "application/json",
            'X-TIMESTAMP' => $formattedTimestamp,
            'X-SIGNATURE' => $signature,
            'X-PARTNER-ID' =>  getSettingKeuangan('keuangan_winpay_merchant_partner_id'),
            'X-EXTERNAL-ID' => date('YmdHi'),
            'CHANNEL-ID' => getSettingKeuangan('keuangan_winpay_merchant_channel_id'),
        ), 'json', "POST");

        DB::table('winpay_log')->insert([
            'log_type' => 'RECEIVE',
            'log_data' => json_encode($response),
            'log_chain' => $this->lastLogId,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        if($payment['code_snap'] == 'QRIS') return $this->setResponseQRIS($response);

        return $this->setResponseVA($response);
    }

    private function setResponseQRIS($response)
    {
        // {
        //     "responseCode": "2004700",
        //     "responseMessage": "Success",
        //     "partnerReferenceNo": "ref00000000001",
        //     "qrContent": null,
        //     "qrUrl": "https://sandbox-payment.winpay.id/scqr/get_image_qr?payid=1309cd8ceef30410ed1664c8c8c0bb76",
        //     "terminalId": "TERM GIGIH",
        //     "additionalInfo": {
        //       "contractId": "qr2300a3fe-68b8-414b-bf00-8f44ce1cf5d3",
        //       "expiredAt": "2023-09-06T23:08:56+07:00",
        //       "isStatic": false
        //     }
        //   }

        return [
            'code' => $response['responseCode'],
            'success' => $response['responseCode'] == '2004700',
            'message' => $response['responseMessage'],
            'data' => [
                'channel' => 'QRIS',
                'qr_image' =>  $response['qrUrl'] ?? '',
                'ref' => $response['partnerReferenceNo'] ?? '',
                'amount' => '',
                'guidance' => '',
                'payment_code' =>  '',
            ]
        ];
    }

    private function setResponseVA($response)
    {
        // {
        //     "responseCode": "2002700",
        //     "responseMessage": "Success",
        //     "virtualAccountData": {
        //       "partnerServiceId": "   22691",
        //       "customerNo": "41693898987",
        //       "virtualAccountNo": "   2269141693898987",
        //       "virtualAccountName": "Chus Pandi",
        //       "trxId": "INV-000000023212x2221",
        //       "totalAmount": {
        //         "value": "25000.00",
        //         "currency": "IDR"
        //       },
        //       "virtualAccountTrxType": "c",
        //       "expiredDate": "2023-09-05T19:30:14+07:00",
        //       "additionalInfo": {
        //         "channel": "CIMB",
        //         "contractId": "cia80bff69-1073-4811-b1e1-13b738784d8b"
        //       }
        //     }
        //   }

        return [
            'code' => $response['responseCode'],
            'success' => $response['responseCode'] == '2002700',
            'message' => $response['responseMessage'],
            'data' => [
                'channel' => $response['virtualAccountData']['additionalInfo']['channel'] ?? '',
                'qr_image' =>  '',
                'ref' => $response['virtualAccountData']['trxId'] ?? '',
                'amount' => intval($response['virtualAccountData']['totalAmount']['value'] ?? ''),
                'guidance' => '',
                'payment_code' => $response['virtualAccountData']['virtualAccountNo'] ?? '',
            ]
        ];
    }

    private function generateSignature($endpointUrl, $body, $timestamp, $httpMethod = "POST"){
        $hashedBody = strtolower(bin2hex(hash('sha256', json_encode($body, JSON_UNESCAPED_SLASHES), true)));

        $stringToSign = [
            $httpMethod,
            $endpointUrl,
            $hashedBody,
            $timestamp
        ];

        $signature = '';
        $stringToSign = implode(':', $stringToSign);

        $privKey = openssl_get_privatekey(getSettingKeuangan('keuangan_winpay_private_snap'));
        openssl_sign($stringToSign, $signature, $privKey, OPENSSL_ALGO_SHA256);
        $encodedSignature = base64_encode($signature);
        return $encodedSignature;
    }
}

