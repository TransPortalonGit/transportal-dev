@extends('layouts.master')

@section('content')
<script type="text/javascript">
    $(document).ready(function(){
        $('#delete-wanted').click(function(e){
            e.preventDefault();
            bootbox.confirm("<h3>Do you really want to delete the wanted entry for '{{ $project->title }}'?</h3>", function(isOk) {
                if (isOk) {
                    $("#delete-wanted").submit();
                }
            });
        });
    });
</script>

<h4>Edit the Wanted for '<a href="/project/{{ $project->id }}">{{ $project->title }}</a>'</h4>
<hr>
<div id="edit-wanted">
    {{ Form::model($wanted, array('route' => array('wanted.update', $wanted->id), 'method' => 'PUT')) }}
    @include('site.wanted.form')
    <div class="row margin-top-15">
        <div class="col-lg-2">
            <button type="submit" class="btn btn-primary border-radius-0 border-0"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
    {{ Form::close() }}
    <hr>
    {{ Form::model($wanted, array('route' => array('wanted.destroy', $wanted->id), 'method' => 'DELETE', 'id' => 'delete-wanted')) }}
    <button type="submit" class="btn btn-danger border-radius-0 border-0">
        <i class="fa fa-plus fa-rotate-45"></i> Delete
    </button>
    {{ Form::close() }}
</div>

@stop