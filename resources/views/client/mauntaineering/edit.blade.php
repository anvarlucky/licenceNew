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
                    <label for="">Faoliyat turi</label>
                    {{Form::select('type_of_activity1', [''=>'','1' => 'Mudofaa obyektlarini loyihalashtirish, qurish, ulardan foydalanish va ularni tamirlash faoliyatini litsenziyalash', '2' => 'Ko`priklar va tonnellarni loyihalashtirish, qurish, ulardan foydalanish va ularni tamirlash faoliyatini litsenziyalash', '3' => 'Havfi yuqori bo`lgan obyektlarni hamda potensial havfli ishlab chiqarishlarni loyihalashtirish, qurish, ulardan foydalanish va ularni tamirlash faoliyatini litsenziyalash', '4' => 'Balandliklarda sanoat alpinizmi usullarida tamirlash, qurilish-montaj ishlarini bajarish faoliyatini litsenziyalash'], $mauntaineering->type_of_activity??null,['class' => 'form-control','readonly'])}}
                </div>
                <div class="form-group">
                    <label for="">Litsenziya raqami</label>
                    {{Form::text('licence_number', $mauntaineering->licence_number??'ҚВ-', ['class' => 'form-control','readonly'])}}
                </div>
                <div class="form-group">
                    <label for="">Litsenziya berilgan sana</label>
                    {{Form::date('licence_given_date', $mauntaineering->licence_given_date??null, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                    <label for="">Muddati</label>
                    {{Form::date('end_date', $mauntaineering->end_date??null, ['class' => 'form-control'])}}
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
                <div class="form-group">
                    <label for="">Tashkilot e-maili</label>
                    {{Form::text('organization_email', $mauntaineering->organization_email??null, ['class' => 'form-control','id'=>'email'])}}
                </div>
                <div class="form-group">
                    <label for="">Tashkilot manzili</label>
                    {{Form::text('organization_address', $mauntaineering->organization_address??null, ['class' => 'form-control','id'=>'addr'])}}
                </div>
                <div class="form-group">
                    <label for="">Tashkilot rahbari</label>
                    {{Form::text('organization_director', $mauntaineering->organization_director??null, ['class' => 'form-control','id'=>'head_nm'])}}
                </div>
                <div class="form-group">
                    <label for="">Tashkilot Hisob raqami</label>
                    {{Form::text('organization_account_number', $mauntaineering->organization_account_number??null, ['class' => 'form-control','readonly'])}}
                </div>
                <div class="form-group">
                    {{Form::submit(('Saqlash'), ['class' => 'btn btn-primary'])}}
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection

