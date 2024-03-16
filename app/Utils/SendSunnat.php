<?php

namespace App\Utils;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\SaleDetail;
use Greenter\See;
use Greenter\Ws\Services\SunatEndpoints;

class SendSunnat
{

  public static function getConnection()
  {

    $see = new See();
    $see->setCertificate(file_get_contents(storage_path('app/certificate.pem')));
    $see->setService(SunatEndpoints::FE_BETA);

    $see->setClaveSOL('20000000001', 'MODDATOS', 'moddatos');
    // $see->setCachePath(storage_path('app/cache/'));
    // $see->setDebug(true);
    return $see;
  }

  public static function sendSale($data)
  {
    $see = self::getConnection();

    //Cliente
    $client = (new Client())
      ->setTipoDoc('6')
      ->setNumDoc('20000000001')
      ->setRznSocial('EMPRESA DE PRUEBA');

    //Emisor
    $address = (new Address())
      ->setUbigueo('150101')
      ->setDepartamento('LIMA')
      ->setProvincia('LIMA')
      ->setDistrito('LIMA')
      ->setUrbanizacion('-')
      ->setDireccion('Av. Villa Nueva 221')
      ->setCodLocal('0000');

    $company = (new Company())
      ->setRuc('20000000001')
      ->setRazonSocial('GREEN SAC')
      ->setNombreComercial('GREEN SAC')
      ->setAddress($address);

    //Venta
    $invoice = (new Invoice())
      ->setUblVersion("2.1")
      ->setTipoOperacion("0101")
      ->setTipoDoc('01')
      ->setSerie('F001')
      ->setCorrelativo('1')
      ->setFechaEmision(new \DateTime())
      ->setFormaPago(new FormaPagoContado())
      ->setTipoMoneda('PEN')
      ->setCompany($company)
      ->setClient($client)
      ->setMtoOperGravadas(100.00)
      ->setMtoIGV(18.00)
      ->setSubTotal(118.00)
      ->setTotalImpuestos(18.00)
      ->setValorVenta(100.00)
      ->setSubTotal(118.00)
      ->setMtoImpVenta(118.00);

    $item = (new SaleDetail())
      ->setCodProducto('P001')
      ->setUnidad('NIU')
      ->setCantidad(2)
      ->setMtoValorUnitario(50.00)
      ->setDescripcion('PRODUCTO 1')
      ->setMtoBaseIgv(100.00)
      ->setPorcentajeIgv(18.00)
      ->setIgv(18.00)
      ->setTipAfeIgv('10')
      ->setTotalImpuestos(18.00)
      ->setMtoValorVenta(100.00)
      ->setMtoPrecioUnitario(59.00);

    $legend = (new Legend())
      ->setCode('1000')
      ->setValue('SON DOCIENTOS TREINTA Y SEIS CON 00/100 SOLES');


    $invoice->setDetails([$item])
      ->setLegends([$legend]);

    $result = $see->send($invoice);

    //Guardamos XML firmado digitalmente

    file_put_contents(storage_path('app/xml/' . $invoice->getName() . '.xml'), $see->getFactory()->getLastXml());

    if (!$result->isSuccess()) {
      throw new \Exception("Error al enviar a SUNAT");
    }
  }
}
