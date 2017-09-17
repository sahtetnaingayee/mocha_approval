@extends('layouts.app')

@section('content')
    
    <div class="container">
        
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading oh">

                        <a href="{!!url('campaign/basic')!!}"  class="btn btn-moca-tran  pull-right">+ New Campaign</a>
                        
                    </div>
                    <div class="clearfix"></div>

                    <div class="panel-body">
                        @if(isset($list) && count($list))
                        <table>
                                
                        </table>
                        @else
                            <div class="alert alert-info">There is no campaign yet.</div>
                        @endif
                    </div>
                </div>
            </div>
        
            <!-- End Preview Panel -->
        </div>
      
    </div>

@endsection
