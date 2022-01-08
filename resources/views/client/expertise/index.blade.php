@extends('layouts.mainDiyor')
@section('content')
    <div class="container-fluid p-5">
        <div class="d-flex justify-content-between align-items-center">
            <p class="title-list">Qurulish loyihalarini ekspertizadan o`tkazuvchi yuridik shaxslarni akkreditatsiya ro'yhati</p>
            <form action="{{route('expertice.search')}}" method="post" class="input-group  search-input col-4 mb-3">
                @csrf
                <input type="text" name="search" class="form-control focus-none border-right-0" placeholder="Qidiruv"
                       aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="input-group-text"><i class="fa fa-search" type="button"></i></button>
                </div>
            </form>
        </div>

        <div class="col-12 px-0 table-box">
            <div class="table-top-panel d-flex align-items-center justify-content-between px-2 py-3">
                <ul class="d-flex">
                    <li class="col px-0 mx-3 table-top-panel-items {{--active--}} {{route('expertice.index') ? 'active' : ''}}">
                        <a href="{{route('expertice.index')}}" class="text-decoration-none table-top-panel-items-link">Guvohnoma olganlar</a>
                    </li>
                    <li class="col px-0 mx-3 table-top-panel-items">
                        <a href="{{route('export2')}}" class="text-decoration-none table-top-panel-items-link">Excelga Yuklab olish</a>
                    </li>
                </ul>


                <a href="{{route('expertice.create')}}" class="btn adding-button">
                    Yangi qo'shish <i class="fa fa-plus ml-2 mt-1"></i>
                </a>
            </div>


            <div class="table-responsive">
                <table class="table table-hover" id="org_table">
                    <thead>
                    <tr>
                        <th class="lightblue-color w-2" scope="col">#</th>
                        <th class="darkblue-color text-center text-nowrap align-top"></th>
                        <th class="darkblue-color text-center text-nowrap align-top">Guvohnoma raqami</th>
                        <th class="darkblue-color text-center text-nowrap align-top">Guvohnoma berilgan sana</th>
                        <th class="darkblue-color text-center text-nowrap align-top">Tashkilot nomi</th>
                        <th class="darkblue-color text-center text-nowrap align-top">Tashkilot INN</th>
                        <th class="darkblue-color text-center text-nowrap align-top"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($expertices as $key => $expertice)
                        <tr>
                            <th class="lightblue-color w-2 align-middle" scope="row">{{++$key}}</th>
                            <td class="darkblue-color d-flex align-items-center justify-content-end">
                                <a href="{{route('expertice.edit', $expertice->id)}}" class="btn btn-outline-primary mr-3 text-nowrap">O`zgartirish</a>
                            </td>
                            <td class="darkblue-color text-center text-nowrap align-middle"><a href="{{route('expertice.show',$expertice->id)}}">{{$expertice->licence_number}}</a></td>
                            <td class="darkblue-color text-center text-nowrap align-middle">{{$expertice->licence_given_date}}</td>
                            <td class="darkblue-color text-center text-nowrap align-middle">{{$expertice->organization_name}}</td>
                            <td class="darkblue-color text-center text-nowrap align-middle">{{$expertice->organization_inn}}
                            </td>
                            <td>
                                <form action="{{ route('expertice.destroy', $expertice->id)}}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <input class="btn btn-outline-danger mr-3" type="submit" onclick="return confirm('Rostdan ham {{$expertice->licence_number}} o`chirmoqchimisiz?')" value="O`chirish" />
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <br/>
        {{--{{$projects->render()}}--}}
    </div>
@endsection


