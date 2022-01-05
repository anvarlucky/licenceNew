<div class="form-group">
    <label for="">Tashkilot INN</label>
    {{Form::text('company_tin', $organization->company_tin??null, ['class' => 'form-control','id'=>'tin'])}}
</div>
<div class="form-group">
    <label for="">Tashkilot nomi</label>
    {{Form::text('company_name', $organization->company_name??null, ['class' => 'form-control','id'=>'acron_uz'])}}
</div>
<div class="form-group">
    <label for="">Tashkilot statusi 1 ni Yozing</label>
    {{Form::text('company_status', $organization->company_status??null, ['class' => 'form-control','id'=>'phone'])}}
</div>
<div class="form-group">
    <label for="">Viloyat</label>
    {{Form::text('region', $organization->region??null, ['class' => 'form-control','id'=>'phone'])}}
</div>
<div class="form-group">
    <label for="">Shahar/Tuman</label>
    {{Form::text('district', $organization->district??null, ['class' => 'form-control','id'=>'phone'])}}
</div>
<div class="form-group">
    <label for="">NS10_CODE</label>
    {{Form::text('company_ns10', $organization->company_ns10??null, ['class' => 'form-control','id'=>'company_ns10'])}}
    {{--Form::select('company_ns10', [__('')]+Arr::pluck($regions,'name_uz','name_uz'),$organization->company_ns10??null, ['class' => 'form-control'])--}}
</div>
<div class="form-group">
    <label for="">NS11_CODE</label>{{Form::text('company_ns11', $organization->company_ns11??null, ['class' => 'form-control','id'=>'company_ns11'])}}
    {{--Form::select('company_ns11', [__('')]+Arr::pluck($districts,'name_uz','name_uz'),$organization->company_ns11??null, ['class' => 'form-control'])--}}
</div>
<div class="form-group">
    <label for="">Tashkilot manzili</label>
    {{Form::text('company_adress', $organization->company_adress??null, ['class' => 'form-control','id'=>'addr'])}}
</div>
<div class="form-group">
    <label for="">Faoliyat turi</label>
    {{Form::textarea('performed_service', $organization->performed_service??null, ['class' => 'form-control'])}}
</div>

