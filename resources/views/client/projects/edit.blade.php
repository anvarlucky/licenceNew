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
                {{Form::open(['route' => ['projects.update',$project->id],'method' => 'put'])}}
                @csrf

                <div class="form-group">
                    <label for="">Litsenziya raqami</label>
                    {{Form::text('licence_number', $project->licence_number??'АЛ-', ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                    <label for="">Litsenziya berilgan sana</label>
                    {{Form::date('licence_given_date', $project->licence_given_date??null, ['class' => 'form-control'])}}
                </div>


                <div class="form-group">
                    <label for="">Tashkilot INN</label>
                    {{Form::text('organization_inn', $project->organization_inn??null, ['class' => 'form-control','id'=>'tin'])}}
                </div>
                <div class="form-group">
                    <label for="">Tashkilot nomi</label>
                    {{Form::text('organization_name', $project->organization_name??null, ['class' => 'form-control','id'=>'acron_uz'])}}
                </div>
                <div class="form-group">
                    <label for="">Tashkilot telefon raqami</label>
                    {{Form::text('organization_phone', $project->organization_phone??null, ['class' => 'form-control','id'=>'phone'])}}
                </div>


                {{Form::hidden('organization_account_number', 'null')}}
                <div class="form-group">
                    <label for="">Litsenziya murakkablik darajasi</label>
                    {{Form::select('difficulty_category', [''=>'','I' => 'I', 'II' => 'II', 'III' => 'III', 'IV' => 'IV'], $project->difficulty_category??null,['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                    <label for="">Litsenziya yo'nalishlari</label>
                    {{Form::textarea('license_direction', $project->license_direction??null, ['class' => 'form-control'])}}
                </div>
                <div class="form-check">
                    <label><strong>Yo`nalishlar :</strong></label><br>
                    @foreach($categories as $category)
                            <label class="form-check-label"><input class="form-check-input" id="flexCheckDefault" type="checkbox" name="categories[]" value="{{$category->id}}"@foreach($project->categories as $cat) @if($category->id==$cat->id) checked = 'checked' @endif @endforeach>{{$category->title}}</label><br/>
                    @endforeach
                </div>
                <div class="form-group">
                    <br/>
                    <label for="">Ariza raqami</label>
                    {{Form::text('mid', $project->mid??null, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                    {{Form::submit(('Saqlash'), ['class' => 'btn btn-primary'])}}
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection


