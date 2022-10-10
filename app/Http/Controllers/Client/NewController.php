<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Auth;

class NewController extends Controller
{
    use Auth;
    public function index(){
        //dd(Auth::getCompanyDataByInn);
    }

    public function newbus(){
        $product = null;
        return view('client.new.index',['product' => $product]);
    }

    public function newlic(){
        $licence = null;
        return view('client.new.newlic',['licence' => $licence]);
    }

    public function newuniver(){
        $univer = null;
        return view('client.new.newuniver',['univer' => $univer]);
    }

    public function search(Request $request)
    {
        $search = $request->post('search');
        $product = $this->getCompanyDataByInn($search);
        return view('client.new.index', ['product' => $product,'search' => $search]);
    }

    public function licsearch(Request $request){
        $search = $request->post('search');
        $licence = $this->getLicenceByInn($search);
        //dd($licence['data'][0]);
        return view('client.new.newlic', ['licence' => $licence['data'][0],'search' => $search]);
    }

    public function universearch(Request $request){
        $search = $request->post('search');
        $univer = $this->getUnivercity($search);
        return view('client.new.newuniver',['univer' => $univer[0],'search' => $search]);
    }

    public function __invoke()
    {
        $product = $this->getCompanyDataByInn('302964974');
        $lic = $this->getLicenceByInn('309636474');
        dd($lic);
        dd(Auth::class);
        dd(Auth::getCompanyDataByInn);
        dd('main');
    }
}
