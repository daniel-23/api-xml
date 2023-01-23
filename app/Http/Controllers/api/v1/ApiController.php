<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
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
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><root></root>');
        arrayToXml($arr, $xml);
        return $xml->asXML();
    }
}
