<?php

class Payeezy
{
  /**
   * @var string The Payeezy API params to be used for requests.
   */
  public static $apiKey;
  public static $apiSecret;
  public static $merchantToken;
  public static $baseURL;
  public static $url;

  /**
   * Sets the API key to be used for requests.
   *
   * @param string $apiKey
   */
  public static function setApiKey($apiKey)
  {
    self::$apiKey = $apiKey;
  }
  /**
   * Sets the API key to be used for requests.
   *
   * @param string $apiKey
   */
  public static function getApiKey()
  {
    return self::$apiKey;
  }
    /**
   * Sets the API secret to be used for requests.
   *
   * @param string $apiSecret
   */
  public static function setApiSecret($apiSecret)
  {
    self::$apiSecret = $apiSecret;
  }
  /**
   * Sets the API secret to be used for requests.
   *
   * @param string $apiSecret
   */
  public static function getApiSecret()
  {
    return self::$apiSecret;
  }
  /**
   * Sets the API Base URL.
   *
   * @param string $url
   */
  public static function setUrl($baseURL)
  {
    self::$baseURL = $baseURL;
  }
  /**
   * Gets the API Base URL.
   *
   * @param string $url
   */
  public static function getUrl()
  {
    return self::$baseURL;
  }
  /**
   * Sets the API Merchant Token
   *
   * @param string $merchantToken
   */
  public static function setMerchantToken($merchantToken)
  {
    self::$merchantToken = $merchantToken;
  }
  /**
   * Gets the API Merchant Token
   *
   * @param string $merchantToken
   */
  public static function getMerchantToken()
  {
    return self::$merchantToken;
  }

  /**
   * Payeezy
   * 
   * Generate Payload
   */

  public function getPayload($args = array())
  {
    $args = array_merge(array(
        "amount"=> "",
        "card_number" => "", 
        "card_type" => "", 
        "card_holder_name" => "", 
        "card_cvv" => "", 
        "card_expiry" => "",
        "merchant_ref" => "",
        "currency_code" => "",
        "transaction_tag" => "",
        "split_shipment" => "",
        "transaction_id" => "",

    ), $args); 

    $transaction_type = strtolower(func_get_arg(1));



    $data = "";
    if($transaction_type == "authorize" || $transaction_type == "purchase")
    {
      $data = array(
              'merchant_ref'=> $args['merchant_ref'],
              'transaction_type'=> $transaction_type,
              'method'=> 'credit_card',
              'amount'=> $args['amount'],
              'currency_code'=> strtoupper($args['currency_code']),
              'credit_card'=> array(
                      'type'=> $args['card_type'],
                      'cardholder_name'=> $args['card_holder_name'],
                      'card_number'=> $args['card_number'],
                      'exp_date'=> $args['card_expiry'],
                      'cvv'=> $args['card_cvv'],
                    )
      );

      self::$url = self::$baseURL;
    }else{


      self::$url = self::$baseURL . '/' . $args['transaction_id'];


      if($transaction_type == "split")
      {
        $data = array(
          'merchant_ref'=> $args['merchant_ref'],
          'transaction_type'=> $transaction_type,
          'method'=> 'credit_card',
          'amount'=> $args['amount'],
          'currency_code'=> strtoupper($args['currency_code']),
          'transaction_tag'=>$args['transaction_tag'],
          'split_shipment'=>$args['split_shipment'],
        );

      }else{
        $data = array(
                'merchant_ref'=> $args['merchant_ref'],
                'transaction_type'=> $transaction_type,
                'method'=> 'credit_card',
                'amount'=> $args['amount'],
                'currency_code'=> strtoupper($args['currency_code']),
                'transaction_tag'=>$args['transaction_tag'],
        );

      }
    }
    return json_encode($data, JSON_FORCE_OBJECT);
  }

  /**
   * Payeezy
   * 
   * HMAC Authentication
   */

  public function hmacAuthorizationToken($payload)
  {

    $nonce = strval(hexdec(bin2hex(openssl_random_pseudo_bytes(4, $cstrong))));

    $timestamp = strval(time()*1000); //time stamp in milli seconds

    $data = self::$apiKey . $nonce . $timestamp . self::$merchantToken . $payload;

    $hashAlgorithm = "sha256";
 
    $hmac = hash_hmac ( $hashAlgorithm , $data , self::$apiSecret, false );    // HMAC Hash in hex

    $authorization = base64_encode($hmac);
	

    return array(
            'authorization' => $authorization,
            'nonce' => $nonce,
            'timestamp' => $timestamp,
      ); 
  }

  /**
   * jsonpp - Pretty print JSON data
   *
   * In versions of PHP < 5.4.x, the json_encode() function does not yet provide a
   * pretty-print option. In lieu of forgoing the feature, an additional call can
   * be made to this function, passing in JSON text, and (optionally) a string to
   * be used for indentation.
   *
   * @param string $json  The JSON data, pre-encoded
   * @param string $istr  The indentation string
   *
   * @return string
   */
  public function jsonpp($json, $istr='  ')
  {
      $result = '';
      for($p=$q=$i=0; isset($json[$p]); $p++)
      {
          $json[$p] == '"' && ($p>0?$json[$p-1]:'') != '\\' && $q=!$q;
          if(strchr('}]', $json[$p]) && !$q && $i--)
          {
              strchr('{[', $json[$p-1]) || $result .= "\n".str_repeat($istr, $i);
          }
          $result .= $json[$p];
          if(strchr(',{[', $json[$p]) && !$q)
          {
              $i += strchr('{[', $json[$p])===FALSE?0:1;
              strchr('}]', $json[$p+1]) || $result .= "\n".str_repeat($istr, $i);
          }
      }
      return $result;
  }

  /**
   * Payeezy
   * 
   * Post Transaction
   */

  public  function postTransaction($payload, $headers) 
  {

    $request = curl_init();
    curl_setopt($request, CURLOPT_URL, self::$url );
    curl_setopt($request, CURLOPT_POST, true);
    curl_setopt($request, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($request, CURLOPT_HEADER, false);
	//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($request, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json', 
      'apikey:'.strval(self::$apiKey), 
      'token:'.strval(self::$merchantToken), 
      'Authorization:'.$headers['authorization'],
      'nonce:'.$headers['nonce'],
      'timestamp:'.$headers['timestamp'],
    ));

    $response = curl_exec($request);
	
	if (FALSE === $response)
        echo curl_error($request);
		
    //$httpcode = curl_getinfo($request, CURLINFO_HTTP_CODE);
    curl_close($request);
	
    return $response;
  }

  /**
   * Payeezy


   * 
   * Authorize Transaction
   */

  public function authorize($args = array())
  {
      $payload = $this->getPayload($args, "authorize");

      $headerArray = $this->hmacAuthorizationToken($payload);

      return $this->postTransaction($payload, $headerArray);
  }

  /**
   * Payeezy
   * 
   * Purchase Transaction
   */

  public function purchase($args = array())
  {
      $payload = $this->getPayload($args, "purchase");
      $headerArray = $this->hmacAuthorizationToken($payload);
      return $this->postTransaction($payload, $headerArray);
  }

  /**
   * Payeezy
   * 
   * Capture Transaction
   */

  public function capture($args = array())
  {
      $payload = $this->getPayload($args, "capture");
      $headerArray = $this->hmacAuthorizationToken($payload);
      return $this->postTransaction($payload, $headerArray);
  }

  /**
   * Payeezy
   * 
   * Void Transaction
   */

  public function void($args = array())
  {
      $payload = $this->getPayload($args, "void");
      $headerArray = $this->hmacAuthorizationToken($payload);
      return $this->postTransaction($payload, $headerArray);
  }

  /**
   * Payeezy
   * 
   * Refund Transaction
   */

  public function refund($args = array())
  {
      $payload = $this->getPayload($args, "refund");
      $headerArray = $this->hmacAuthorizationToken($payload);
      return $this->postTransaction($payload, $headerArray);
  }

  /**
   * Payeezy
   * 
   * split Transaction
   */

  public function split_shipment($args = array())
  {
      $payload = $this->getPayload($args, "split");
      $headerArray = $this->hmacAuthorizationToken($payload);
      return $this->postTransaction($payload, $headerArray);
  }

}
