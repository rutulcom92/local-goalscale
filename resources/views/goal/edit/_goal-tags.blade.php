<ul>
	@foreach($goal_detail->tags as $tag)
		<li>{{ $tag->tag }}</li>
	@endforeach
</ul>