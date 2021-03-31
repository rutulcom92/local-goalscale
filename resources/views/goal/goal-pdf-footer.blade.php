<!DOCTYPE html>
<html>
<head>
    <script>
function subst() {
  var vars={};
  var x=document.location.search.substring(1).split('&');
  for(var i in x) {var z=x[i].split('=',2);vars[z[0]] = unescape(z[1]);}
  var x=['frompage','topage','page','webpage','section','subsection','subsubsection'];
  for(var i in x) {
    var y = document.getElementsByClassName(x[i]);
    for(var j=0; j<y.length; ++j) y[j].textContent = vars[x[i]];
  }
}
</script>
</head>
    <body onload="subst()">      
         <table width="100%" cellpadding="0" cellspacing="0" border="0">        	
            
            <tr>
                <td height="1" bgcolor="#cccccc"></td>
            </tr>
            <tr>
                <td style="line-height: 40px;text-align: center;"><span>&copy; {{config('constants.FOOTER_APP_NAME')}} {{date('Y')}}</span>
                <span style="text-align: right; float: right;"><span class="page"></span> of <span class="topage"></span></span></td>
            </tr>
        </table>
    </body>
</html>