@extends('layouts.mainDiyor')
@section('content')
    <div class="container-fluid p-5">
        <div class="col-md-12 px-0 table-box">
            <div class="table-top-panel border-bottom d-flex align-items-center justify-content-between px-5 pt-5 pb-4">
                <p class="account-title mb-2">Litsenziya Vaqtincha to`xtatish</p>
            </div>
            @if(session('message'))
                <div class="alert alert-danger">
                    {{session('message')}}
                </div>
            @endif
            <div class="form-group col-md-12">
                {{Form::open(['route' => ['decision1',$expertice->id],'method' => 'put'])}}
                @csrf
                <div class="form-group">
                    <label for="">Buyruq chiqqan sana</label>
                    {{Form::date('decision_start_date', $expertice->decision_start_date??null, ['class' => 'form-control'])}}
                </div><div class="form-group">
                    <label for="">Buyruq raqami</label>
                    {{Form::text('decision_number', $expertice->decision_number??null, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                    {{Form::submit(('Saqlash'), ['class' => 'btn btn-primary'])}}
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection