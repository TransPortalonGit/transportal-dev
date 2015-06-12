
<div class="row">
    <div class="col-lg-6">
        {{ Form::label('wanted_count', 'How many people do you need?') }}
    </div>
</div>
<div class="row">
    <div class="col-lg-2">
        {{ Form::text('wanted_count', $value = null, ['class'=>'form-control aSpinEdit', 'placeholder'=>'1', 'id' => 'count-spinner']) }}
    </div>
</div>
<div class="row margin-top-7">
    <div class="col-lg-6">
        {{ Form::label('description', 'Specify what kind of help you want') }}
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        {{ Form::textarea('description', $value = null,
        [
        'class'=>'form-control',
        'placeholder'=>'Description',
        'rows'=>'4'
        ]) }}
    </div>
</div>
<div class="row margin-top-7">
    <div class="col-lg-6">
        {{ Form::label('tags', 'Specify skills that are nice to have') }}
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        @include('site.partials.tags-multiple-select')
    </div>
</div>
{{ Form::hidden('project_id', $project->id) }}