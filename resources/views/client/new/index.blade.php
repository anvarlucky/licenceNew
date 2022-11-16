@extends('layouts.mainDiyor')
@section('content')
    <div class="container-fluid p-5">
        <div class="d-flex justify-content-between align-items-center">
            <p class="title-list">Tadbirkorlik sub'ektini davlat ro'yxatidan o'tkazilganligi to'g'risidagi guvohnoma ma'lumotlari</p>
            <form action="{{route('newbus.search')}}" method="post" class="input-group  search-input col-4 mb-3">
                @csrf
                <input type="text" name="search" class="form-control focus-none border-right-0" placeholder="INN Bo`yicha Qidiruv"
                       aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="input-group-text"><i class="fa fa-search" type="button"></i></button>
                </div>
            </form>
        </div>

        <div class="col-12 px-0 table-box">
            <div class="table-top-panel d-flex align-items-center justify-content-between px-2 py-3">
               {{-- <ul class="d-flex">
                    <li class="col px-0 mx-3 table-top-panel-items --}}{{--active--}}{{-- {{route('projects.index') ? 'active' : ''}}">
                        <a href="{{route('projects.index')}}" class="text-decoration-none table-top-panel-items-link">Litsenziya olganlar</a>
                    </li>
                    <li class="col px-0 mx-3 table-top-panel-items">
                        <a href="{{route('export1')}}" class="text-decoration-none table-top-panel-items-link">Excelga Yuklab olish</a>
                    </li>--}}
                </ul>


                {{--<a href="{{route('projects.create')}}" class="btn adding-button">
                    Yangi qo'shish <i class="fa fa-plus ml-2 mt-1"></i>
                </a>--}}
            </div>


            <div class="table-responsive">
                <table class="table table-hover" id="org_table">
                    <thead>
                    <tr>
                        <th class="lightblue-color w-2" scope="col">#</th>
                        <th class="darkblue-color text-center text-nowrap align-top"></th>
                        <th class="darkblue-color text-center text-nowrap align-top">Tadbirkor nomi</th>
                        <th class="darkblue-color text-center text-nowrap align-top">Tadbirkor INN</th>
                        <th class="darkblue-color text-center text-nowrap align-top">Ro`yhatga olingan sana</th>
                        <th class="darkblue-color text-center text-nowrap align-top">Sertifikat raqami</th>
                        <th class="darkblue-color text-center text-nowrap align-top">Ro`hatga olingan raqami</th>
                        <th class="darkblue-color text-center align-top">Address
                        </th>
                        <th class="darkblue-color text-center align-top"></th>
                    </tr>
                    </thead>
                    @if($product != null)
                    <tbody>
                    @if(isset($product['message']))
                        {{"Bu INN bo'yicha hechnima topilmadi"}}
                    @else

                        <tr >

                                <th class="lightblue-color w-2 align-middle" scope="row"></th>



                            <td class="darkblue-color d-flex align-items-center justify-content-end">

                            </td>
                            <td class="darkblue-color text-center text-nowrap align-middle">{{$product['name']}}</td>
                            <td class="darkblue-color text-center text-nowrap align-middle">{{$product['tin']}}</td>
                            <td class="darkblue-color text-center text-nowrap align-middle">{{$product['official_registration_date']}}</td>
                            <td class="darkblue-color text-center text-nowrap align-middle">{{$product['certificate_number']}}</td>
                            <td class="darkblue-color text-center text-nowrap align-middle">{{$product['registry_number']}}
                            </td>
                            <td class="darkblue-color text-center text-nowrap align-middle">{{$product['home_address']}}
                            </td>
                        </tr>
                    @endif
                    </tbody>
                    @else
                        Ma`lumot yo`q
                        @endif
                </table>
            </div>

        </div>
        <br/>
        {{--        {{$projects->onEachSide(1)->links()}}--}}
    </div>
@endsection


