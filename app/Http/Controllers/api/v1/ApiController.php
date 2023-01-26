<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public $api_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJVc2VyIjoiUEEuMTU1NzA0ODQ5LTItMjAyMS5QUlVFQkFTMTMiLCJuYmYiOjE2NzQ2Nzg3OTEsImV4cCI6MTY3NzI3MDc5MSwiaWF0IjoxNjc0Njc4NzkxLCJpc3MiOiJodHRwczovL3d3dy5kaWdpZmFjdC5jb20ucGEiLCJhdWQiOiJodHRwczovL3BhY3Rlc3QuZGlnaWZhY3QuY29tLnBhL3BhLmNvbS5hcGludWMifQ.40hIma2QxsUxwcjnztM_dANnVRys6cgHpTFGzQi7HBg";

    public function certificate_fe_xml_tosign(Request $request)
    {

        if($request->method() == "GET"){

            $arr = json_decode('
                {
                    "Version":"1.00",
                    "CountryCode": "PA",
                    "Header":{
                        "DocType": "01",
                        "IssuedDateTime": "2023-01-20T19:42:00-05:00",
                        "AdditionalIssueType": "2",
                        "AdditionalIssueDocInfo":{
                            "TipoEmision":"01",
                            "NumeroDF":"0000000906",
                            "PtoFactDF":"001",
                            "CodigoSeguridad":"000813673",
                            "NaturalezaOperacion":"01",
                            "TipoOperacion":"1",
                            "DestinoOperacion":"1",
                            "FormatoGeneracion":"1",
                            "ManeraEntrega":"1",
                            "EnvioContenedor":"1",
                            "ProcesoGeneracion":"1",
                            "TipoTransaccion":"1",
                            "TipoSucursal":"2"
                        }
                    },
                    "Seller":{
                        "TaxID": "155704849-2-2021",
                        "TaxIDType": "2",
                        "TaxIDAdditionalInfo": {
                            "DigitoVerificador": "32"
                        },
                        "Name":"FE generada en ambiente de pruebas - sin valor comercial ni fiscal",
                        "Contact":{
                            "PhoneList":{
                                "Phone": "997-8242"
                            }
                        },
                        "BranchInfo": {
                            "Code":"0001",
                            "AddressInfo":{
                                "Address": "Blv Costa del Este,PH Financial Tower Piso 17",
                                "City": "Bocas del Toro (Cabecera)",
                                "District": "Bocas del Toro",
                                "State": "Bocas del Toro",
                                "Country": "PA"
                            },
                            "AdditionalBranchInfo": {
                                "CoordEm": "+8.9892,-79.5201",
                                "CodUbi": "1-1-1"
                            }
                        }
                    },
                    "Buyer":{
                        "TaxID": "15430-249-148718",
                        "TaxIDType": "2",
                        "TaxIDAdditionalInfo": {
                            "TipoReceptor": "01",
                            "DigitoVerificador": "09",
                            "CodUbi": "1-1-1"
                        },
                        "Name":"Ace International Hardware Corp.",
                        "AdditionlInfo": {
                            "PaisReceptorFE": "PA"
                        },
                        "AddressInfo": {
                            "Address": "Westland Mall, Vista Alegre, Arraijan",
                            "City": "Bocas del Toro (Cabecera)",
                            "District": "Bocas del Toro",
                            "State":"Bocas del Toro",
                            "Country": "PA"
                        }
                    },
                    "Items":{
                        "Item":{
                            "Codes":{
                                "CodigoProd": "1234567890",
                                "UnidadCPBS": "cm",
                                "CodCPBSabr" :"13"
                            },
                            "Description": "ITEM",
                            "Qty": "1.00",
                            "UnitOfMeasure": "m",
                            "Price":"1.000000",
                            "Taxes":{
                                "Tax":{
                                    "Code": "00",
                                    "Description": "ITBMS",
                                    "Amount":"0.00"
                                }
                            },
                            "Charges":{
                                "Charge":{
                                    "Amount": "1.01"
                                }
                            },
                            "Totals":{
                                "TotalBTaxes": "1.00000",
                                "TotalWTaxes": "1.00000",
                                "SpecificTotal": "2.010000",
                                "TotalItem":"2.010000"
                            }
                        }
                    },
                    "Totals": {
                        "QtyItems": "1",
                        "GrandTotal": {
                            "TotalBTaxes": "2.01",
                            "TotalWTaxes": "2.01",
                            "InvoiceTotal": "2.01"
                        }
                    },
                    "Payments": {
                        "Payment":{
                            "Type": "01",
                            "Amount": "2.01"
                        }
                    },
                    "AdditionalDocumentInfo":{
                        "AdditionalInfo": {
                            "AditionalInfo": {
                                "TiempoPago": "1"
                            }
                        }
                    }
                }',
                true
            );
            
            
            $xml = '<?xml version="1.0" encoding="UTF-8"?>'.arrayToStrXml($arr);

        } else {
            //$xml = $this->toXml($request->all());
            $xml = '<?xml version="1.0" encoding="UTF-8"?>'.arrayToStrXml($request->all());
        }
        #return response($xml, 200)->header('Content-Type', 'text/xml');
        
        
        
        //dump($xml);
        $url = config('digifact.url').'transform/nuc?TAXID='.config('digifact.ruc').'&FORMAT=XML&USERNAME='.config('digifact.username');
        //dd($url);


        $response = Http::
            withHeaders(['Authorization' => $this->api_token])
            ->withBody($xml, 'application/xml')
            ->post($url);


        /*dump($response->status());
        dump($response->ok());
        dump($response->body());
        dd($response->json());*/

        return response()->json($response->json(), $response->status());
    }

    public function cancel_fel(Request $request)
    {
        $data = $request->all();
        $data['Taxid'] = config('digifact.ruc');
        $data['Username'] = config('digifact.username');
        $dataJson = json_encode($data);

        $url = config('digifact.url').'CancelFePA';
        
        $response = Http::
            withHeaders(['Authorization' => $this->api_token])
            ->withBody($dataJson, 'application/json')
            ->post($url);
        return response()->json($response->json(), $response->status());
    }

    public function sharedinfo(Request $request)
    {
        $url = config('digifact.url').'SHAREDINFO?RUC='.config('digifact.ruc').'&USERNAME='.config('digifact.username').'&TRANSACTION='.$request->TRANSACTION.'&DATA1='.$request->DATA1.'&DATA2='.$request->DATA2;

        $response = Http::
            withHeaders(['Authorization' => $this->api_token,])
            ->get($url);
        return response()->json($response->json(), $response->status());
    }

    public function get_document(Request $request)
    {
        $url = config('digifact.url').'GetDocument?RUC='.config('digifact.ruc').'&USERNAME='.config('digifact.username').'&CUFE='.$request->CUFE.'&FORMAT='.$request->FORMAT;
        $response = Http::
            withHeaders(['Authorization' => $this->api_token,])
            ->get($url);
        return response()->json($response->json(), $response->status());
    }

    public function get_info_ruc(Request $request)
    {
        $url = config('digifact.url').'GetInfoRuc?RUC='.$request->RUC.'&TIPO='.$request->TIPO;
        $response = Http::
            withHeaders(['Authorization' => $this->api_token,])
            ->get($url);
        return response()->json($response->json(), $response->status());
    }

    public function pa_ubicaciones(Request $request)
    {
         $url = config('digifact.url').'Pa/Ubicaciones?TIPO='.$request->TIPO.'&PARAM='.$request->PARAM;
         $response = Http::
            withHeaders(['Authorization' => $this->api_token,])
            ->get($url);
        return response()->json($response->json(), $response->status());
    }





    public function invoices(Request $request)
    {
        $resp = $this->toXml($request->all());

        return response($resp, 201)
            ->header('Content-Type', 'text/xml');
    }


    public function creditNote(Request $request)
    {
        $resp = $this->toXml($request->all());

        return response($resp, 201)
            ->header('Content-Type', 'text/xml');
    }


    public function debitNote(Request $request)
    {
        $resp = $this->toXml($request->all());

        return response($resp, 201)
            ->header('Content-Type', 'text/xml');
    }

    private function toXml($arr)
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Root></Root>');
        arrayToXml($arr, $xml);
        return $xml->asXML();
    }
}
