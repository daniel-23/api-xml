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
        $xml = $this->toXml($request->all());
        /*$xml = $this->toXml([
            'Version' => 1.00,
            'CountryCode' => 'PA',
        ]);*/
        //dump($xml);
        $url = config('digifact.url').'transform/nuc?TAXID='.config('digifact.ruc').'&FORMAT=XML&USERNAME='.config('digifact.username');
        //dump($url);


        $response = Http::
            withHeaders(['Authorization' => $this->api_token])
            ->withBody($xml, 'application/xml')
            ->post($url);


        /*dump($response->status());
        dump($response->ok());
        dump($response->body());
        dump($response->json());*/

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
