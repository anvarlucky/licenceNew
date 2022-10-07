@extends('layouts.mainDiyor')
@section('content')
    <div class="container-fluid p-5">
        <div class="col-md-12 px-0 table-box">
            <div class="table-top-panel border-bottom d-flex align-items-center justify-content-between px-5 pt-5 pb-4">
                <p class="account-title mb-2">Litsenziya haqida ma'lumot</p>
            </div>

            <div class="account-container min-vh-75 d-flex justify-content-center py-5">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="account-photo">
                                {{--<img src="/storage/validation/photo/{{$student->photo}}" class="w-100" alt="png">--}}
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="account-info">
                                <ul class="mb-5 pb-3">
                                    <li class="d-flex align-items-center justify-content-between">
                                        <div class="col-md-6">
                                            <p class="account-info-title">
                                                Tashkilot nomi:
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="account-info-text">
                                                {{$project->organization_name}}
                                            </p>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between">
                                        <div class="col-md-6">
                                            <p class="account-info-title">
                                                Tashkilot STIR:
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="account-info-text">
                                                {{$project->organization_inn}}
                                            </p>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between">
                                        <div class="col-md-6">
                                            <p class="account-info-title">
                                                Tashkilot telefon raqami:
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="account-info-text">
                                                <b>{{$project->organization_phone}}</b>
                                            </p>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between">
                                        <div class="col-md-6">
                                            <p class="account-info-title">
                                                Litsenziya Berilgan sana:
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="account-info-text">
                                                {{\Carbon\Carbon::parse($project->licence_given_date)->format('d-m-Y')}}
                                            </p>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between">
                                        <div class="col-md-6">
                                            <p class="account-info-title">
                                                Litsenziya raqami:
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="account-info-text">
                                                {{$project->licence_number}}
                                            </p>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between">
                                        <div class="col-md-6">
                                            <p class="account-info-text">
                                                {{$project->end_date}}
                                                {{--{{\Carbon\Carbon::parse($student->starting_date)->format('d-m-Y')}}--}}
                                            </p>
                                        </div>
                                    </li>
                                </ul>

                                <ul class="border-A5C9FF pt-4">
                                    <li class="d-flex align-items-center justify-content-between">
                                        <div class="col-md-6">
                                            <p class="account-info-title">
                                                Ariza raqami:
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="account-info-text">
                                                {{$project->mid}}
                                            </p>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between">
                                        <div class="col-md-6">
                                            <p class="account-info-title">
                                                Litsenziya kategoriyasi:
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="account-info-text">
                                                {{$project->difficulty_category}}
                                            </p>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between">
                                        <div class="col-md-6">
                                            <p class="account-info-title">
                                                Litsenziya yo'nalishlari
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="account-info-text">

                                            @if($project->categories != null)
                                                @foreach($project->categories as $category)
                                                <p>{{$category->id}}-{{ $category->title}}</p>
                                                @endforeach
                                                @else
                                                    {{$project->license_direction}}
                                            @endif
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-2">

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection