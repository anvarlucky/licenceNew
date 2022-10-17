<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExDecisionRequest;
use App\Models\Expertice;
use App\Models\Region;
use App\Models\District;
use App\Http\Requests\ExpetiseRequest;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Exports\ExperticesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ExperticeController extends Controller
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
        $expertices = Expertice::orderBy('licence_number', 'DESC')->get();


        $today = date('d');
        foreach ($expertices as $expertice) {
            $start_day = Carbon::parse($expertice->decision_start_date)->format('d');
            if ($today - $start_day >= 10) {
                $expertice->statusmc = null;
                $expertice->save();
            }
        }

        return view('client.expertise.index',[
            'expertices' => $expertices
        ]);
    }

    public function export()
    {
        return Excel::download(new ExperticesExport, 'Ekspertiza.xlsx');
    }

    public function search(Request $request)
    {
        $search = $request->post('search');
        $expertices = Expertice::search($search);
        return view('client.expertise.index', [
            'expertices' => $expertices
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $expertice12 = Expertice::latest()->first();
        $client = new Client(['base_uri' => 'http://talim.mc.uz']);
        $regions = $client->request('GET', 'api/reg');
        $regions = json_decode($regions->getBody());
        $districts = $client->request('GET', 'api/dis');
        $districts = json_decode($districts->getBody());
        return view('client.expertise.create', [
            'expertice12' => $expertice12,
            'regions' => $regions->data,
            'districts' => $districts->data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpetiseRequest $request)
    {
        $request = $request->except('_token');
        $expertice = Expertice::create($request);
        DB::table('alllicences')->insert([
            'organization_name' => $request['organization_name'],
            'organization_phone'=> $request['organization_phone'],
            'organization_inn'=> $request['organization_inn'],
            'licence_number'=> $request['licence_number'],
            'licence_given_date'=> $request['licence_given_date'],
            'license_direction'=> $request['license_direction'],
            'type' => 2
        ]);
        /*if($project && $request->type_id)
        {
            foreach($request->type_id as $typeId)
            {
                $projectType = new ProjectType();
                $projectType->project_id = $project->id;
                $projectType->type_id = $typeId;
                $projectType->save();
            }
        }*/
        if($expertice==true)
            return redirect()->route('expertice.index');
        else
            return redirect()->back()->withErrors();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expertice = Expertice::select('*')->find($id);
        return view('client.expertise.show',[
            'expertice' => $expertice
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
        $expertice = Expertice::select('*')->find($id);
        $client = new Client(['base_uri' => 'http://talim.mc.uz']);
        $regions = $client->request('GET', 'api/reg');
        $regions = json_decode($regions->getBody());
        $districts = $client->request('GET', 'api/dis');
        $districts = json_decode($districts->getBody());
        return view('client.expertise.edit', [
            'expertice' => $expertice,
            'regions' => $regions->data,
            'districts' => $districts->data
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
        $expertice = Expertice::select('*')->find($id);
        $expertice->licence_number = $request->licence_number;
        $expertice->licence_given_date =$request->licence_given_date;
        $expertice->end_date = $request->end_date;
        $expertice->organization_inn = $request->organization_inn;
        $expertice->organization_name = $request->organization_name;
        $expertice->organization_phone = $request->organization_phone;
        $expertice->organization_email = $request->organization_email;
        $expertice->region_id = $request->region_id;
        $expertice->district_id = $request->district_id;
        $expertice->organization_address = $request->organization_address;
        $expertice->organization_director = $request->organization_director;
        $expertice->organization_account_number = $request->organization_account_number;
        $expertice->difficulty_category = $request->difficulty_category;
        $expertice->license_direction = $request->license_direction;
        $expertice->licence_number_new = $request->licence_number_new;
        $expertice->status = 2;
        $expertice->mid = $request->mid;
        $expertice->save();
        /*$request = $request->except('_token');
        DB::table('alllicences')->insert([
            'organization_name' => $request['organization_name'],
            'organization_phone'=> $request['organization_phone'],
            'organization_inn'=> $request['organization_inn'],
            'licence_number'=> $request['licence_number'],
            'licence_given_date'=> $request['licence_given_date'],
            //'difficulty_category'=> $request['difficulty_category'],
            'license_direction'=> $request['license_direction'],
            'type' => 2
        ]);*/
        if($expertice == true)
        {
            return redirect()->route('expertice.index');
        }
    }


    //Vazir Buyrug`i

    public function decisionget($id){
        $expertice = Expertice::select('*')->find($id);
        return view('client.expertise.decision',['expertice' => $expertice]);
    }

    public function decision(ExDecisionRequest $request, $id){
        //dd($request);
        $validator = Validator::make($request->all(), [
            'decision_start_date' => 'required',
            'decision_number' => 'required',
        ]);
        $expertice = Expertice::select('*')->find($id);
        $expertice->decision_start_date = $request['decision_start_date'];
        $expertice->decision_number = $request['decision_number'];
        $expertice->statusmc = 1;
        $expertice->save();
        /*if ($validator->fails()) {
            return redirect('decision1get/'.$id)
                ->withErrors($validator)
                ->withInput();
        }*/
        if ($expertice == true) {

            return redirect()->route('expertice.index');
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
        $expertice = Expertice::destroy($id);
        if ($expertice == true){
            return redirect()->route('expertice.index');
        }
    }
}
