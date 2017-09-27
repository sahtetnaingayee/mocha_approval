@extends('layouts.app')

@section('content')
    <div class="container">
       
        
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
                        <div class="col-md-6">
                        @include('flash::message')

                        {!! Form::open(array('url' =>'admin_page/new_user/'.$pageId,'class'=>'form-horizontal frmBasic','files'=>true,'method'=>'post','autocomplete'=>'off')) !!}


                            <div class="form-group oh">
                                <label class="control-label col-sm-2" for="email">Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group oh">
                                <label class="control-label col-sm-2" for="email">Email:</label>
                                <div class="col-sm-9">
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group oh">
                                <label class="control-label col-sm-2" for="email">Password:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="password" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group"> 

                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btnSubmit">Submit</button>
                                </div>
                            </div>
                        {!!Form::close()!!}
                    </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>

    
@endsection
