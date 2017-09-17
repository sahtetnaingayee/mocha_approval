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
                                <p class="published_by">Published by Mocha <span class="world">&nbsp;</span></p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <a href="{!!url('campaign/')!!}"  class="btn btn-moca-tran pull-right">+ Campaign</a>

                        <a href="{!!url('post/'.$id.'/basic')!!}"  class="btn btn-moca-tran pull-right">+ New Post</a>
                        
                    </div>
                    <div class="clearfix"></div>

                    <div class="panel-body">
                        @if(count($list))
                        <table class="table">
                            <tr>
                                <th>No</th>
                                <th>Thumbnail</th>
                                <th>Message</th>
                                <th>Type</th>
                                <th>Published</th>
                            </tr>
                            <?php $index=1;?>
                            @foreach($list as $row)
                            <tr>
                                <td>
                                    {!!$index!!}
                                </td>
                                <td>
                                    <img src="{!!$row->image_path!!}" class="img-thumbnail">
                                </td>
                                <td>
                                    {!!str_limit($row->message,100,'...')!!}
                                </td>
                                <td>
                                    @if($row->type=="photo")
                                        <img src="{!!asset('img/icon/photo.png')!!}" class="img-post-type">
                                    @endif

                                </td>
                               
                                <td>
                                    @if($row->is_published==1)
                                        <i class="fa fa-check-circle text-success" aria-hidden="true"></i>
                                    @endif
                                </td>
                            </tr>
                            <?php $index++;?>
                            @endforeach
                        </table>
                        @else
                        <div class="alert alert-info">No Record Found.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
