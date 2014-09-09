<?php

    class Api_Connect extends Http_Connection {
        
        function __construct($apikey, $apisecret, $gatewayID, $gatewaypass) {
            	parent::__construct ($apikey, $apisecret, $gatewayID, $gatewaypass);
				$credentials->__getattr();
				return $credentials;
        }
    }
?>