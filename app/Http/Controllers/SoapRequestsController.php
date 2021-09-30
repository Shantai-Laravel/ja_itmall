<?php

namespace App\Http\Controllers;

use Artisaninweb\SoapWrapper\SoapWrapper;
use App\Soap\Request\GetConversionAmount;
use App\Soap\Response\GetConversionAmountResponse;

class SoapRequestsController
{
  /**
   * @var SoapWrapper
   */
  protected $soapWrapper;

  /**
   * SoapController constructor.
   *
   * @param SoapWrapper $soapWrapper
   */
  public function __construct(SoapWrapper $soapWrapper)
  {
    $this->soapWrapper = $soapWrapper;
  }

  /**
   * Use the SoapWrapper
   */
  public function show()
  {
//       try{
//     $client = new \SoapClient('http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl', ['trace' => true]);
//     $result = $client->checkVat([
//         'countryCode' => 'DK',
//         'vatNumber' => '47458714'
//     ]);
//     dd($result);
// }
// catch(Exception $e){
//     echo $e->getMessage();
// }
//
// dd();


    $this->soapWrapper->add('Currency', function ($service) {
      $service
        ->wsdl('https://currencyconverter.kowabunga.net/converter.asmx?WSDL')
        ->trace(true)
        ->classmap([
          GetConversionAmount::class,
          GetConversionAmountResponse::class,
        ]);
    });

    // Without classmap
    $response = $this->soapWrapper->call('Currency.GetConversionAmount', [
      'CurrencyFrom' => 'USD',
      'CurrencyTo'   => 'EUR',
      'RateDate'     => '2014-06-05',
      'Amount'       => '1000',
    ]);

    var_dump($response);

    // With classmap
    $response = $this->soapWrapper->call('Currency.GetConversionAmount', [
      new GetConversionAmount('USD', 'EUR', '2014-06-05', '1000')
    ]);

    var_dump($response);
    exit;
  }
}
