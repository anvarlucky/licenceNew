<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseControllerForClient;
use App\Http\Controllers\Controller;
use App\Models\Mountaineering;
use App\Models\Organization;
use App\Models\Project;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class DSQController extends BaseControllerForClient
{
    public function mountaineering()
    {
        $client = new Client([
            'headers' => ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        ]);
        $mount = Mountaineering::select('id as send_id', 'organization_name as license_name', 'organization_address as address', 'organization_phone as phone_number',
            'organization_account_number as account_number', 'organization_email as e_adress', 'organization_inn as tin', 'organization_director as fio_director',
            'licence_number as license_number', 'licence_given_date as license_date', 'end_date as license_term', 'license_direction as type_of_activity', 'status_gnk')->where('status_gnk', null)
            ->take(5)->get();
        foreach ($mount as $mount){
        $string = $mount->type_of_activity;
        $m = mb_substr($string, 0, 95);
        dump($mount->send_id);
        dump($m);
        dump($mount->send_id, $mount->license_name, $mount->license_number);
        $response1 = $client->post('http://192.168.222.1:8193/api/ministry1',
            ['body' => json_encode([
                "send_id" => $mount->send_id,
                "send_date" => time() * 1000,
                "license_name" => str_replace(['"', "'"], '', $mount->license_name),
                "address" => $mount->address,
                "phone_number" => str_replace([' ', '-'], '', $mount->phone_number),
                "account_number" => str_replace(' ', '', $mount->account_number),
                "e_adress" => $mount->e_adress,
                "tin" => str_replace(' ', '', $mount->tin),
                "pinfl" => "",
                "fio_director" => $mount->fio_director,
                "license_number" => $mount->license_number,
                "license_date" => strtotime($mount->license_date) * 1000,
                "license_term" => strtotime($mount->license_term) * 1000,
                "type_of_activity" => $m,
                "license_edit_asosDate" => "",
                "license_end_asosDate" => ""
            ])
            ]);
        $ans = json_decode($response1->getBody());
        if ($ans->success == true) {
            dump($ans);
            Mountaineering::where('id', $mount->send_id)->update(['status_gnk' => 1]);
        } else {
            dd($ans);
        }
        }
    }

    public function projects()
    {
        $client = new Client([
            'headers' => ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        ]);
        $project = Project::select('id as send_id','region','district', 'organization_name as license_name', 'mid as ariza_number', 'organization_address as address', 'organization_phone as phone_number',
            'organization_account_number as account_number', 'organization_email as e_adress', 'organization_inn as tin', 'organization_director as fio_director',
            'licence_number as license_number', 'licence_given_date as license_date', 'difficulty_category as complexity_category', 'license_direction as type_of_activity',
            'cause as license_edit_asos_date', 'cause as license_end_asos_date')->where('status_gnk', null)->take(5)->get();

        foreach ($project as $project) {
            $prr = str_replace([' ',"\r\n","\t",'-',';',"\n"], ' ', $project->type_of_activity);
        $m = mb_substr($prr, 0, 2000);
        $phone = str_replace([' ', '-','+','998','.'], ['','',' ',' 998',''], $project->phone_number);
            $address = $project->region.' '.$project->district;
            dump($project->send_id, $project->license_name, $project->license_number, $m,$phone);
            $response2 = $client->post('http://192.168.222.1:8193/api/ministry2',
                ['body' => json_encode([
                    "send_id" => $project->send_id,
                    "send_date" => time() * 1000,
                    "license_name" => str_replace(['"', "'"], '', $project->license_name),
                    "ariz_number" => $project->ariza_number,
                    "address" => $address,
                    "phone_number" => str_replace([' ', '-','+','998','.'], ['','',' ',' 998',''], $project->phone_number),
                    "account_number" => str_replace(' ', '', $project->account_number),
                    "e_adress" => $project->e_adress,
                    "tin" => str_replace(' ', '', $project->tin),
                    "pinfl" => "",
                    "fio_director" => $project->fio_director,
                    "license_number" => $project->license_number,
                    "license_date" => strtotime($project->license_date) * 1000,
                    "complexity_category" => str_replace(' ', '', $project->complexity_category),
                    "type_of_activity" => $m,
                    "license_edit_asos_date" => mb_substr($project->license_edit_asos_date, 0, 200),
                    "license_end_asos_date" => mb_substr($project->license_end_asos_date, 0, 200)
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

    public function organizations(){
        $client = new Client([
            'headers' => ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        ]);
        $orgs = Organization::select('*')->where('status_gnk', null)->take(5)->get();
        foreach ($orgs as $orgs) {
            dump($orgs->id);
            dump($orgs->company_name);
            $response3 = $client->post('http://192.168.222.1:8193/api/ministry7',
                ['body' => json_encode([
                    "send_id" => $orgs->id,
                    "send_date" => time() * 1000,
                    "company_name" => $orgs->company_name,
                    "company_status" => $orgs->company_status,
                    "company_tin" => $orgs->company_tin,
                    "company_ns10" => $orgs->company_ns10,
                    "company_ns11" => $orgs->company_ns11,
                    "company_adress" => $orgs->company_adress,
                    "performed_service" => "$orgs->performed_service",
                ])
                ]);
            $ans = json_decode($response3->getBody());
            if ($ans->success == true) {
                dump($ans);
                Organization::where('id', $orgs->id)->update(['status_gnk' => 1]);
            } else {
                dd($ans);
            }
        }
    }
}
