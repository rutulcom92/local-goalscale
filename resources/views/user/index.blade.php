@extends('layouts.app')

@section('title','WMU | Participant')

@section('content')
<div class="Wrap_all_class">
     <div class="Wrap_all_class_inner">
        <div class="top_filter">
        	<div class="row">
        		<div class="col-sm-3">
        			<h1>Participant</h1>
        		</div>	
        		<div class="col-sm-9">
        			<div class="filter_cls_wmu">
        				<ul>
        					<li class="mrg-left">
        						<a href="<?php echo url('/');?>/user/create" class="btn-cls">Add New Participant</a>
        					</li>
        					<li class="mrg-left wdth">
        						<select class="element_select" data-placeholder="Filter by Provider Type">
        							<option value="">Filter by provider type</option>
        							<option>Provider type 1</option>
        							<option>Provider type 2</option>
        						</select>
        					</li>
        					<li class="mrg-left wdth">
        						<select class="element_select" data-placeholder="Filter by Program">
        							<option value="">Filter by program</option>
        							<option>Program 1</option>
        							<option>Program 2</option>
        						</select>
        					</li>
        					<li class="mrg-left wdth">
        						<select class="element_select" data-placeholder="Filter by Organization">
        							<option value="">Filter by Organization</option>
        							<option>Organization 1</option>
        							<option>Organization 2</option>
        						</select>
        					</li>
        					<li class="mrg-left wdth">
        						<input type="text" placeholder="Search" class="input_clso srch">
        					</li>
        				</ul>
        			</div>
        		</div>	
        	</div>
        </div>
        <div class="for_content_section">
        	<table id="providerslisting" class="table dt-responsive nowrap" style="width:100%">
        		<thead>
        			<tr>
        				<th>&nbsp;</th>
        				<th>First Name</th>
        				<th>Last Name</th>
        				<th># of Goals</th>
        				<th>Last Update</th>
        				<th>Organization</th>
        				<th>Provider</th>
        				<th>Goal Change</th>
        			</tr>
        		</thead>
        		<tbody>
        			<tr>
        				<td><div class="for_user"><img src="{{ asset('images/9.jpg') }}"></div></td>
        				<td>Helen</td>
        				<td>Barton</td>
        				<td>8</td>
        				<td>Sep 15, 2019</td>
        				<td>Bronson Hospital</td>
        				<td class="weth"><div class="for_user"><img src="{{ asset('images/8.jpg') }}"></div><label>Warren Mills</label></td>
        				<td>+3.2</td>
        			</tr>
        			<tr>
        				<td><div class="for_user"><img src="{{ asset('images/9.jpg') }}"></div></td>
        				<td>Helen</td>
        				<td>Barton</td>
        				<td>8</td>
        				<td>Sep 15, 2019</td>
        				<td>Bronson Hospital</td>
        				<td class="weth"><div class="for_user"><img src="{{ asset('images/8.jpg') }}"></div><label>Warren Mills</label></td>
        				<td>+3.2</td>
        			</tr>
        			<tr>
        				<td><div class="for_user"><img src="{{ asset('images/9.jpg') }}"></div></td>
        				<td>Helen</td>
        				<td>Barton</td>
        				<td>8</td>
        				<td>Sep 15, 2019</td>
        				<td>Bronson Hospital</td>
        				<td class="weth"><div class="for_user"><img src="{{ asset('images/8.jpg') }}"></div><label>Warren Mills</label></td>
        				<td>+3.2</td>
        			</tr>
        			<tr>
        				<td><div class="for_user"><img src="{{ asset('images/9.jpg') }}"></div></td>
        				<td>Helen</td>
        				<td>Barton</td>
        				<td>8</td>
        				<td>Sep 15, 2019</td>
        				<td>Bronson Hospital</td>
        				<td class="weth"><div class="for_user"><img src="{{ asset('images/8.jpg') }}"></div><label>Warren Mills</label></td>
        				<td>+3.2</td>
        			</tr>
        			<tr>
        				<td><div class="for_user"><img src="{{ asset('images/9.jpg') }}"></div></td>
        				<td>Helen</td>
        				<td>Barton</td>
        				<td>8</td>
        				<td>Sep 15, 2019</td>
        				<td>Bronson Hospital</td>
        				<td class="weth"><div class="for_user"><img src="{{ asset('images/8.jpg') }}"></div><label>Warren Mills</label></td>
        				<td>+3.2</td>
        			</tr>
        			<tr>
        				<td><div class="for_user"><img src="{{ asset('images/9.jpg') }}"></div></td>
        				<td>Helen</td>
        				<td>Barton</td>
        				<td>8</td>
        				<td>Sep 15, 2019</td>
        				<td>Bronson Hospital</td>
        				<td class="weth"><div class="for_user"><img src="{{ asset('images/8.jpg') }}"></div><label>Warren Mills</label></td>
        				<td>+3.2</td>
        			</tr>
        			<tr>
        				<td><div class="for_user"><img src="{{ asset('images/9.jpg') }}"></div></td>
        				<td>Helen</td>
        				<td>Barton</td>
        				<td>8</td>
        				<td>Sep 15, 2019</td>
        				<td>Bronson Hospital</td>
        				<td class="weth"><div class="for_user"><img src="{{ asset('images/8.jpg') }}"></div><label>Warren Mills</label></td>
        				<td>+3.2</td>
        			</tr>
        			<tr>
        				<td><div class="for_user"><img src="{{ asset('images/9.jpg') }}"></div></td>
        				<td>Helen</td>
        				<td>Barton</td>
        				<td>8</td>
        				<td>Sep 15, 2019</td>
        				<td>Bronson Hospital</td>
        				<td class="weth"><div class="for_user"><img src="{{ asset('images/8.jpg') }}"></div><label>Warren Mills</label></td>
        				<td>+3.2</td>
        			</tr>
                    
        		</tbody>
        	</table>
        </div>
    </div>
</div>
@endsection