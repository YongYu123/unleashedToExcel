<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UnleashedController extends Controller
{
    protected $api = "https://api.unleashedsoftware.com/";
    protected $apiId = "2023d213-16a5-4fee-ba65-285a40332187";
    protected $apiKey = "Tqx9on0AdoYN1nOieEI722Zl1IKsUJGhe3qLwBH1qQi76KVtfI4VeGFwRSc0MecvOJpFspkBi7jfXfSInXAQ==";

    public function index()
    {
        $data = $this->getJson($this->apiId, $this->apiKey, "Customers", "");
        $customers = $data->Items;
        return view('unleashed', compact('customers'));
    }

    public function excel()
    {
    }

    public function getSignature($request, $key)
    {
        return base64_encode(hash_hmac('sha256', $request, $key, true));
    }

    // Create the curl object and set the required options
    // - $api will always be https://api.unleashedsoftware.com/
    // - $endpoint must be correctly specified
    // - $requestUrl does include the "?" if any
    // Using the wrong values for $endpoint or $requestUrl will result in a failed API call
    public function getCurl($id, $key, $signature, $endpoint, $requestUrl, $format)
    {
        $curl = curl_init($this->api . $endpoint . $requestUrl);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/$format",
          "Accept: application/$format", "api-auth-id: $id", "api-auth-signature: $signature"));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 20);
        // these options allow us to read the error message sent by the API
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_HTTP200ALIASES, range(400, 599));

        return $curl;
    }

    public function get($id, $key, $endpoint, $request, $format)
    {
        $requestUrl = "";
        if (!empty($request)) {
            $requestUrl = "?$request";
        }

        try {
            // calculate API signature
            $signature = $this->getSignature($request, $key);
            // create the curl object
            $curl = $this->getCurl($id, $key, $signature, $endpoint, $requestUrl, $format);
            // GET something
            $curl_result = curl_exec($curl);
            error_log($curl_result);
            curl_close($curl);
            return $curl_result;
        } catch (Exception $e) {
            error_log('Error: ' + $e);
        }
    }
    public function getJson($id, $key, $endpoint, $request)
    {
        // GET it, decode it, return it
        return json_decode($this->get($id, $key, $endpoint, $request, "json"));
    }
}
