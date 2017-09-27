@if($info->via==VIA_CLIENT)
<div class="r">
  <div class="p_p pull-left pl10">
    <img src="{!!$row->Page->profile_path!!}">
  </div>
  <div class="p_tx pull-left">
    <p>{!!$info->message!!}</p>
  </div>
</div>
<div class="clearfix"></div>
@else
<div class="r">
  <div class="p_tx pull-left pl10">
    <p class="text-right">{!!$info->message!!}</p>

  </div>
  <div class="p_p pull-left">
    <img src="{!!asset('img/icon/mocha.png')!!}">
  </div>

</div>
@endif