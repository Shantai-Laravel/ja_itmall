<?php
header('Content-Type: text/html; charset=utf-8');
$username="username";
$password="password";

class WsseAuthHeader extends SoapHeader {

  private $wss_ns = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';

  function __construct($user, $pass, $ns = null) {
    if ($ns) {
        $this->wss_ns = $ns;
    }

    $auth = new stdClass();
    $auth->Username = new SoapVar($user, XSD_STRING, NULL, $this->wss_ns, NULL, $this->wss_ns);
    $auth->Password = new SoapVar($pass, XSD_STRING, NULL, $this->wss_ns, NULL, $this->wss_ns);

    $username_token = new stdClass();
    $username_token->UsernameToken = new SoapVar($auth, SOAP_ENC_OBJECT, NULL, $this->wss_ns, 'UsernameToken', $this->wss_ns);

    $security_sv = new SoapVar(
        new SoapVar($username_token, SOAP_ENC_OBJECT, NULL, $this->wss_ns, 'UsernameToken', $this->wss_ns),
        SOAP_ENC_OBJECT, NULL, $this->wss_ns, 'Security', $this->wss_ns);
    parent::__construct($this->wss_ns, 'Security', $security_sv, true);
  }
}

try {

  $wsse_header = new WsseAuthHeader($username, $password);
  $soap = new SoapClient('https://wsbexpress.dhl.com/sndpt/expressRateBook?WSDL', array('trace' => 1));
  // extend SOAP Header with mandatory WSSE header
  $soap->__setSoapHeaders(array($wsse_header));

  //print_r($soap->__getTypes());

  // populate data we need to create shipment
  $accountNumber="123456789";
  $ShipTimestamp="2018-10-24T10:30:00GMT+02:00";

  // Populate Shipper section
  $Shipper=array("StreetName" => "STR. DEZROBIRII", "StreetNumber" => "44", "City" => "BAIA MARE", "PostalCode" => "430012", "CountryCode" => "RO");

  // populate Receiver section
  $Recipient=array("StreetName" => "Bulevardul Bucuresti", "StreetNumber" => "35", "City" => "BAIA MARE", "PostalCode" => "430012", "CountryCode" => "RO");

  // populate Ship section
  $Ship=array("Shipper" => $Shipper, "Recipient" => $Recipient);

  // populate RequestedPackages
  $Dimensions=array("Length" => 9, "Width" => 9, "Height" => 9);
  $Weight=array("Value" => 1);
  $RequestedPackages=array("_" => "", "number"=>"1", "Weight" => $Weight, "Dimensions" => $Dimensions, "CustomerReferences" => "CustomerReference");

  // populate Packages
  $Packages=array("RequestedPackages" => $RequestedPackages);

  // now assemble the request together
  $RequestedShipment=array("DropOffType" => "REGULAR_PICKUP", "Ship" => $Ship, "Packages" => $Packages,
                    "ShipTimestamp" => $ShipTimestamp, "UnitOfMeasurement" => "SI", "Content" => "NON_DOCUMENTS", "PaymentInfo" => "DDP",
                    "Account" => $accountNumber, "DeclaredValue" => "1000", "DeclaredValueCurrencyCode" => "EUR");

  $ShipmentRequest=array("RequestedShipment" => $RequestedShipment);

  // send request and receive response
  $resp=$soap->__soapCall("getRateRequest", array("RateRequest" => $ShipmentRequest));


  // print the response
?>
  <pre>
<?php
  print_r(htmlentities($soap->__getLastResponse()));
?>
  </pre>
<?php

} catch (Exception $e) {
        echo "<h2>Exception Error!</h2>";
        echo $e->getMessage();
}


?>
