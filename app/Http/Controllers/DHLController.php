<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class DHLController extends \SoapHeader
{
    private $wss_ns         = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';
    private $username       = 'itmallouRO';
    private $password       = 'I$7tB!3oH!6o';
    private $accountNumber  = '410488281';
    private $shipTimestamp  = '';
    private $shipper        = '';

    public function __construct($user = null, $pass = null, $ns = null)
    {
       if ($ns) {
           $this->wss_ns = $ns;
       }

       $this->shipTimestamp  = date("Y-m-d\TH:i:s.000\Z");
       $this->shipper        = array("StreetName" => "STR. Zizinului", "StreetNumber" => "109B", "City" => "Brasov", "PostalCode" => "500407", "CountryCode" => "RO");

       $auth = new \stdClass();
       $auth->Username = new \SoapVar($user, XSD_STRING, NULL, $this->wss_ns, NULL, $this->wss_ns);
       $auth->Password = new \SoapVar($pass, XSD_STRING, NULL, $this->wss_ns, NULL, $this->wss_ns);

       $username_token = new \stdClass();
       $username_token->UsernameToken = new \SoapVar($auth, SOAP_ENC_OBJECT, NULL, $this->wss_ns, 'UsernameToken', $this->wss_ns);

       $security_sv = new \SoapVar(
           new \SoapVar($username_token, SOAP_ENC_OBJECT, NULL, $this->wss_ns, 'UsernameToken', $this->wss_ns),
           SOAP_ENC_OBJECT, NULL, $this->wss_ns, 'Security', $this->wss_ns);
       parent::__construct($this->wss_ns, 'Security', $security_sv, true);
    }

    public function rateRequest()
    {
        try {
            $wsse_header = new DHLController($this->username, $this->password);

            $soap = new \SoapClient('https://wsbexpress.dhl.com/sndpt/expressRateBook?WSDL', array('trace' => 1));
            // extend SOAP Header with mandatory WSSE header
            $soap->__setSoapHeaders(array($wsse_header));

            // dd($soap->__getTypes());

            // Populate Shipper section
            $Shipper = array("StreetName" => "STR. Zizinului", "StreetNumber" => "109B", "City" => "Brasov", "PostalCode" => "500407", "CountryCode" => "RO");

            // populate Receiver section
            // $Recipient = array("StreetName" => "Rembrandtplein", "StreetNumber" => "44", "City" => "Amsterdam", "PostalCode" => "1017", "CountryCode" => "NL");
            $Recipient = array("StreetName" => "De Mayo", "StreetNumber" => "44", "City" => "Abelardo L. Rodriguez", "PostalCode" => "21908", "CountryCode" => "MX");

            // populate Ship section
            $Ship = array("Shipper" => $this->shipper, "Recipient" => $Recipient);

            // populate RequestedPackages
            $Dimensions = array("Length" => 9, "Width" => 9, "Height" => 9);
            $Weight = array("Value" => 1);
            $RequestedPackages = array("_" => "", "number"=>"1", "Weight" => $Weight, "Dimensions" => $Dimensions, "CustomerReferences" => "CustomerReference");

            // populate Packages
            $Packages = array("RequestedPackages" => $RequestedPackages);

            // now assemble the request together
            $RequestedShipment = array("DropOffType" => "REGULAR_PICKUP", "Ship" => $Ship, "Packages" => $Packages,
                            "ShipTimestamp" => $this->shipTimestamp, "UnitOfMeasurement" => "SI", "Content" => "NON_DOCUMENTS", "PaymentInfo" => "DDP",
                            "Account" => $this->accountNumber, "DeclaredValue" => "1000", "DeclaredValueCurrencyCode" => "EUR");

            $ShipmentRequest = array("RequestedShipment" => $RequestedShipment);

            // send request and receive response
            $resp = $soap->__soapCall("getRateRequest", array("RateRequest" => $ShipmentRequest));

            // dd($resp->Provider->Notification->code);
            $notification = $resp->Provider->Notification;

            if (!is_array($notification)) {
                if ($notification->code == 0) {
                    // dd('Super');
                }
            }

            // dd('erorr');

            dd($resp->Provider);
            dd($soap->__getLastResponse());

        } catch (Exception $e) {
                echo "<h2>Exception Error!</h2>";
                echo $e->getMessage();
        }
    }

    public function createShipment()
    {
        try {
            $wsse_header = new DHLController($this->username, $this->password);
            $soap = new \SoapClient('https://wsbexpress.dhl.com/sndpt/expressRateBook?WSDL', array('trace' => 1));
            // extend SOAP Header with mandatory WSSE header
            $soap->__setSoapHeaders(array($wsse_header));

            // populate data we need to create shipment
            $serviceType="U";

            // populate ShipmentInfo section
            $Billing=array("ShipperAccountNumber" => $this->accountNumber, "ShippingPaymentType" => "S");
            $ShipmentInfo=array("DropOffType" => "REGULAR_PICKUP", "ServiceType" => $serviceType, "Billing" => $Billing, "Currency" => "EUR",
                              "UnitOfMeasurement" => "SI", "LabelType" => "PDF");

            // populate InternationalDetail
            $Commodities=array("Description" => "Shipment description");
            $InternationalDetail=array("Commodities" => $Commodities, "Content" => "DOCUMENTS");

            // Populate Shipper section
            $shipContact=array("PersonName" => "PersonName", "CompanyName" => "CompanyName", "PhoneNumber" => "+420731111111");
            $shipAddress=array("StreetLines" => "StreetLines", "City" => "Prague", "PostalCode" => "14800", "CountryCode" => "CZ");
            $Shipper=array("Contact" => $shipContact, "Address" => $shipAddress);

            // populate Receiver section
            $rcptContact=array("PersonName" => "PersonName", "CompanyName" => "CompanyName", "PhoneNumber" => "+420731111111");
            $rcptAddress=array("StreetLines" => "StreetLines", "City" => "Huckeswagen", "PostalCode" => "42499", "CountryCode" => "DE");
            $Recipient=array("Contact" => $rcptContact, "Address" => $rcptAddress);

            // populate Ship section
            $Ship=array("Shipper" => $Shipper, "Recipient" => $Recipient);

            // populate RequestedPackages #1
            $Dimensions = array("Length" => 9, "Width" => 9, "Height" => 9);

            //$RequestedPackages1=array("_" => "", "number"=>"1", "Weight" => "0.614", "Dimensions" => $Dimensions, "CustomerReferences" => "CustomerReference");
            $RequestedPackages1 = array("_" => "", "number"=>"1", "Weight" => "1", "Dimensions" => $Dimensions, "CustomerReferences" => "CustomerReference");
            // $RequestedPackages2=array("_" => "", "number"=>"2", "Weight" => "1.614", "Dimensions" => $Dimensions, "CustomerReferences" => "CustomerReference2");

            // populate array
            $RequestedPackagesArray = array($RequestedPackages1);
            // dd($RequestedPackagesArray);

            // populate Packages

            // now assemble the request together
            $RequestedShipment=array("ShipmentInfo" => $ShipmentInfo, "ShipTimestamp" => $this->shipTimestamp, "PaymentInfo" => "CIP",
                            "InternationalDetail" => $InternationalDetail, "Ship" => $Ship, "Packages" => array(
                              "RequestedPackages" => $RequestedPackagesArray));



            $RequestedShipment = json_encode('{"ShipmentRequest":{"RequestedShipment":{"ShipmentInfo":{"DropOffType":"REGULAR_PICKUP","ServiceType":"U","Account":"410488281","Currency":"EUR","UnitOfMeasurement":"SI","PackagesCount":"1","LabelType":"PDF","LabelTemplate":"ECOM_TC_A4"},"ShipTimestamp":"2020-01-16T12:30:47GMT+01:00","PaymentInfo":"CIP","InternationalDetail":{"Commodities":{"NumberOfPieces":1,"Description":"Shipment description","Quantity":1,"CountryOfManufacture":"RO"},"Content":"DOCUMENTS"},"Ship":{"Shipper":{"Contact":{"PersonName":"PersonName","CompanyName":"CompanyName","PhoneNumber":"+420731111111"},"Address":{"StreetLines":"StreetLines","City":"Bucharest","PostalCode":"010708","CountryCode":"RO"}},"Recipient":{"Contact":{"PersonName":"PersonName","CompanyName":"CompanyName","PhoneNumber":"+420731111111"},"Address":{"StreetLines":"StreetLines","City":"Huckeswagen","PostalCode":"42499","CountryCode":"DE"}}},"Packages":{"RequestedPackages":{"@number":"1","Weight":1,"Dimensions":{"Length":9,"Width":9,"Height":9},"CustomerReferences":"CustomerReference"}}}}}');
            $ShipmentRequest=array("RequestedShipment" => $RequestedShipment);

            // echo '<pre>';
            // print_r(json_encode($ShipmentRequest));
            //
            // dd('bf');
            var_dump($ShipmentRequest);
            // send request and receive response
            $resp=$soap->__soapCall("createShipmentRequest", array("ShipmentRequest" => $ShipmentRequest));


          // dump the response
          //var_dump($resp);

          // print the AWB number
          echo("AWB Number of created shipment: ".htmlspecialchars($resp->ShipmentIdentificationNumber)."<hr>");

        ?>
          <pre>
        <?php
          print_r(htmlentities($soap->__getLastResponse()));
        ?>
          </pre>
        <?php

        } catch (Exception $e) {
                echo "Request : <br/><xmp>",  htmlentities(str_ireplace('><', ">\n<", $soap->__getLastRequest())) . "\n</xmp>";
                echo "<h2>Exception Error!</h2>";
                echo $e->getMessage();
        }
    }

    public function getPOD()
    {
        try {
          $wsse_header = new DHLController($this->username, $this->password);

          $soap = new \SoapClient('https://wsbexpress.dhl.com/sndpt/getePOD?WSDL', array('trace' => 1));
          // extend SOAP Header with mandatory WSSE header
          $soap->__setSoapHeaders(array($wsse_header));

          // populate data
          $xml = new \XMLWriter();
          $xml->openMemory();
          $xml->startElement('shipmentDocumentRetrieveReq');
            $xml->startElement('MSG');
              $xml->startElement('Hdr');
                $xml->writeAttribute('Dtm', '2018-08-06T08:08:41.914+02:00');
                $xml->writeAttribute('Id', '1533535721914');
                $xml->writeAttribute('Ver', '1.038');

                $xml->startElement('Sndr');
                  $xml->writeAttribute('AppCd', 'GloWS');
                  $xml->writeAttribute('AppNm', 'GloWS');
                $xml->endElement();
            $xml->endElement(); // end of HDR
            $xml->startElement('Bd');
              $xml->startElement('Shp');
                $xml->writeAttribute('Id', '1234567890');
                $xml->startElement('ShpTr');
                  $xml->startElement('SCDtl');
                  $xml->writeAttribute('AccNo', '000000000');
                  $xml->writeAttribute('CRlTyCd', 'TC');
                $xml->endElement(); // end of SCDtl
                $xml->endElement(); // end of ShpTr
                $xml->startElement('ShpInDoc');
                  $xml->startElement('SDoc');
                  $xml->writeAttribute('DocTyCd', 'POD');
                  $xml->endElement(); // end of SDoc
                $xml->endElement(); // end of ShpInDoc
              $xml->endElement(); // end of Shp
              $xml->startElement('GenrcRq');
                $xml->startElement('GenrcRqCritr');
                  $xml->writeAttribute('TyCd', 'IMG_CONTENT');
                  $xml->writeAttribute('Val', 'epod-detail');
                $xml->endElement();
                $xml->startElement('GenrcRqCritr');
                  $xml->writeAttribute('TyCd', 'IMG_FORMAT');
                  $xml->writeAttribute('Val', 'PDF');
                $xml->endElement();
                $xml->startElement('GenrcRqCritr');
                  $xml->writeAttribute('TyCd', 'DOC_RND_REQ');
                  $xml->writeAttribute('Val', 'true');
                $xml->endElement();
                $xml->startElement('GenrcRqCritr');
                  $xml->writeAttribute('TyCd', 'EXT_REQ');
                  $xml->writeAttribute('Val', 'true');
                $xml->endElement();
                $xml->startElement('GenrcRqCritr');
                  $xml->writeAttribute('TyCd', 'DUPL_HANDL');
                  $xml->writeAttribute('Val', 'CORE_WB_NO');
                $xml->endElement();
                $xml->startElement('GenrcRqCritr');
                  $xml->writeAttribute('TyCd', 'SORT_BY');
                  $xml->writeAttribute('Val', '$INGEST_DATE,D');
                $xml->endElement();
              $xml->endElement(); // end of GenrcRq
            $xml->endElement(); // end of Bd
          $xml->endElement(); // end of MSG
          $xml->endElement(); // end of request

          // send request and receive response

          $args = new \SoapVar($xml->outputMemory(), XSD_ANYXML);
          $resp=$soap->__soapCall("ShipmentDocumentRetrieve", array($args));

          // print the notificaitons
          try {
            foreach ($resp->MSG->DatTrErr as $DatTrErr) {
              $ErrMsgDtl=$DatTrErr->DatErrMsg->ErrMsgDtl;
              echo "ResponseMessage: ".$ErrMsgDtl->DtlDsc."<br>";
            }
        } catch (\Exception $ee) {
            echo "<h2>Exception Error!</h2>";
                echo $e->getMessage();
          }
          // print the response
        ?>
          <hr>
          Raw response (XML) message<br>
          <pre>
        <?php
          print_r(htmlentities($soap->__getLastResponse()));
          print_r($xml->outputMemory(TRUE));
        ?>
          </pre>
        <?php

        } catch (Exception $e) {
                echo "<h2>Exception Error!</h2>";
                echo $e->getMessage();
        }
    }

    public function requestPickup()
    {
        // code...
    }


    public function trackResponse()
    {
        // code...
    }
}
