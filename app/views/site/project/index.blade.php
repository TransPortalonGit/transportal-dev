@extends('layouts.master')

@section('head')
{{HTML::style('/css/project.css')}}
<script type="text/javascript">
    $(document).ready(function() {

        $('.cover-item').click(function(e){
            e.preventDefault();
            window.location = $(this).find('a:first').attr('href');
        });

    });
</script>
@stop

@section ('content')
<div class="shield">
    @include('site/listings/partials/_form-header', ['title' => 'My Projects'])
    @if (Sentry::Check())
    <a href="/project/create" class="btn btn-admin"><i class="icon-plus"></i></a>
    @endif
</div>

@include('site.project.projectlist')

@stop
