@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="post" action="{!!url('page')!!}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading oh">

                        <div class="preview_panel pull-left">
                            <div class="img_profie pull-left">
                                <img src="{!!$page->profile_path!!}">
                            </div>
                            <div class="profile pull-left">
                                <a class="name">{!!$page->name!!}</a>
                                <input type="hidden" name="page_id" value="{!!$page->page_id!!}">
                                <p class="published_by">Published by Mocha <span class="world">&nbsp;</span></p>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <a href="{!!url('admin_page/new_user/'.$pageId)!!}"  class="btn btn-moca-tran pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> Assign User</a>


                        
                    </div>
                    <div class="clearfix"></div>

                    <div class="panel-body">
                        @if(count($list))
                            <?php $index=1;?>
                            <table class="table table-striped">
                                <tr>
                                    <td>No</td>
                                    <td>Email</td>
                                    <td>Name</td>
                                </tr>
                                @foreach($list as $row)
                                    <tr>
                                        <td>{!!$index!!}</td>
                                        <td>{!!$row->User->email!!}</td>
                                        <td>{!!$row->User->name!!}</td>
                                    </tr>
                                    <?php $index++;?>
                                @endforeach

                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>

    
@endsection
