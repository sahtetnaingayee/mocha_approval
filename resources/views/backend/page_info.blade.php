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
                        <a href="{!!url('post/'.$id.'/basic')!!}"  class="btn btn-moca-tran pull-right">+ Assign User</a>
                        
                    </div>
                    <div class="clearfix"></div>

                    <div class="panel-body">
                        <div id="calendar" class="has-toolbar"> </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>

    <link rel="stylesheet" type="text/css" href="{!!asset('/plugins/jquery-ui/jquery-ui.min.css')!!}">
    <script src="{!!asset('/plugins/jquery-ui/jquery-ui.min.js')!!}" type="text/javascript"></script>


    <script src="{!!asset('/plugins/moment.min.js')!!}" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="{!!asset('/plugins/fullcalendar/fullcalendar.min.css')!!}">
    <script src="{!!asset('/plugins/fullcalendar/fullcalendar.min.js')!!}" type="text/javascript"></script>

    <script src="{!!asset('js/bcalendar.js')!!}" type="text/javascript"></script>

    <script type="text/javascript">
    
            var $url='{!!url("postcount/20/20")!!}';
            AppCalendar.init($url); 

    </script>
@endsection
