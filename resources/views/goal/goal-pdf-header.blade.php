<!DOCTYPE html>
<html>
    <body>
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        	<tr>
        		<td valign="top">
        			<table cellpadding="0" cellspacing="0" border="0">
        				<tr>
        					<td><font style="font-weight: bold;">GoalTitle:</font> {{$goal_detail->name}}</td>
        				</tr>
        				<tr>
        					<td><font style="font-weight: bold;">Provider:</font> {{$goal_detail->provider->full_name}}</td>
        				</tr>
                        <tr>
                            <td><font style="font-weight: bold;">Participant:</font> {{$goal_detail->participant->full_name}}</td>
                        </tr>
        			</table>
        		</td>
        		<td valign="top">
        			<table cellpadding="0" cellspacing="0" border="0">
	        			<tr>
	    					<td ><font style="font-weight: bold;">Tags:</font> @foreach($goal_detail->tags as $k => $tag)
                                <span>{{ $tag->tag }}</span>@if($k+1 < count($goal_detail->tags)),
                                 @endif
                            @endforeach

                        </td>
	    				</tr>
	    			</table>
        		</td>
        		<td valign="top" align="right">
        			<table cellpadding="0" cellspacing="0" border="0">
	        			<tr>
	    					<td align="right">{{ date('m/d/Y') }}</td>
	    				</tr>
	    				<tr>
        				    <?php $programs = $goal_detail->participant->organization->programs; ?>
                          @if(isset($programs))
                        	<td align="right"><font style="font-weight: bold;">Program:</font>

                           @foreach($programs as $k => $p)
                                <span>{{ $p->name }}</span>@if($k+1 < count($programs)),
                                 @endif
                            @endforeach</td>
                           @endif 
        				</tr>
        				<tr>
        					<td align="right"><font style="font-weight: bold;">Organization:</font>{{$goal_detail->participant->organization->name}}</td>
        				</tr>
	    			</table>
        		</td>
        	</tr>
            <tr>
                <td colspan="3" height="5"></td>
            </tr>
            <tr>
                <td colspan="3" height="1" bgcolor="#cccccc"></td>
            </tr>
            <tr>
                <td colspan="3" height="5"></td>
            </tr>
        </table>
    </body>
</html>