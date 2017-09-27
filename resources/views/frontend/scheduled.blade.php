@extends('frontend.template')
@section('content')
<div class="container mb70">
	<div class="row">
      <input type="hidden" name="user_id" value="1">
      @if(count($list))
        <?php $index=1;?>
        <?php 
          $currency=json_decode(CURRENCY,true);
        ?>
        @foreach($list as $row)

    			<div class="col-md-4 col-md-offset-4 p0 bg-white" id="{!!'p_'.$index!!}">

    				<div class="timeline">

    					<div class="preview_panel">
    			            <div class="img_profie pull-left">
    			                <img src="{!!$row->Page->profile_path!!}">
    			            </div>
    			            <div class="profile pull-left">
    			                <a class="name">{!!$row->Page->name!!}</a>
    			                <p class="published_by">Scheduled on {!!date('d F Y',strtotime($row->post_date)) !!} - {!!date('h:i:A',strtotime($row->post_time)) !!}   <span class="world">&nbsp;</span></p>
    			            </div>
    			            <div class="clearfix"></div>
    			        </div>

    			        <div class="panel-body pt0 p0">

                          <div class="preview_message">
                             <p class="show-read-more">{!! $row->message!!}</p>
                             @if($row->translate!='')
                             <p class="default">Translate:</p>
                             <p class="show-read-more">{!! $row->translate!!}</p>
                             @endif
                           </div>
                            @if($row->budget > 0)
                              <p class="budget">Budget: <span>{!!$currency[$row->currency]!!} - {!!$row->budget!!}</span></p>
                            @endif
                           <div class="preview-img">
                                <img src="{!!asset($row->image_path)!!}" id="imgpreview">
                                <div class="play {!!$row->type==VIDEO ?'':'dn'!!}"></div>
                           </div>
                          
                  </div>
    				</div>

    			</div>
        <?php $index++; ?>
        @endforeach
      @else
        <div class="n_panel">
        <div class="col-md-4 col-md-offset-4 p0">
          <div class="alert alert-info">
              <p>No Record Found.</p>
          </div>
        </div>
      </div>
      @endif
	</div>
</div>
@endsection