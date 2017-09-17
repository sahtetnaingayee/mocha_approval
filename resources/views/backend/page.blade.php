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
                            <a href="{!!url('page/'.$row->page_id.'/post')!!}" class="btn btn-moca">Select</a>
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
