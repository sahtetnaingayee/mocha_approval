@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="post" action="{!!url('page')!!}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Listed Page
                        
                    </div>
                    <div class="clearfix"></div>

                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                            <?php $index=1;?>
                            @foreach($list as $row)
                            <tr>
                                <td>
                                    {!!$index!!}
                                </td>
                                <td>
                                    {!!$row->name!!}
                                </td>
                                <td>
                                    <img src="{!!$row->profile_path!!}" class="img-responsive">
                                </td>
                                <td>
                                    <a href="{!!url('page/'.$row->id.'/post')!!}" class="btn btn-success btn-xs">Select</a>
                                </td>
                            </tr>
                            <?php $index++;?>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
