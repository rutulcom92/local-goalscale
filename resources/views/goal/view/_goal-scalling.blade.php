 <ul>
	<li>
		<span>4</span>
		<p>{{(!empty($goal_detail->scales()->where('value','4')->first()) ? $goal_detail->scales()->where('value','4')->first()->description : '' )}}</p>
	</li>
	<li>
		<span>3</span>
		<p>{{(!empty($goal_detail->scales()->where('value','3')->first()) ? $goal_detail->scales()->where('value','3')->first()->description : '' )}}</p>
	</li>
	<li>
		<span>2</span>
		<p>{{(!empty($goal_detail->scales()->where('value','2')->first()) ? $goal_detail->scales()->where('value','2')->first()->description : '' )}}</p>
	</li>
	<li>
		<span>1</span>
		<p>{{(!empty($goal_detail->scales()->where('value','1')->first()) ? $goal_detail->scales()->where('value','1')->first()->description : '' )}}</p>
	</li>
	<li>
		<span>0</span>
		<p>{{(!empty($goal_detail->scales()->where('value','0')->first()) ? $goal_detail->scales()->where('value','0')->first()->description : '' )}}</p>
	</li>
</ul>