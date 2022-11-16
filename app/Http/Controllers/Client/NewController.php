<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Auth;

class NewController extends Controller
{
    use Auth;

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
        if(isset($licence['data'][0])) {
            return view('client.new.newlic', ['licence' => $licence['data'][0], 'search' => $search]);
        }
        else{
            return view('client.new.newlic', ['licence' => $licence, 'search' => $search]);
        }
    }

    public function universearch(Request $request){
        $search = $request->post('search');
        $univer = $this->getUnivercity($search);
        if (isset($univer[0])) {
            return view('client.new.newuniver', ['univer' => $univer[0], 'search' => $search]);
        }
        else{
            return view('client.new.newuniver', ['univer' => $univer, 'search' => $search]);
        }
    }

}
