<?php

namespace App\Http\Controllers\Client\client;

use App\Http\Controllers\BaseControllerForClient;
use App\Http\Controllers\Client\ClientController;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
class OrganizationController extends BaseControllerForClient
{
    public function index()
    {
        $orgs = $this->get('https://lic.mc.uz/api/orgs');
        return view('client.organizations.index',[
            'orgs' => $orgs->Body
        ]);
    }

    public function create()
    {
        $client = new Client(['base_uri' => 'http://talim.mc.uz']);
        $regions = $client->request('GET', 'api/reg');
        $regions = json_decode($regions->getBody());
        $districts = $client->request('GET', 'api/dis');
        $districts = json_decode($districts->getBody());
        return view('client.organizations.create',
            [
                'regions' => $regions->data,
                'districts' => $districts->data
            ]);
    }

    public function store(Request $request)
    {
        $request = $request->except('_token');
        $organization = $this->post('https://lic.mc.uz/api/orgs',$request);
        if($organization->success)
        {
            return redirect()->route('organizations.index');
        }

        return redirect()->back()->withErrors($organization->errors);
    }
}
