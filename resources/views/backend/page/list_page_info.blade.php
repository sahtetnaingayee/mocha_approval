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

                        <a href="{!!url('admin_page/'.$pageId.'/listview')!!}"  class="btn btn-moca-tran pull-right"><i class="fa fa-list"></i> List View</a>

                        <a href="{!!url('admin_page/'.$pageId)!!}"  class="btn btn-moca-tran pull-right"><i class="fa fa-calendar"></i> Calendar View</a>


                        
                    </div>
                    <div class="clearfix"></div>

                    <div class="panel-body">
                        @if(count($list))
                        <?php $index=1;?>
                        <table class="table">
                            <tr>
                                <td>No</td>
                                <th>Date</th>
                                <td>Type</td>
                                <td>Thumbnail</td>
                                <td>Message</td>
                                <td>Status</td>
                                <td>Action</td>
                            </tr>

                            @foreach($list as $row)
                            <tr>    
                                <td>{!!$index!!}</td>
                                <td>{!!date('d F Y',strtotime($row->post_date))!!} - {!!date("h:i:A",strtotime($row->post_time))!!}</td>
                                <td>
                                    {!!$row->type==PHOTO?'Photo':'Video'!!}
                                </td>
                                <td><img src="{!!asset($row->image_path)!!}" class="img-thumbnail"></td>
                                <td>{!!str_limit($row->message,20)!!}</td>
                                <td>
                                    @if($row->status==APPROVED)
                                        <p class="text-success">Approved</p>
                                    @else
                                        <p class="text-info">Review</p>
                                    @endif

                                    <td><a href="{!!url('admin_page/post/'.$row->page_id.'/'.$row->id)!!}"><i class="fa fa-eye"></i></a></td>

                                </td>
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
