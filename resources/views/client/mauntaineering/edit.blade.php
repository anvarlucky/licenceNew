@extends('layouts.mainDiyor')
@section('content')
    <div class="container-fluid p-5">
        <div class="col-md-12 px-0 table-box">
            <div class="table-top-panel border-bottom d-flex align-items-center justify-content-between px-5 pt-5 pb-4">
                <p class="account-title mb-2">Litsenziya qayta o'zgartirish oynasi</p>
            </div>
            @if(session('message'))
                <div class="alert alert-danger">
                    {{session('message')}}
                </div>
            @endif
            <div class="form-group col-md-12">
                {{Form::open(['route' => ['mauntaineering.update',$mauntaineering->id],'method' => 'put'])}}
                @csrf
                <div class="form-group">
                    <label for="">Litsenziya raqami</label>
                    {{Form::text('licence_number', $mauntaineering->licence_number??'ҚВ-', ['class' => 'form-control','readonly'])}}
                </div>
                <div class="form-group">
                    <label for="">Litsenziya berilgan sana</label>
                    {{Form::date('licence_given_date', $mauntaineering->licence_given_date??null, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                    <label for="">Tashkilot INN</label>
                    {{Form::text('organization_inn', $mauntaineering->organization_inn??null, ['class' => 'form-control','id'=>'tin','readonly'])}}
                </div>
                <div class="form-group">
                    <label for="">Tashkilot nomi</label>
                    {{Form::text('organization_name', $mauntaineering->organization_name??null, ['class' => 'form-control','id'=>'acron_uz'])}}
                </div>
                <div class="form-group">
                    <label for="">Tashkilot telefon raqami</label>
                    {{Form::text('organization_phone', $mauntaineering->organization_phone??null, ['class' => 'form-control','id'=>'phone'])}}
                </div>
                {{Form::hidden('organization_account_number', 'null')}}
                <div class="form-group">
                    <label for="">Ariza raqami</label>
                    {{Form::text('mid', $mauntaineering->mid??null, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                    {{Form::submit(('Saqlash'), ['class' => 'btn btn-primary'])}}
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection


