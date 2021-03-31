<meta http-equiv='Content-Type' content='text/html' charset="UTF-8">
<style type="text/css">
   @page { margin: 0 5px;padding: 0; }
   text-rendering: optimizeLegibility;
   @import url('https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;300;400;600;700;900&display=swap');
    body,
   th,
   td {
   font-family: 'EmojiSymbols','Source Sans Pro', sans-serif;
  /* display: "inline-block";*/
   /*page-break-before: avoid;*/
   }  

   img {
   max-width: 100%;
   height: auto;
   }
  /* tr{
       page-break-before: avoid;
       display: "inline-block";

   }*/
</style>

<table width="100%" cellspacing="0" cellpadding="0">
   <tr>
      <td>
         <table width="100%" cellpadding="5" cellspacing="0" border="0" style="border: 1px solid #ccc; table-layout:fixed;">
            <tr>
               <td>{!! $goalGraph !!}</td>
               </td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td style="height:15px; line-height: 15px">&nbsp;</td>
   </tr>
   <tr>
      <td>
         <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
               <td valign="top" width="40%">
                  <table width="100%" cellpadding="10" cellspacing="0" border="0" style="border: 1px solid #ccc;">
                     <tr>
                        <td width="100%">
                           <table width="100%" cellpadding="0" cellspacing="0">
                              <tr>
                                 <td style="font-size: 13px; color: #000;">Scaling</td>
                              </tr>
                              <tr>
                                 <td style="height:10px; line-height: 10px;">&nbsp;</td>
                              </tr>
                              <tr>
                                 <td width="100%">
                                    <table width="100%" cellpadding="10" cellspacing="0" border="0" style="border: 1px solid #ccc;">
                                       <tr>
                                          <td>
                                             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="">
                                                <tr>
                                                   <td valign="top" width="4%" style="color: #446cfe; font-weight: bold; font-size: 13px;">4</td>
                                                   <td valign="top" width="1%" style="color: #446cfe; font-weight: bold; font-size: 13px;">&nbsp;</td>
                                                   <td valign="top" width="95%" style="font-size: 13px; color: #2E2F30;">{{(!empty($goal_detail->scales()->where('value','4')->first()) ? $goal_detail->scales()->where('value','4')->first()->description : '' )}}</td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td style="height:10px; line-height: 10px;">&nbsp;</td>
                              </tr>
                              <tr>
                                 <td width="100%">
                                    <table width="100%" cellpadding="10" cellspacing="0" border="0" style="border: 1px solid #ccc;">
                                       <tr>
                                          <td>
                                             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="">
                                                <tr>
                                                   <td valign="top" width="4%" style="color: #446cfe; font-weight: bold; font-size: 13px;">3</td>
                                                   <td valign="top" width="1%" style="color: #446cfe; font-weight: bold; font-size: 13px;">&nbsp;</td>
                                                   <td valign="top" width="95%" style="font-size: 13px; color: #2E2F30;">{{(!empty($goal_detail->scales()->where('value','3')->first()) ? $goal_detail->scales()->where('value','3')->first()->description : '' )}}</td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td style="height:10px; line-height: 10px;">&nbsp;</td>
                              </tr>
                              <tr>
                                 <td width="100%">
                                    <table width="100%" cellpadding="10" cellspacing="0" border="0" style="border: 1px solid #ccc;">
                                       <tr>
                                          <td>
                                             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="">
                                                <tr>
                                                   <td valign="top" width="4%" style="color: #446cfe; font-weight: bold; font-size: 13px;">2</td>
                                                   <td valign="top" width="1%" style="color: #446cfe; font-weight: bold; font-size: 13px;">&nbsp;</td>
                                                   <td valign="top" width="95%" style="font-size: 13px; color: #2E2F30;">{{(!empty($goal_detail->scales()->where('value','2')->first()) ? $goal_detail->scales()->where('value','2')->first()->description : '' )}}</td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td style="height:10px; line-height: 10px;">&nbsp;</td>
                              </tr>
                              <tr>
                                 <td width="100%">
                                    <table width="100%" cellpadding="10" cellspacing="0" border="0" style="border: 1px solid #ccc;">
                                       <tr>
                                          <td>
                                             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="">
                                                <tr>
                                                   <td valign="top" width="4%" style="color: #446cfe; font-weight: bold; font-size: 13px;">1</td>
                                                   <td valign="top" width="1%" style="color: #446cfe; font-weight: bold; font-size: 13px;">&nbsp;</td>
                                                   <td valign="top" width="95%" style="font-size: 13px; color: #2E2F30;">{{(!empty($goal_detail->scales()->where('value','1')->first()) ? $goal_detail->scales()->where('value','1')->first()->description : '' )}}</td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                               <tr>
                                 <td style="height:10px; line-height: 10px;">&nbsp;</td>
                              </tr>
                              <tr>
                                 <td width="100%">
                                    <table width="100%" cellpadding="10" cellspacing="0" border="0" style="border: 1px solid #ccc;">
                                       <tr>
                                          <td>
                                             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="">
                                                <tr>
                                                   <td valign="top" width="4%" style="color: #446cfe; font-weight: bold; font-size: 13px;">0</td>
                                                   <td valign="top" width="1%" style="color: #446cfe; font-weight: bold; font-size: 13px;">&nbsp;</td>
                                                   <td valign="top" width="95%" style="font-size: 13px; color: #2E2F30;">{{(!empty($goal_detail->scales()->where('value','0')->first()) ? $goal_detail->scales()->where('value','0')->first()->description : '' )}}</td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>
               </td>
               <td valign="top" width="2%">&nbsp;</td>
               <td valign="top" width="58%">
                  <table width="100%" cellpadding="10" cellspacing="0" border="0" style="border: 1px solid #ccc;">
                     <tr>
                        <td width="100%">
                           <table width="100%" cellpadding="0" cellspacing="0">
                              <tr>
                                 <td style="font-size: 13px; color: #000;">Activity</td>
                              </tr>
                              <tr>
                                 <td style="height:10px; line-height: 10px;">&nbsp;</td>
                              </tr>
                              <tr>
                                 <td style="height:5px; line-height: 5px;">&nbsp;</td>
                              </tr>
                              <tr>
                                 <td width="100%" style="border-bottom: 1px solid #C0C0C0"></td>
                              </tr>
                              <tr>
                                 <td style="height:10px; line-height: 15px;">&nbsp;</td>
                              </tr>

                              @foreach($activities as $activity)
                              <tr>
                                 <td width="100%">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-bottom: 1px solid #C0C0C0;">
                                       <tr>
                                          <td valign="top" width="72%" align="left">
                                             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="table-layout:fixed;">
                                                <tr>
                                                   <td valign="top" width="10%"> <img style="width: 40px;" src="{{ asset('images/pdf-av.png') }}"> </td>
                                                   <td valign="top" width="2%"></td>
                                                   <td valign="top" width="83%">
                                                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                         <tr>
                                                            <td width="100%">
                                                               <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                  <tr>
                                                                    
                                                                     <td style="font-size: 11px;  color: #FA6400 ;">{{$activity->owner->userType->name}}</td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td style="font-size: 11px; color: #2E2F30;">{{$activity->owner->full_name}} <i style="color: #949494;">{{$activity->date_of_activity}}</i></td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td style="font-size: 12px; padding: 5px 0; color: #2E2F30;"><i>{{$activity->update_text}}</i></td>
                                                                  </tr>
                                                               </table>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td style="height: 5px; line-height: 5px;">&nbsp;</td>
                                                         </tr>
                                                         @if(count($activity->attachments) > 0)
                                                         <tr>
                                                            <td width="100%">
                                                               <table width="100%" cellpadding="0" cellspacing="0" border="0" style="table-layout:fixed;">
                                                                  <tr>

                                                                     <td style="font-size: 11px; color: #949494;">Attachments</td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td style="height: 5px; line-height: 5px;">&nbsp;</td>
                                                                  </tr>
                                                                  <tr>
                                               @foreach($activity->attachments as $attachment)
                                               <?php echo "ccc = ".$attachment->namestorage; exit;?>
									@if(in_array(mime_content_type($attachment->namestorage),config('constants.image_mimes')))
                                  <td> <img src="{{ $attachment->name }}"></td>
                                    @else
                                       <td style="width: 100%"><a href="{{ $attachment->name }}">{{ $attachment->filename }}</a></td>
																@endif
															@endforeach
                                             </tr>
                                                  <tr>
                                                      <td style="height: 10px; line-height: 10px;">&nbsp;</td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td width="100%">
                                                                        <table width="100%" cellpadding="0" cellspacing="0" border="0"> </table>
                                                                     </td>
                                                                  </tr>
                                                               </table>
                                                            </td>
                                                         </tr>
                                                         @endif
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td style="height:10px; line-height: 15px;">&nbsp;</td>
                                                </tr>
                                             </table>
                                          </td>
                                          <td valign="top" width="28%" align="right">
                                             <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                   <td align="center" style="font-size: 10px; color: #949494; font-weight: bold;">Updated Progress</td>
                                                </tr>
                                                <tr>
                                                   <td style="height:5px; line-height: 5px;">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                   <td align="center" width="100%" style="text-align: center;"><span style="width: 30px; margin: 0 auto; display: inline-block; height: 30px; line-height: 30px; background: #fde1d1; color: #FA6400; text-decoration: none; font-size: 13px; text-align: center; border: 1px solid #fde1d1;">{{$activity->activity_ranking}}</span></td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td style="height:15px; line-height: 15px;">&nbsp;</td>
                              </tr>
                             
                              @foreach($activity->childActivities()->get() as $child)
                              <tr>
                                 <td width="100%">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-bottom: 1px solid #C0C0C0; padding-left: 50px;">
                                       <tr>
                                          <td valign="top" width="72%" align="left">
                                             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="table-layout:fixed;">
                                                <tr>
                                                   <td valign="top" width="8%"> <img style="width: 40px; height: 40px; border-radius:40px;" src="{{ $child->owner->image }}"> </td>
                                                   <td valign="top" width="2%"></td>
                                                   <td valign="top" width="83%">
                                                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                         <tr>
                                                            <td width="100%">
                                                               <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                  <tr>
                                                                     <td style="font-size: 11px; color: #FA6400;">{{$child->owner->userType->name}}</td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td style="font-size: 11px; color: #2E2F30;">{{$child->owner->full_name}} <i style="color: #949494;">{{$child->date_of_activity}}</i></td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td style="font-size: 12px; padding: 5px 0; color: #2E2F30;"><i>{{$child->update_text}}</i></td>
                                                                  </tr>
                                                               </table>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td style="height: 5px; line-height: 5px;">&nbsp;</td>
                                                         </tr>
                                                         @if(count($child->attachments) > 0)
                                                         <tr>
                                                            <td width="100%">
                                                               <table width="100%" cellpadding="0" cellspacing="0" border="0" style="table-layout:fixed;">
                                                                  <tr>

                                                                     <td style="font-size: 11px; color: #949494;">Attachments</td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td style="height: 5px; line-height: 5px;">&nbsp;</td>
                                                                  </tr>
                                                                  <tr>
                           @foreach($child->attachments as $attachment)
									@if(in_array(mime_content_type($attachment->namestorage),config('constants.image_mimes')))
                                   <td><img  width="100" height="100" src="{{ $attachment->name }}"> </td>
                                        @else
                                        <td style="width: 100%"><a href="{{ $attachment->name }}">{{ $attachment->filename }}</a></td>
																@endif
															@endforeach
                                            </tr>
                                        <tr>
                                          <td style="height: 10px; line-height: 10px;">&nbsp;</td>
                                          </tr>
                                           <tr>
                                                <td width="100%">
                                                       <table width="100%" cellpadding="0" cellspacing="0" border="0"> </table>
                                                                     </td>
                                                                  </tr>
                                                               </table>
                                                            </td>
                                                         </tr>
                                                         @endif
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td style="height:10px; line-height: 15px;">&nbsp;</td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td style="height:15px; line-height: 15px;">&nbsp;</td>
                              </tr>
                              @endforeach
                              @endforeach
                             <!--  <tr>
                                 <td width="100%">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-bottom: 1px solid #C0C0C0;">
                                       <tr>
                                          <td valign="top" width="72%" align="left">
                                             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="table-layout:fixed;">
                                                <tr>
                                                   <td valign="top" width="15%"> <img style="width: 40px;" src="{{ asset('images/pdf-av.png') }}"> </td>
                                                   <td valign="top" width="2%"></td>
                                                   <td valign="top" width="83%">
                                                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                         <tr>
                                                            <td width="100%">
                                                               <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                  <tr>
                                                                     <td style="font-size: 11px; color: #FA6400;">Supervisor</td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td style="font-size: 11px; color: #2E2F30;">Original Supervisor <i style="color: #949494;">05/11/20, 07:06 AM</i></td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td style="font-size: 12px; padding: 5px 0; color: #2E2F30;"><i>fgghfghfghfhfgh</i></td>
                                                                  </tr>
                                                               </table>
                                                            </td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td style="height:10px; line-height: 15px;">&nbsp;</td>
                                                </tr>
                                             </table>
                                          </td>
                                          <td valign="top" width="28%" align="right">
                                             <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                   <td align="center" style="font-size: 10px; color: #949494; font-weight: bold;">Updated Progress</td>
                                                </tr>
                                                <tr>
                                                   <td style="height:5px; line-height: 5px;">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                   <td align="center" width="100%" style="text-align: center;"><span style="width: 30px; margin: 0 auto; display: inline-block; height: 30px; line-height: 30px; background: #fde1d1; color: #FA6400; text-decoration: none; font-size: 13px; text-align: center; border: 1px solid #fde1d1;">2</span></td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr> -->
                             <!--  <tr>
                                 <td style="height:15px; line-height: 15px;">&nbsp;</td>
                              </tr> -->
                              <!-- <tr>
                                 <td width="100%">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-bottom: 1px solid #C0C0C0;">
                                       <tr>
                                          <td valign="top" width="72%" align="left">
                                             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="table-layout:fixed;">
                                                <tr>
                                                   <td valign="top" width="15%"> <img style="width: 40px;" src="{{ asset('images/pdf-av.png') }}"> </td>
                                                   <td valign="top" width="2%"></td>
                                                   <td valign="top" width="83%">
                                                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                         <tr>
                                                            <td width="100%">
                                                               <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                  <tr>
                                                                     <td style="font-size: 11px; color: #FA6400;">Admin</td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td style="font-size: 11px; color: #2E2F30;">WMU Admin <i style="color: #949494;">05/11/20, 07:06 AM</i></td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td style="font-size: 12px; padding: 5px 0; color: #2E2F30;"><i>fgghfghfghfhfgh</i></td>
                                                                  </tr>
                                                               </table>
                                                            </td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td style="height:10px; line-height: 15px;">&nbsp;</td>
                                                </tr>
                                             </table>
                                          </td>
                                          <td valign="top" width="28%" align="right">
                                             <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                   <td align="center" style="font-size: 10px; color: #949494; font-weight: bold;">Updated Progress</td>
                                                </tr>
                                                <tr>
                                                   <td style="height:5px; line-height: 5px;">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                   <td align="center" width="100%" style="text-align: center;"><span style="width: 30px; margin: 0 auto; display: inline-block; height: 30px; line-height: 30px; background: #fde1d1; color: #FA6400; text-decoration: none; font-size: 13px; text-align: center; border: 1px solid #fde1d1;">2</span></td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr> -->
                           </table>
                        </td>
                     </tr>

                  </table>
               </td>
            </tr>
         </table>
      </td>
   </tr>
</table>
