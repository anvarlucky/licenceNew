<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\CreateLicenceForm;
use App\Models\ProjectType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Project;
use App\Models\Region;
use App\Models\District;
use App\Models\Type;
use GuzzleHttp\Client;
use App\Exports\LicencesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


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
            'Accept' => 'application/json',
            'Language' => app()->getLocale()
        ];
        $this->client = new Client(['base_uri' => config('app.api_url')]);
    }

    public function index()
    {
        $projects = Project::orderBy('licence_number', 'DESC')->get();
        $client = new Client(['base_uri' => 'http://talim.mc.uz']);
        $region = $client->request('GET', 'api/reg/');
        $region = json_decode($region->getBody());
        $district = $client->request('GET', 'api/dis');
        $district = json_decode($district->getBody());
        return view('client.projects.index', [
            'projects' => $projects,
            'district' => $district->data,
            'region' => $region->data,
        ]);
    }

    public function export()
    {
        return Excel::download(new LicencesExport, 'Loyiha.xlsx');
    }


    public function search(Request $request)
    {
        $search = $request->post('search');
        $project = Project::search($search);
        return view('client.projects.index', [
            'projects' => $project
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function allsend()
    {
        $projects = Project::select('*')->take(10)->get();
        foreach ($projects as $projectt) {
            DB::table('alllicences')->insert([
                'organization_name' => $projectt['organization_name'],
                'organization_phone' => $projectt['organization_phone'],
                'organization_email' => $projectt['organization_email'],
                'organization_inn' => $projectt['organization_inn'],
                'licence_number' => $projectt['licence_number'],
                'licence_given_date' => $projectt['licence_given_date'],
                'difficulty_category' => $projectt['difficulty_category'],
                'license_direction' => $projectt['license_direction'],
            ]);
        }

    }


    public function create()
    {
        $categories = DB::table('categories')->get();
        $project12 = Project::latest()->first();
        $client = new Client(['base_uri' => 'http://talim.mc.uz']);
        $regions = $client->request('GET', 'api/reg');
        $regions = json_decode($regions->getBody());
        $districts = $client->request('GET', 'api/dis');
        $districts = json_decode($districts->getBody());
        /* $regions = Region::select('*')->get();
         $districts = District::select('*')->get();*/
        $types = Type::select('*')->get();
        return view('client.projects.create', [
            'project12' => $project12,
            'regions' => $regions->data,
            'districts' => $districts->data,
            'types' => $types,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $query = Project::select('*')->where('deleted_at', '!=', null)->get();

        $model = Project::select('*')
            ->where('licence_number', $request['licence_number'])
            ->first();


        if (is_object($model)) {
            if ($model->deleted_at == null) {
                return redirect()->route('projects.index');
            }
        }

        $project = new Project();
        $project->organization_name = $request['organization_name'];
        $project->licence_number = $request['licence_number'];
        $project->organization_phone = $request['organization_phone'];
        $project->organization_inn = $request['organization_inn'];
        $project->licence_number = $request['licence_number'];
        $project->licence_given_date = $request['licence_given_date'];
        $project->difficulty_category = $request['difficulty_category'];
        $project->license_direction = $request['license_direction'];
        $project->deleted_at = null;
        $project->save();
//        $project = Project::create($request);
        DB::table('alllicences')->insert([
            'organization_name' => $request['organization_name'],
            'organization_phone' => $request['organization_phone'],
            'organization_inn' => $request['organization_inn'],
            'licence_number' => $request['licence_number'],
            'licence_given_date' => $request['licence_given_date'],
            'difficulty_category' => $request['difficulty_category'],
            'license_direction' => $request['license_direction'],
            'type' => 1
        ]);

        if ($project == true) {
            $project->categories()->attach($request->categories);
            if ($project == true)
                return redirect()->route('projects.index');
            else
                return redirect()->back()->withErrors();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        $project = Project::select('*')->find($id);
        return view('client.projects.show', [
            'project' => $project
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        $categories = DB::table('categories')->get();
        $project = Project::select('*')->find($id);
        $client = new Client(['base_uri' => 'http://talim.mc.uz']);
        $regions = $client->request('GET', 'api/reg');
        $regions = json_decode($regions->getBody());
        $districts = $client->request('GET', 'api/dis');
        $districts = json_decode($districts->getBody());
        return view('client.projects.edit', [
            'project' => $project,
            'regions' => $regions->data,
            'districts' => $districts->data,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {
        $project = Project::select('*')->find($id);
        $project->licence_given_date = $request->licence_given_date;
        $project->licence_number = $request->licence_number;
        $project->organization_name = $request->organization_name;
        $project->organization_inn = $request->organization_inn;
        $project->organization_phone = $request->organization_phone;
        $project->organization_email = $request->organization_email;
        $project->difficulty_category = $request->difficulty_category;
        $project->license_direction = $request->license_direction;
        $project->mid = $request->mid;
        $project->save();
        $request = $request->except('_token');
        DB::table('alllicences')->insert([
            'organization_name' => $request['organization_name'],
            'organization_phone' => $request['organization_phone'],
            'organization_inn' => $request['organization_inn'],
            'licence_number' => $request['licence_number'],
            'licence_given_date' => $request['licence_given_date'],
            'difficulty_category' => $request['difficulty_category'],
            'license_direction' => $request['license_direction'],
            'type' => 1
        ]);
        if ($project == true) {
            $project->categories()->sync($request->categories, false);
            return redirect()->route('projects.index');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        $project = Project::destroy($id);
        if ($project == true) {
            return redirect()->route('projects.index');
        }
    }
}
