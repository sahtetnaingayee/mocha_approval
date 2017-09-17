@extends('layouts.app')

@section('content')
    
    <div class="container">
        
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading oh">
                        New Campaign
                        <a href="{!!url('campaign')!!}"  class="btn btn-moca-tran pull-right"><i class="fa fa-list"></i> Campaign List</a>
                        
                    </div>
                    <div class="clearfix"></div>

                    <div class="panel-body">
                        {!! Form::open(array('url' =>'campaign/basic','class'=>'form-horizontal frmBasic','files'=>true,'method'=>'post')) !!}

                        <input type="hidden" name="hidd_url" value="{!!url('page_post/')!!}">
                        <!-- HEADER TAB -->

                        <ul class="nav nav-tabs campaign-nav" role="tablist">
                            <li role="presentation" class="active" id="li_campaign">
                                <a href="#campaign" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-suitcase" aria-hidden="true"></i> Campaign</a>
                            </li>
                            <li role="presentation" id="li_advert_set">
                                <a href="#advert_set" class="pn" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-th-large" aria-hidden="true"></i> Advert set</a>
                            </li>
                            <li role="presentation" id="li_advert">
                                <a href="#advert" class="pn" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-share-alt" aria-hidden="true"></i> Advert</a>
                            </li>
                        </ul>

                        <!-- END HEADER TAB -->

                        <!-- TAB BODY -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="campaign">
                                <!-- Objective -->
                                <?php
                                    $awareness=json_decode(AWARENESS_OBJECTIVE,true);
                                    $consideration=json_decode(CONSIDERATION_OBJECTIVE,true);
                                    $conversion=json_decode(CONVERSION_OBJECTIVE,true);
                                ?>
                                <div class="form-group page-select">
                                
                                    <div class="col-sm-4">
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="home">
                                                <h4 class="title">Consideration</h4>
                                                @foreach($consideration as $key=>$value)
                                                    <label class="radio-inline"><input type="radio" name="objective" value="{!!$key!!}">{!!$value!!}</label>
                                                    <div class="clearfix"></div>
                                                @endforeach
                                            </div>
                                           
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div role="tabpanel" class="tab-pane" id="profile">
                                            <h4 class="title">Awareness</h4>
                                            @foreach($awareness as $key=>$value)
                                                <label class="radio-inline"><input type="radio" name="objective" value="{!!$key!!}">{!!$value!!}</label>
                                                <div class="clearfix"></div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div role="tabpanel" class="tab-pane" id="messages">
                                            <h4 class="title">Conversion</h4>
                                            @foreach($conversion as $key=>$value)
                                                <label class="radio-inline"><input type="radio" name="objective" value="{!!$key!!}">{!!$value!!}</label>
                                                <div class="clearfix"></div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!-- End Objective -->

                                <div class="form-group">
                                    <div class="col-md-7 col-md-offset-4">
                                        <button type="button" class="btn btn-moca pull-right" id="btn_campaign">Continue</button>
                                    </div>
                                </div>
                            </div>

                            <!-- SECOND -->
                            <div role="tabpanel" class="tab-pane" id="advert_set">
                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-3">
                                        <h4>Campaign</h4>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Campaign Name <span class="mandatory">*</span>:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="campaign_name" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Advert set name  <span class="mandatory">*</span>:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="adset_name" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-3">
                                        <h4>Audience</h4>
                                    </div>
                                </div>

                                <div class="form-group page-select">
                                    <label class="control-label col-sm-3" for="email">Locations:</label>

                                    <?php
                                        $countries=json_decode(COUNTRIES,true);
                                    ?>
                                    <div class="col-sm-8">  
                                        {!! Form::select('countries',$countries,null,['class' => 'form-control select2']) !!}
                                        
                                    </div>
                                </div>

                                <div class="form-group page-select">
                                    <label class="control-label col-sm-3" for="email">Age:</label>
                                    <?php 
                                        $min_age=json_decode(MIN_AGE,true);
                                        $max_age=json_decode(MAX_AGE,true);
                                    ?>
                                    <div class="col-sm-2">
                                        {!! Form::select('age_min',$min_age,18,['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-sm-2">
                                        {!! Form::select('age_max',$max_age,65,['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group page-select">
                                    <label class="control-label col-sm-3" for="email">Gender:</label>
                                    <div class="col-sm-8">
                                        <label class="radio-inline"><input type="radio" name="gender" checked value="0">All</label>
                                        <label class="radio-inline"><input type="radio" name="gender" value="1">Men</label>
                                        <label class="radio-inline"><input type="radio" name="gender" value="2">Women</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-3">
                                        <h4>Budget & schedule</h4>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Budget:</label>
                                    <div class="col-md-3 pr5">
                                        <select class="form-control" name="budget_type">
                                            <option value="10">Daily Budget</option>
                                            <option value="20">Lieftime Budget</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2 pl0">
                                        <input type="text" value="1" name="budget" onkeydown="return numberOnly(event);" class="form-control" required>
                                    </div>
                                    <div class="col-sm-1 p0">
                                        <label class="lbl_currency">USD</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Schedule:</label>
                                    <div class="col-sm-8">
                                        <div class="schedule_type_panel">
                                            <label class="radio"><input type="radio" name="schedule" checked value="10">Run my advert set continuously starting today</label>
                                            <label class="radio"><input type="radio" name="schedule" value="20">Set a start and end date</label>
                                        </div>
                                        
                                    </div>
                                    
                                </div>

                                <div class="form-group dn" id="schedule_panel">
                                    <label class="control-label col-sm-1 col-md-offset-3" for="email">Start:</label>
                                    <div class="col-md-3 ">
                                        <div class="input-group date" id="sandbox-container" data-provide="datepicker">
                                            <input type="text" class="form-control datep" name="start_date" value="{!!date('Y-m-d')!!}">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group bootstrap-timepicker timepicker">
                                            <input id="timepicker1" type="text" name="start_time" class="form-control input-small" value="{!!date('h:i A')!!}">

                                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                        </div>
                                    </div>
                                    <div class="clearfix mt10"></div>

                                     <label class="control-label col-sm-1 col-md-offset-3" for="email">End:</label>
                                    <div class="col-md-3 mt10">
                                        <div class="input-group date" id="sandbox-container" data-provide="datepicker">
                                            <input type="text" class="form-control datep" name="end_date" value="{!!date('Y-m-d')!!}">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt10">
                                        <div class="input-group bootstrap-timepicker timepicker">
                                            <input id="timepicker1" type="text" name="end_time" class="form-control input-small" value="{!!date('h:i A')!!}">

                                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                        </div>
                                    </div>

            
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Optimisation for advert delivery:</label>
                                    <div class="col-sm-8">
                                        <?php 
                                            $optimisation=json_decode(OPTIMISATION,true);
                                        ?>
                                        {!! Form::select('optimisation',$optimisation,65,['class' => 'form-control']) !!} 
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-default" id="btn_back_advert_set">Back</button>
                                    </div>
                                    <div class="col-md-7">

                                        <button type="button" class="btn btn-moca pull-right" id="btn_adver_set">Confirm</button>
                                    </div>
                                </div>

                            </div>
                            <!--- END SECOND -->

                            <!-- START THIRD -->
                            <div role="tabpanel" class="tab-pane" id="advert">

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Advert Name  <span class="mandatory">*</span>:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="ad_name" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group page-select">
                                    <label class="control-label col-sm-3" for="email">Page:</label>
                                    <div class="col-sm-8">
                                        {!! Form::select('page_id',$page,null,['class' => 'form-control select2']) !!}

                                    </div>
                                </div>

                                <div class="form-group post-select">
                                    <label class="control-label col-sm-3" for="email">Post:</label>
                                    <div class="col-sm-8">
                                        {!! Form::select('post_id',$post,null,['class' => 'form-control select2','id'=>'sub_category']) !!}

                                    </div>
                                </div>

                               

                                


                                <div class="form-group">
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-default" id="btn_back_advert">Back</>
                                    </div>
                                    <div class="col-md-7">
                                        <button type="submit" class="btn btn-moca btn-confirm pull-right">Confirm</button>
                                    </div>
                                </div>
                            </div>

                            <!-- END THIRD -->
                           
                        </div>
                        <!-- END TAB BODY -->
                    

                        </form>
                
                    </div>
                </div>
            </div>
        
            <!-- End Preview Panel -->
        </div>
      
    </div>

    <!-- Date Picker -->
    
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <link rel="stylesheet" type="text/css" href="{!!asset('plugins/datepicker/css/bootstrap-datepicker.min.css')!!}">
    <script type="text/javascript" src="{!!asset('plugins/datepicker/js/bootstrap-datepicker.js')!!}"></script>

    <!-- Select2 -->
    <link rel="stylesheet" type="text/css" href="{!!asset('plugins/select2/css/select2.min.css')!!}">
    <script type="text/javascript" src="{!!asset('plugins/select2/js/select2.min.js')!!}"></script>


    <!-- Time Picker -->

    <link rel="stylesheet" type="text/css" href="{!!asset('plugins/timepicker/css/bootstrap-timepicker.min.css')!!}">
    <script type="text/javascript" src="{!!asset('plugins/timepicker/js/bootstrap-timepicker.min.js')!!}"></script>


    <link rel="stylesheet" type="text/css" href="{!!asset('plugins/fileinput/css/fileinput.min.css')!!}">

    <style type="text/css">
        .select2-container--default{
            width:100% !important;
        }
    </style>
    <script type="text/javascript" src="{!!asset('plugins/fileinput/js/fileinput.js')!!}"></script>
    <script>

        $('.post-select .select2').select2({

            placeholder: "Select Post",
               
        });

       $('.page-select .select2').select2({
                placeholder: "Select",
               
        }).on("change",function(e){

            var page_id=$(this).val();

            /* GETTING POST */

            var url=$("input[name='hidd_url']").val();


            $.ajax({

                type:"GET",
                url: url+"/"+page_id,
                dataType:"json",

                success: function(data) {

                    if (data.success) {

                        var $sub_category = $('#sub_category');
                        $sub_category.empty();

                        $sub_category.append("<option></option>");

                        $.each(data.data, function(key, value) {
                            $sub_category.append("<option value='" + key + "'>" + value + "</option>");
                        });

                    }
                }
            });

        });
    </script>
    
@endsection
