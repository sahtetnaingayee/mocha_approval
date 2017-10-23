@extends('frontend.template')
@section('content')
	
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-4 bg-white">
					@if(isset($page_list) && count($page_list))
						@foreach($page_list as $row)
							<div class="panel">
								<div class="panel-body">
									<a href="{!!url('cpage/'.$row->page_id)!!}" class="cPage">
										<img src="{!!$row->Page->profile_path!!}" class="imgProfile pull-left"> 
										<p>{!!$row->Page->name!!}</p>
									</a>
								</div>
								
							</div>
						@endforeach
					@endif
				</div>
			</div>
		</div>
	
@endsection