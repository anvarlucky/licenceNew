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


    public function all($sum = null,$search = null)
    {
        $expertice = Expertice::select('id', 'licence_number', 'organization_inn', 'licence_given_date', 'difficulty_category','organization_name','license_direction')
            ->where('organization_inn', 'like', '%'.$search.'%')
            ->orWhere('licence_number', 'like', '%'.$search.'%')
            ->orWhere('organization_name', 'like', '%'.$search.'%')
            ->orderBy('licence_number','DESC')
            ->paginate($sum);
        $projects = Project::select('id', 'licence_number', 'organization_inn', 'licence_given_date', 'difficulty_category','organization_name','license_direction')
            ->where('organization_inn', 'like', '%'.$search.'%')
            ->orWhere('licence_number', 'like', '%'.$search.'%')
            ->orWhere('organization_name', 'like', '%'.$search.'%')
            ->orderBy('licence_number','DESC')
            ->paginate($sum);
        $mounts = Mountaineering::select('id', 'licence_number', 'organization_inn', 'licence_given_date', 'difficulty_category','organization_name','license_direction')
            ->where('organization_inn', 'like', '%'.$search.'%')
            ->orWhere('licence_number', 'like', '%'.$search.'%')
            ->orWhere('organization_name', 'like', '%'.$search.'%')
            ->orderBy('licence_number','DESC')
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

    public function indexReyting()
    {
        return $this->responseSuccess(Project::select('id', 'organization_name', 'organization_inn',
            'licence_number', 'licence_given_date', 'difficulty_category')->get());
    }
}
