@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="post" action="{!!url('page/basic')!!}" class="frmPage">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading oh">
                        Dashboard
                        <button type="submit" class="btn btn-moca-tran pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                    </div>
                    <div class="clearfix"></div>

                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>No</th>
                                <th>Profile</th>
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
                                    <img src="{!!$row->picture->data->url!!}" class="img-thumbnail">
                                </td>
                                <td>
                                    {!!$row->name!!}
                                </td>
                                <td>
                                     {!!$row->category!!}
                                </td>
                                <td>
                                    @if(isset($row->cover))
                                    <input type="checkbox" name="page[]" value="{!!$row->id.'SHNA'.$row->name.'SHNA'.$row->access_token.'SHNA'.$row->picture->data->url.'SHNA'.$row->cover->source.'SHNA'.$row->category!!}" class="chkPage">
                                    @endif
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
