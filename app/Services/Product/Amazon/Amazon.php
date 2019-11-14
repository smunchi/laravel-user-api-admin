<?php

namespace App\Services\Product\Amazon;

use App\Services\Product\ProductResponse;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class Amazon
{
    private $credentials;
    private $isDummy;
    public function __construct($credentials)
    {
        $this->credentials = $credentials;
    }

    public function setIsDummy($isDummy)
    {
        $this->isDummy = $isDummy;
    }

    public function getProducts()
    {
        if($this->isDummy) {
            return $this->getDummyProducts();
        }

        return $this->sendRequest();
    }

    private function sendRequest()
    {
        $queryParam['Service'] = $this->credentials['service'];
        $queryParam['Operation'] = $this->credentials['operation'];
        $queryParam['ResponseGroup'] = $this->credentials['response_group'];
        $queryParam['AssociateTag'] = $this->credentials['associate_tag'];
        $queryParam['AWSAccessKeyId'] = $this->credentials['key_id'];
        $queryParam['Timestamp'] = urlencode($this->credentials['timestamp']);
        $queryString = http_build_query($queryParam);
        $signature = $this->getSignature($queryString);
        $queryParam['Signature'] = $signature;
        $queryParam['SearchIndex'] = $this->credentials['category'];

        $url = "http://webservices.amazon.com/onca/xml?" . http_build_query($queryParam);
       
        $client = new Client();
        $request = $client->get($url);
        $result = $request->getBody();

        return $this->parseResponse($result);
    }

    private function getSignature($queryString)
    {
        $queryArray = explode('&', $queryString);

        natsort($queryArray);

        $signatureString = 'GET
                webservices.amazon.com
                /onca/xml';
        $signatureString .= implode("&", $queryArray);

        return base64_encode(hash_hmac("sha256",$signatureString,$this->credentials['secret_key'],true));
    }

    private function getDummyProducts()
    {
        $xmlContent = view('service.product.amazon.dummy.itemSearchResponse')->render();
        return $this->parseResponse($xmlContent);
    }

    private function parseResponse($xmlContent)
    {
        $xml = new \DOMDocument();
        $xml->loadXML($xmlContent);

        if ((boolean)$xml->getElementsByTagName('ItemSearchResponse')->length) {
            $responseData = collect([]);
            $items = $xml->getElementsByTagName("Items")[0];
            foreach ($items->getElementsByTagName("Item") as $item )    {
                $ItemAttributes = $item->getElementsByTagName("ItemAttributes")[0];
                $image = $item->getElementsByTagName("MediumImage")[0];

                $itemData = new ProductResponse();
                $itemData->setReference($item->getElementsByTagName("ASIN")[0]->nodeValue);
                $itemData->setName($ItemAttributes->getElementsByTagName("Title")[0]->nodeValue);
                $itemData->setCategory($ItemAttributes->getElementsByTagName('ProductGroup')[0]->nodeValue);
                $itemData->setImageUrl($image->getElementsByTagName('URL')[0]->nodeValue);
                $itemData->setProvider($this->credentials['provider']);

                $responseData->push($itemData);
            }

            return $responseData;
        }

        $errorMessage = $xml->getElementsByTagName('ItemSearchErrorResponse')->item('0')->nodeValue;
        Log::error("[".__METHOD__."] $errorMessage");

        return collect([]);
    }
}