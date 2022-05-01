<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ForApiController;
use App\Models\Expertice;
use App\Models\Mountaineering;
use App\Models\Project;
use Hamcrest\Type\IsArray;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class ProjectController extends ForApiController
{
    public function index1($inn = null)
    {
        return $this->responseSuccess(Project::select('id', 'organization_name as license_name', 'mid as ariza_number', 'organization_address as address', 'organization_phone as phone_number',
            'organization_account_number as account_number', 'organization_email as e_adress', 'organization_inn as tin', 'organization_director as fio_director',
            'licence_number as license_number', 'licence_given_date as license_date', 'difficulty_category as complexity_category', 'license_direction as type_of_activity',
            'cause as license_edit_asos_date')->where('organization_inn', $inn)->paginate(10));
    }

    public function allprojects($id = null){
        return $this->responseSuccess(Project::select('*')->where('licence_number',$id)->get());
    }

    public function index(Request $request)
    {
        $query = Project::select('id as send_id', 'organization_name as license_name', 'mid as ariza_number', 'organization_address as address', 'organization_phone as phone_number',
            'organization_account_number as account_number', 'organization_email as e_adress', 'organization_inn as tin', 'organization_director as fio_director',
            'licence_number as license_number', 'licence_given_date as license_date', 'difficulty_category as complexity_category', 'license_direction as type_of_activity',
            'cause as license_edit_asos_date', 'cause as license_end_asos_date');

        if ($request->inn)
            $query->where('organization_inn', $request->inn);
        else {
            $query->where('status_gnk', null);
        }
        $model = $query->get();
        return $this->responseSuccess($model);

    }


    public function index2(Request $request)
    {
        if ($request->inn)
            return $this->responseSuccess(Project::select('id as send_id', 'organization_name as license_name', 'mid as ariza_number', 'organization_address as address', 'organization_phone as phone_number',
                'organization_account_number as account_number', 'organization_email as e_adress', 'organization_inn as tin', 'organization_director as fio_director',
                'licence_number as license_number', 'licence_given_date as license_date', 'difficulty_category as complexity_category', 'license_direction as type_of_activity',
                'cause as license_edit_asos_date', 'cause as license_end_asos_date')->where('organization_inn', $request->inn)->get());
        else {
            return $this->responseSuccess(Project::select('id as send_id', 'organization_name as license_name', 'mid as ariza_number', 'organization_address as address', 'organization_phone as phone_number',
                'organization_account_number as account_number', 'organization_email as e_adress', 'organization_inn as tin', 'organization_director as fio_director',
                'licence_number as license_number', 'licence_given_date as license_date', 'difficulty_category as complexity_category', 'license_direction as type_of_activity',
                'cause as license_edit_asos_date', 'cause as license_end_asos_date')->where('status_gnk', null)->get());
        }
    }

    public function projects()
    {
        $client = new Client([
            'headers' => ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        ]);
        $project = Project::select('organization_name', 'organization_phone', 'organization_email', 'organization_inn', 'licence_number', 'licence_given_date', 'difficulty_category', 'license_direction')->take(5)->get();

        foreach ($project as $project) {
            $prr = $project->type_of_activity;
            $m = $prr;
            $phone = $project->phone_number;
            dump($project->licence_number);
            $response2 = $client->post('http://licence.loc/api/ministry2',
                ['body' => json_encode([
                    "organization_name" => $project->organization_name,
                    "organization_phone" => $project->organization_phone,
                    "organization_email" => $project->organization_email,
                    "organization_inn" => $project->organization_inn,
                    "licence_number" => $project->licence_number,
                    "licence_given_date" => $project->licence_given_date,
                    "difficulty_category" => $project->difficulty_category,
                    "license_direction" => $project->license_direction,
                ])
                ]);
            $answer = json_decode($response2->getBody());
            if ($answer->success == true) {
                dump($answer);
                Project::where('id', $project->send_id)->update(['status_gnk' => 1]);
            } else {
                dd($answer);
            }
        }
    }

    public function allsend(){
        $projects = Project::select('*')->take(10)->get();
        foreach ($projects as $projectt){
        DB::table('alllicences')->insert([
        'organization_name' => $projectt['organization_name'],
        'organization_phone'=> $projectt['organization_phone'],
        'organization_email'=> $projectt['organization_email'],
        'organization_inn'=> $projectt['organization_inn'],
        'licence_number'=> $projectt['licence_number'],
        'licence_given_date'=> $projectt['licence_given_date'],
        'difficulty_category'=> $projectt['difficulty_category'],
        'license_direction'=> $projectt['license_direction'],
            ]);
        }

    }


    public function all($sum = null,$search = null)
    {
        /*if ($sum != null && $search == null){
            $expertice = Expertice::select('id', 'licence_number', 'organization_inn', 'licence_given_date', 'difficulty_category','organization_name','license_direction')
                ->paginate($sum);
            $projects = Project::select('id', 'licence_number', 'organization_inn', 'licence_given_date', 'difficulty_category','organization_name','license_direction')
                ->paginate($sum);
            $mounts = Mountaineering::select('id', 'licence_number', 'organization_inn', 'licence_given_date', 'difficulty_category','organization_name','license_direction')
                ->paginate($sum);
            foreach ($projects as $key => $items) {
                if (isset($expertice[$key])) {
                    $projects[] = $expertice[$key];
                }
                if (isset($mounts[$key])){
                    $projects[] = $mounts[$key];
                }
            }
            return $this->responseSuccess($projects);
        }
        if (isset($search)){

        $projects2 = Project::select('id', 'licence_number', 'organization_inn', 'licence_given_date', 'difficulty_category','organization_name','license_direction')
            ->where('organization_inn', 'like', '%'.$search.'%')
            ->orWhere('licence_number', 'like', '%'.$search.'%')
            ->orWhere('organization_name', 'like', '%'.$search.'%')
            ->orderBy('licence_number','DESC')
            ->paginate($sum);
            return $this->responseSuccess($projects2);
        }

        if(isset($search2)){
            $expertice2 = Expertice::select('id', 'licence_number', 'organization_inn', 'licence_given_date', 'difficulty_category','organization_name','license_direction')
                ->where('organization_inn', 'like', '%'.$search2.'%')
                ->orWhere('licence_number', 'like', '%'.$search2.'%')
                ->orWhere('organization_name', 'like', '%'.$search2.'%')
                ->orderBy('licence_number','DESC')
                ->paginate($sum);
            return $this->responseSuccess($expertice2);
        }*/



        /*if (isset($search)){
            $mounts2 = Mountaineering::select('id', 'licence_number', 'organization_inn', 'licence_given_date', 'difficulty_category','organization_name','license_direction')
                ->where('organization_inn', 'like', '%'.$search.'%')
                ->orWhere('licence_number', 'like', '%'.$search.'%')
                ->orWhere('organization_name', 'like', '%'.$search.'%')
                ->orderBy('licence_number','DESC')
                ->paginate($sum);
            return $this->responseSuccess($mounts2);
        }*/

        if ($sum != null && $search == null){
            $expertice = DB::table('alllicences')->select('id', 'licence_number', 'organization_inn', 'licence_given_date', 'difficulty_category','organization_name','license_direction','statusmc')
                ->where('deleted_at','=',null)
                ->orderBy('licence_number')
                ->paginate($sum);
            return $this->responseSuccess($expertice);
        }
        if (isset($search)){
            $expertice = DB::table('alllicences')->select('id', 'licence_number', 'organization_inn', 'licence_given_date', 'difficulty_category','organization_name','license_direction')
                ->where('organization_inn', 'like', '%'.$search.'%')
                ->orWhere('licence_number', 'like', '%'.$search.'%')
                ->orWhere('organization_name', 'like', '%'.$search.'%')
                ->paginate($sum);
        }
        return $this->responseSuccess($expertice);

    }

    public function indexReyting()
    {
        return $this->responseSuccess(Project::select('id', 'organization_name', 'organization_inn',
            'licence_number', 'licence_given_date', 'difficulty_category')->get());
    }
}
