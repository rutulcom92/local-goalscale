@component('mail::message')
<table>
	<tr>
		<th style="text-align:left">Name</th>
		<td>{{ $user->full_name }}</td>
	</tr>
	<tr>
		<th style="text-align:left">Email</th>
		<td>{{ $user->email }}</td>
	</tr>
	<tr>
		<th style="text-align:left">Phone</th>
		<td>{{ maskPhoneInUsFormat($user->phone) }}</td>
	</tr>
    @if(isset($user->organization) && !empty($user->organization))
	<tr>
		<th style="text-align:left">Organization</th>
		<td>{{!empty($user->organization) ? $user->organization->name : null}}</td>
	</tr>
    @endif
	<tr>
		<th style="text-align:left;vertical-align:top;">Message</th>
		<td>{{ $description }}</td>
	</tr>
</table>
<br>
<br>
<p>Thanks,</p>
<p>{{ config('app.name') }}</p>
@endcomponent