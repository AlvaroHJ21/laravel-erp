<?php

namespace App\Utils;

use App\Models\Empresa;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Response\BillResult;
use Greenter\Model\Sale\Cuota;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\FormaPagos\FormaPagoCredito;
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

  public static function sendSale($venta)
  {

    $see = self::getConnection();

    //Cliente
    $cliente = $venta->entidad;
    $clienteTipoDocumento = $cliente->documento_identidad->codigo;
    $clienteDocumento = $cliente->numero_documento;
    $clienteRazonSocial = $cliente->nombre;

    //Cliente
    $client = (new Client())
      ->setTipoDoc($clienteTipoDocumento)
      ->setNumDoc($clienteDocumento)
      ->setRznSocial($clienteRazonSocial);

    //Empresa Emisor
    $empresa = Empresa::first();
    $ubigueo = "150101";
    $departamento = "LIMA";
    $provincia = "LIMA";
    $distrito = "LIMA";
    $urbanizacion = $empresa->urbanizacion;
    $direccion = $empresa->domicilio_fiscal;
    $codigoLocal = "0000";

    //Emisor
    $address = (new Address())
      ->setUbigueo($ubigueo)
      ->setDepartamento($departamento)
      ->setProvincia($provincia)
      ->setDistrito($distrito)
      ->setUrbanizacion($urbanizacion)
      ->setDireccion($direccion)
      ->setCodLocal($codigoLocal);


    $ruc = $empresa->ruc;
    $razonSocial = $empresa->razon_social;
    $nombreComercial = $empresa->nombre_comercial;

    $company = (new Company())
      ->setRuc($ruc)
      ->setRazonSocial($razonSocial)
      ->setNombreComercial($nombreComercial)
      ->setAddress($address);


    //Venta
    $tipoOperacion = "0101";
    $tipoDocumento = $venta->tipo_documento->codigo;
    $serie = $venta->serie->serie;
    $correlativo = $venta->numero;
    $fechaEmision = new \DateTime($venta->fecha_emision);
    $formaPago = $venta->forma_pago_id == 1 ? new FormaPagoContado() : new FormaPagoCredito(
      $venta->total_pagar,
      $venta->moneda->abrstandar,
    );
    $tipoMoneda = $venta->moneda->abrstandar;


    /**
     * mtoOperGravadas  -> TaxTotal / TaxSubtotal / TaxableAmount	  . 100
     * mtoIGV 		      -> TaxTotal / TaxSubtotal / TaxAmount		    . 18
     * totalImpuestos 	-> TaxTotal / TaxAmount				              . 18
     * valorVenta 	    -> LegalMonetaryTotal / LineExtensionAmount	. 100
     * subtotal 	      -> LegalMonetaryTotal / TaxInclusiveAmount	. 118
     * mtoImpVenta  	  -> LegalMonetaryTotal / PayableAmount		    . 118
     */

    //Calculo de montos
    $mtoOperGravadas = 0;
    $mtoExoneradas = 0;
    $mtoGratuitas = 0;
    foreach ($venta->detalles as $detalle) {
      if ($detalle->tipo_igv->codigo == "10") {
        $mtoOperGravadas += $detalle->valor_venta * $detalle->cantidad;
      } else if ($detalle->tipo_igv->codigo == "20") {
        $mtoExoneradas += $detalle->valor_venta * $detalle->cantidad;
      } else {
        $mtoGratuitas += $detalle->valor_venta * $detalle->cantidad;
      }
    }

    $mtoIGV = $venta->total_igv;

    $totalImpuestos = $venta->total_igv;
    $valorVenta = $mtoOperGravadas + $mtoExoneradas + $mtoGratuitas;
    $subtotal = $venta->total_pagar;
    $mtoImpVenta = $venta->total_pagar;

    //Venta
    $invoice = (new Invoice())
      ->setUblVersion("2.1")
      ->setTipoOperacion($tipoOperacion)
      ->setTipoDoc($tipoDocumento)
      ->setSerie($serie)
      ->setCorrelativo($correlativo)
      ->setFechaEmision($fechaEmision)
      ->setFormaPago($formaPago)
      ->setTipoMoneda($tipoMoneda)
      ->setCompany($company)
      ->setClient($client)
      ->setMtoOperGravadas($mtoOperGravadas)
      ->setMtoIGV($mtoIGV)
      ->setMtoOperExoneradas($mtoExoneradas)
      ->setMtoOperGratuitas($mtoGratuitas)
      ->setMtoIGVGratuitas(0)
      ->setTotalImpuestos($totalImpuestos)
      ->setValorVenta($valorVenta)
      ->setSubTotal($subtotal)
      ->setMtoImpVenta($mtoImpVenta);

    // dd($invoice);

    if ($venta->forma_pago_id == 2) {
      $cuotas = [];
      foreach ($venta->pagos as $cuota) {
        $item = new Cuota();
        $item->setMoneda($venta->moneda->abrstandar);
        $item->setMonto($cuota->monto);
        $item->setFechaPago(new \DateTime($cuota->fecha));
        $cuotas[] = $item;
      }
      $invoice->setCuotas($cuotas);
      $invoice->setFecVencimiento(new \DateTime($venta->fecha_vencimiento));
    }

    // dd($invoice);

    //Detalles
    $items = [];
    foreach ($venta->detalles as $detalle) {
      $item = new SaleDetail();

      $totalIgv = $detalle->subtotal - $detalle->valor_venta * $detalle->cantidad;

      $item->setCodProducto($detalle->codigo);
      $item->setUnidad($detalle->producto->unidad->codigo);
      $item->setCantidad($detalle->cantidad);
      $item->setMtoValorUnitario($detalle->valor_venta);
      $item->setDescripcion($detalle->producto->nombre . " " . $detalle->producto->codigo . " " . $detalle->descripcion_adicional);
      $item->setMtoBaseIgv($detalle->valor_venta * $detalle->cantidad);
      $item->setPorcentajeIgv($detalle->tipo_igv->porcentaje);
      $item->setIgv($totalIgv);
      $item->setTipAfeIgv($detalle->tipo_igv->codigo);
      $item->setTotalImpuestos($totalIgv);
      $item->setMtoValorVenta($detalle->valor_venta * $detalle->cantidad);
      $item->setMtoPrecioUnitario($detalle->valor_venta * (1 + $detalle->tipo_igv->porcentaje / 100));
      $items[] = $item;
    }

    $num2letras = new Numletras();
    $totalLetras = $num2letras->getTotalLetras($venta->total_pagar, $venta->moneda->nombre);

    $legend = (new Legend())
      ->setCode('1000')
      ->setValue($totalLetras);

    $invoice->setDetails($items)
      ->setLegends([$legend]);

    $result = $see->send($invoice);

    //Guardamos XML firmado digitalmente
    $xmlStorePath = 'app/xml/' . $invoice->getName() . '.xml';
    $cdrStorePath = 'app/cdr/R-' . $invoice->getName() . '.zip';
    file_put_contents(storage_path($xmlStorePath), $see->getFactory()->getLastXml());

    if (!$result->isSuccess()) {
      // Guardar XML de error
      file_put_contents(storage_path('app/xml/Error-' . $invoice->getName() . '.xml'), $see->getFactory()->getLastXml());
      throw new \Exception($result->getError()->getMessage());
    }

    if ($result instanceof BillResult) {

      $code = (int)$result->getCdrResponse()->getCode();

      //guardar xml de cdr
      file_put_contents(storage_path($cdrStorePath), $result->getCdrZip());

      if ($code === 0) {
        //ACEPTADO
        $firma = self::getFirma($xmlStorePath);
        $venta->update([
          "estado" => 1,
          "nombre_archivo" => $invoice->getName(),
          "firma_sunat" => $firma,
        ]);
      } else if ($code >= 2000 && $code <= 3999) {
        //RECHAZADO
        $venta->update([
          "estado" => 2,
        ]);

        throw new \Exception("Error al enviar a SUNAT");
      } else {
        throw new \Exception("Error al recibir respuesta de SUNAT");
      }
    }

    return $result;
  }

  static function getFirma($storePath)
  {
    $xml    = simplexml_load_file(storage_path($storePath));
    foreach ($xml->xpath('//ds:DigestValue') as $response) {
    }
    return $response;
  }
}
