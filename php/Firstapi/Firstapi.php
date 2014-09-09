<?php

abstract class Firstapi
{
  /**
   * @var string The Firstapi API params to be used for requests.
   */
  public static $apiKey;
  public static $apiSecret;
  public static $gatewayID;
  public static $gatewayPassword;
  /**
   * @var string The base URL for the Firstapi API In test.
   */
  public static $apiBase = 'https://demo26-test.apigee.net/firstapi-cat/transactions';
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
    self::$apiKey = $apiSecret;
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
   * Sets the Gateway ID for E4.
   *
   * @param string $gatewayID
   */
  public static function setGatewayID($gatewayID)
  {
    self::$apiKey = $gatewayID;
  }
  /**
   * Gets the Gateway ID for E4.
   *
   * @param string $gatewayID
   */
  public static function getGatewayID($gatewayID)
  {
    return self::$gatewayID;
  }
  /**
   * Sets the Gateway Password for E4.
   *
   * @param string $gatewayPassword
   */
  public static function setGatewayPassword($gatewayPassword)
  {
    self::$apiKey = $gatewayID;
  }
  /**
   * Gets the Gateway Password for E4.
   *
   * @param string $gatewayID
   */
  public static function getGatewayPassword($gatewayPassword)
  {
    return self::$gatewayID;
  }
}
