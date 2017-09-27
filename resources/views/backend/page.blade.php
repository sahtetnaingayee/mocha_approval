@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="post" action="{!!url('page')!!}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading oh">
                        Dashboard
                        <a href="{!!url('page/basic')!!}" class="btn btn-moca-tran pull-right">+ Add Page</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <?php $index=1;?>
            @foreach($list as $row)
                <div class="col-md-4">
                    <div class="cover-panel">
                        <img src="{!!$row->cover_path!!}" class="img-responsive img-cover">

                        <div class="profile-panel">
                            <img src="{!!$row->profile_path!!}" class="img-responsive">
                        </div>

                        <h3>{!!$row->name!!}</h3>

                        <div class="d-panel">
                            <a href="{!!url('admin_page/user/'.$row->page_id)!!}" class="btn btn-moca"><i class="fa fa-plus-circle" aria-hidden="true"></i> User</a>

                            <a href="{!!url('admin_page/'.$row->page_id)!!}" class="btn btn-moca"><i class="fa fa-list"></i> Posts</a>
                            
                        </div>
                    </div>
                </div>
                @if($index%3==0)
                    <div class="clearfix"></div>
                @endif
            <?php $index++;?>
            @endforeach
        </div>
        </form>
    </div>
@endsection
