<div style="margin-top: 30px">
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <div class="pull-left">
                <form method="GET" id="pagination" title="pagination">
                    <select class="form-control" name="pporder" id="pporder">
                        <option value="" disabled selected>Sort by...</option>
                        <option value="title" @if($sortby == 'title') selected @endif>Alphabetic</option>
                        <option value="created_at" @if($sortby == 'created_at') selected @endif>Most Recent</option>
                        <option value="views" @if($sortby == 'views') selected @endif>Most Viewed</option>
                        <option value="favorite" @if($sortby == 'favorite') selected @endif>Most Popular</option>
                    </select>
                </form>
            </div>
            <div class="pull-right">
                <a href="/project/create">
                    <div class="btn btn-success">
                        Add Project
                    </div>
                </a>
            </div>
        </div>

        <div class="pull-left">

        </div>
        
        <div class="panel-body" style="padding-right: 0">

            <div class="all_projects row" style="margin:0;">
                @foreach($projects as $project)
                                
                          @include('partials._projectpreview')
                  
                @endforeach
            </div>
    
            {{$projects->appends(Request::except('page'))->links();}}
    
        </div>
    </div>
</div>

<script type="text/javascript">

$('#pporder').change(
    function() {
        $('#pagination').trigger('submit');
    });

</script>