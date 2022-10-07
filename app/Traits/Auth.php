<?php


namespace App\Traits;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

trait Auth
{
    public function index(){
        dd("Anvar");
    }

    public function getToken()
    {
        $result = Http::withHeaders([
            'Authorization' => 'Basic SXVnQ2h4XzFabkxsQWhkMEp4OWVtTjZqV3AwYToxUzlrWGxLQzBhWnd3bHNzb28xSzJmM1NRN3dh'
        ])->post("https://iskm.egov.uz:9444/oauth2/token?grant_type=password&username=qv-user&password=8F5zl2w68GU1itlyGF0w")->json();
        return $result["access_token"];
    }

    public function getCompanyDataByInn($inn)
    {
        $result = Http::withToken($this->getToken())->post("https://apimgw.egov.uz:8243/dxa/service/business-reg/v1/legal", [
            'tin' => $inn
        ]);
        return $result->json();

    }

    public function getLicenceByInn($inn){
        $licence = Http::withToken($this->getToken())->post("https://apimgw.egov.uz:8243/dxa/service/license/v1/tin",[
            'tin' => $inn
        ]);
        return $licence->json();
    }

    public function updateUser($user)
    {
        if ($user->name == null || $user->region == null || $user->district == null || $user->address == null) {
            $data = $this->getCompanyDataByInn($user->inn);
            if (isset($data["name"])) {
                $user->name = $data["name"] . ' ' . DB::table('egov_opf')->where('code', $data['opf'])->first()->name;
                $user->region = DB::table('egov_regions')->where('code', $data["home_region"])->first()->name;
                $user->district = DB::table('egov_regions')->where('code', $data["home_subregion"])->first()->name;
                $user->address = $data["home_address"];
                $user->save();
            }

        }
    }
}
