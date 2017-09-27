@extends('layouts.app')

@section('content')
        

    <div class="container">
          
        <div class="row">
            <div class="col-md-6">
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
                        <a href="{!!url('admin_page/'.$pageId.'')!!}"  class="btn btn-moca-tran pull-right"><i class="fa fa-list"></i> Post List</a>
                        
                    </div>
                    <div class="clearfix"></div>

                    <div class="panel-body">
                        {!! Form::open(array('url' =>'admin_post/'.$pageId.'/basic','class'=>'form-horizontal frmBasic','files'=>true,'method'=>'post')) !!}

                            <input type="hidden" name="date" value="{!!$date!!}">
                            <input type="hidden" name="id" value="0">

                            <div class="form-group radio-selector">
                                <label class="control-label col-sm-2" for="email">Date:</label>
                                <div class="col-md-8">
                                  <label class="col-sm-8 pt10" for="email">{!!date('d F Y',strtotime($date))!!}</label>
                                </div>
                            </div>

                            <div class="form-group radio-selector">
                                <label class="control-label col-sm-2" for="email">Type:</label>
                                <div class="col-md-8">
                                    <input type="radio" id="photo" name="post_type" value="{!!PHOTO!!}" required>
                                    <label class="drinkcard-cc p-photo" for="photo"></label>

                                    <input id="video" type="radio"  name="post_type" value="{!!VIDEO!!}">
                                    <label class="drinkcard-cc p-video" for="video"></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2" for="email">Message:</label>
                                <div class="col-sm-9">
                                    <textarea class='autoExpand form-control new-message' name="message" rows='3' data-min-rows='3' placeholder="What's is your mind, {!!Auth::user()->name!!}?" required></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2" for="email">Translate:</label>
                                <div class="col-sm-9">
                                    <textarea class='form-control autoExpand1 message' name="translate" rows='3' data-min-rows='3'  placeholder="Translate"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2" for="email"><span id="label">Photo:</span></label>
                                <div class="col-sm-8">
                                    <input id="file-0a" class="file" type="file" id="imgPhoto" name="file" multiple data-min-file-count="0" required accept="image/*">

                                    <p class="standard-label dn">Standard: 1200px x 675px</p>
                                </div>
        
                            </div>

                            <div class="form-group" id="schedule-panel">
                                <label class="control-label col-sm-2" for="email"><span>Time:</span></label>
                                <div class="col-md-4">
                                    <div class="input-group bootstrap-timepicker timepicker">
                                        <input id="timepicker1" type="text" name="time" class="form-control input-small" value="{!!date('h:i A')!!}">

                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                </div>
        
                            </div>



                            <div class="form-group">
                                <label class="control-label col-sm-2" for="email">Currency:</label>
                                <div class="col-sm-2">
                                    <select name="currency" class="form-control">
                                        <option value="1">USD</option>
                                        <option value="2">THB</option>
                                        <option value="3">MMK</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="budget" class="form-control" placeholder="0" onkeydown="return numberOnly(event);">
                                </div>
                            </div>

                            <div class="form-group"> 

                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btnSubmit">Submit</button>
                                </div>
                            </div>
                        </form>
                
                    </div>
                </div>
            </div>

            <!-- Preview Panel -->
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading bb0 pb0">

                        <div class="preview_panel mb-panel">
                            <div class="img_profie mb-profile pull-left">
                                <img src="{!!$page->profile_path!!}" class="img-profile">
                            </div>
                            <div class="profile pull-left">
                                <a class="name">{!!$page->name!!}</a>
                                <p class="published_by">Post on {!!$date!!} <span class="world">&nbsp;</span></p>
                            </div>
                            <div class="clearfix"></div>

                            <div class="panel-body pt0 p0">
                               <div class="preview_message"></div>
                               <div class="translate_message"><p class="default">Translate:</p><p class="msg"></p></div>
                               <div class="preview-img">
                                    <img src="#" id="imgpreview">
                                    <div class="play dn"></div>
                               </div>
                               <div class="action-panel">
                                    <ul>
                                        <li>
                                            <span class="like"></span><span> Like</span>
                                        </li>
                                        <li>
                                            <span class="comment"></span><span> Comment</span>
                                        </li>
                                        <li>
                                            <span class="share"></span><span> Share</span>
                                        </li>
                                    </ul>
                               </div>
                            </div>
                        </div>

                    </div>
                    
                </div>
            </div>
            <!-- End Preview Panel -->
        </div>
      
    </div>

   
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <link rel="stylesheet" type="text/css" href="{!!asset('plugins/timepicker/css/bootstrap-timepicker.min.css')!!}">
    <script type="text/javascript" src="{!!asset('plugins/timepicker/js/bootstrap-timepicker.min.js')!!}"></script>
     <script>
        $('#timepicker1').timepicker();
    </script>
   

    <style type="text/css">
        #main-video {
            display: none;
            max-width: 400px;
        }
    </style>
@endsection
