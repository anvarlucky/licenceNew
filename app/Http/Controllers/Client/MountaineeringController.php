<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Mountaineering;
use App\Models\Region;
use App\Models\District;
use App\Http\Requests\MountaineeringRequest;
use GuzzleHttp\Client;
use App\Exports\MountaineeringExport;
use Maatwebsite\Excel\Facades\Excel;

class MountaineeringController extends Controller
{

    protected const CODE_VALIDATION_SUCCESS = 200;
    protected const CODE_VALIDATION_ERROR = 422;
    protected const CODE_MANY_REQUESTS = 429;
    protected const CODE_SUCCESS_UPDATED = 202;
    protected const CODE_SUCCESS_CREATED = 201;
    protected const CODE_SUCCESS_DELETED = 202;
    protected const CODE_UNAUTHORIZED = 401;
    protected const CODE_NOTFOUND = 404;
    protected const CODE_ACCESS_DENIED = 403;
    protected $client;

    public function __construct()
    {
        $this->headers = [
            'Accept'        => 'application/json',
            'Language'      => app()->getLocale()
        ];
        $this->client = new Client(['base_uri' => config('app.api_url')]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mauntaineeringes = Mountaineering::select('*')->orderBy('licence_number', 'DESC')->get();
        return view('client.mauntaineering.index',[
            'mauntaineeringes' => $mauntaineeringes
        ]);
    }

    public function export()
    {
        return Excel::download(new MountaineeringExport, 'BalandlikAlpinzmMudofaa.xlsx');
    }


    public function search(Request $request)
    {
        $search = $request->post('search');
        $mauntaineeringes = Mountaineering::search($search);
        return view('client.mauntaineering.index', [
            'mauntaineeringes' => $mauntaineeringes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mauntaineering12 = Mountaineering::latest()->first();
        $client = new Client(['base_uri' => 'http://talim.mc.uz']);
        $regions = $client->request('GET', 'api/reg');
        $regions = json_decode($regions->getBody());
        $districts = $client->request('GET', 'api/dis');
        $districts = json_decode($districts->getBody());
        $types = Type::select('*')->get();
        return view('client.mauntaineering.create', [
            'mauntaineering12' => $mauntaineering12,
            'regions' => $regions->data,
            'districts' => $districts->data,
            'types' => $types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MountaineeringRequest $request)
    {
        $request1 = $request->except(['types','_token']);
        $mountaineering = Mountaineering::create($request1);
        DB::table('alllicences')->insert([
            'organization_name' => $request1['organization_name'],
            'organization_phone'=> $request1['organization_phone'],
            'organization_inn'=> $request1['organization_inn'],
            'licence_number'=> $request1['licence_number'],
            'licence_given_date'=> $request1['licence_given_date'],
            'difficulty_category'=> $request1['difficulty_category'],
            'license_direction'=> $request1['license_direction'],
            'type' => 3
        ]);
        if($mountaineering==true){
                return redirect()->route('mauntaineering.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mauntaineering = Mountaineering::select('*')->find($id);
        return view('client.mauntaineering.show',[
            'mauntaineering' => $mauntaineering
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mauntaineering = Mountaineering::select('*')->find($id);
        $types = Type::select('*')->get();
        $client = new Client(['base_uri' => 'http://talim.mc.uz']);
        $regions = $client->request('GET', 'api/reg');
        $regions = json_decode($regions->getBody());
        $districts = $client->request('GET', 'api/dis');
        $districts = json_decode($districts->getBody());
        return view('client.mauntaineering.edit', [
            'mauntaineering' => $mauntaineering,
            'regions' => $regions->data,
            'districts' => $districts->data,
            'types' => $types
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mauntaineering = Mountaineering::select('*')->find($id);
        $mauntaineering->licence_number = $request->licence_number;
        $mauntaineering->licence_given_date =$request->licence_given_date;
        $mauntaineering->organization_inn = $request->organization_inn;
        $mauntaineering->organization_name = $request->organization_name;
        $mauntaineering->organization_phone = $request->organization_phone;
        $mauntaineering->license_direction = $request->license_direction;
        $mauntaineering->mid = $request->mid;
        $mauntaineering->save();
        if($mauntaineering == true)
        {
            return redirect()->route('mauntaineering.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
