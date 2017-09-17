@extends('frontend.template')
@section('content')
<div class="container">
	<div class="row">
      <input type="hidden" name="user_id" value="1">
      @if(count($list))
        <?php $index=1;?>
        @foreach($list as $row)

    			<div class="col-md-4 col-md-offset-4 p0 bg-white" id="{!!'p_'.$index!!}">

    				<div class="timeline">

    					<div class="preview_panel">
    			            <div class="img_profie pull-left">
    			                <img src="{!!$row->Page->profile_path!!}">
    			            </div>
    			            <div class="profile pull-left">
    			                <a class="name">{!!$row->Page->name!!}</a>
    			                <p class="published_by">Published by Mocha <span class="world">&nbsp;</span></p>
    			            </div>
    			            <div class="clearfix"></div>
    			        </div>

    			        <div class="panel-body pt0 p0">

                          <div class="preview_message">
                             <p class="show-read-more">{!! $row->message!!}</p>


                           </div>
                           <div class="preview-img">
                                <img src="{!!asset('img/timeline.jpg')!!}" id="imgpreview">
                                <div class="play dn"></div>
                           </div>
                           <div class="action-panel">
                                <ul>
                                    <li>
                                      {!! Form::open(array('url' =>'approve','class'=>'form-horizontal frmArpprove ','files'=>true,'method'=>'post')) !!}
                                      <input type="hidden" name="post_id" value="{!!$row->post_id!!}">
                                      <input type="hidden" name="index" value="{!!$index!!}">
                                      <button type="submit" class="like">
                                        <span> Approve</span>
                                      </button>
                                      {!!Form::close()!!}
                                    </li>
                                    <li>
                                      <a data-toggle="collapse" href="{!!'#collapse'.$index!!}" class="rework">
                                        <span> Rework</span>
                                      </a>
                                    </li>

                                </ul>
                                  <div class="panel b0">
                                    <div id="{!!'collapse'.$index!!}" class="panel-collapse collapse">
                                      <div class="panel-body">
                                          {!! Form::open(array('url' =>'comment','class'=>'form-horizontal frmComment','files'=>true,'method'=>'post')) !!}
                                          <input type="hidden" name="post_id" value="{!!$row->post_id!!}">
                                          <label>Remark *</label>
                                          <textarea class="form-control" name="message" required></textarea>
                                          <button type="submit" class="btn btnSubmit pull-right">Submit</button>
                                           {!!Form::close()!!}
                                      </div>

                                      <div class="comment_panel"> 
                                        <?php 
                                          $comment=$row->Comment;


                                        ?>

                                        @if(count($comment))
                                          @foreach($comment as $c)

                                            @if($c->via==VIA_CLIENT)
                                              <div class="r">
                                                <div class="p_p pull-left pl10">
                                                    <img src="{!!$row->Page->profile_path!!}">
                                                </div>
                                                <div class="p_tx pull-left">
                                                    <p>{!!$c->message!!}</p>

                                                </div>
                                              </div>
                                              <div class="clearfix"></div>
                                            @else
                                              <div class="r">
                                                <div class="p_tx pull-left pl10">
                                                    <p>{!!$c->message!!}</p>

                                                </div>
                                                <div class="p_p pull-left">
                                                    <img src="{!!$row->Page->profile_path!!}">
                                                </div>
                                                
                                              </div>
                                            @endif
                                          @endforeach
                                        @endif
                                      </div>
                                    </div>

                                  </div>
                                
                           </div>
                  </div>
    				</div>

    			</div>
        <?php $index++; ?>
        @endforeach
      @endif
	</div>
</div>
@endsection