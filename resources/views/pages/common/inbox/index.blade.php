<?php
    $userInfo = User::getLogin(true);
?>
@extends('layouts.shards_dashboard.template', ['page_title'=>"Inbox", 'allow_xcrud'=>true])







@section('page_content')
    <div class="main-content-container container-fluid px-4">
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">User Inbox</span>
                <h3 class="page-title"> Message {!! Inbox::getIfModerator($userInfo->id)? "<span class='badge badge-primary'>".Inbox::getIfModerator($userInfo->id)." Department </span>": "" !!}</h3>
            </div>
        </div>



        @if(isset($_REQUEST["track_id"]) && !empty($_REQUEST['track_id']))
            <?php
                // get track_id
                $track_id = $_REQUEST["track_id"];

                // permission
                if(!Inbox::isUserAuthorizedInConversation($track_id, $userInfo->id)) return redirect(url('/inbox'), ['Permission Denied', 'your are not authorized for this conversation', 'error']);

                // mark as_read
                if(String1::isset_or(Inbox::getTrackIdLastConversation($track_id)['to_user_id'], null) == $userInfo->id) Inbox::updateMany(['as_read'=>1], ['track_id'=>$track_id]);

                // Partner Information
                $partnerInfo = Inbox::getTrackIdPartnerInfo($track_id);
                if($partnerInfo['id'] == $userInfo->id || $partnerInfo['id'] < 0) return redirect(url('/inbox'), ["In-appropriate Conversation", "You cannot chat with one self.", 'error']);

                // previous chat
                $allPreviousConversation = Inbox::getTrackIdConversationList($track_id);
                $totalConversation = count($allPreviousConversation);
                // delete old conversation
                if($totalConversation/Inbox::$APP_CONFIG['MAX_CHAT_COUNT']>=2){
                    for ($i=1; $i<=(Inbox::$APP_CONFIG['MAX_CHAT_COUNT']/2); $i++)
                        Inbox::deleteBy($allPreviousConversation[$i]['id']);
                }
            ?>

            <div class="row">
                <div class="col-md-7 mb-4 mx-auto">

                    <div class="card card-small">
                        <div class='card-header border-bottom'>
                            <strong class="float-left"><i class='fa fa-user' aria-hidden='true'></i> {!! $partnerInfo['full_name'] !!}</strong>
                            <a class="float-right text-danger" onclick="Popup1.confirmLink('Delete Message', 'Are you sure you want to delete this conversation?', '{{ Url1::actionLink(Inbox::class, "deleteConversationForUser(".String1::replaceMany($track_id, ',', '--').")") }}')"><i class="fa fa-trash" aria-hidden="true"></i> Delete Message</a>
                        </div>

                        <div class='card-body jumbotron chatBox' id="chatBox">
                            @if($totalConversation > 0)
                                @foreach ($allPreviousConversation as $chat)
                                    <?php $isMeTheSender = ($chat['user_id'] == $userInfo->id); ?>
                                    <div class='chat {{ ($isMeTheSender? "request": "response") }}'>
                                        <div>
                                            <small class="text-white-50">{!! ($isMeTheSender? "": User::getField($chat['user_id'], 'user_name', "#$chat[user_id]"))."<br/>" !!}</small>
                                            <strong>{{ $chat->subject }}</strong>
                                            {{ $chat->message }}
                                        </div>
                                        <div class='mt-1'>
                                            <div class='{{ ($isMeTheSender? "pull-right float-right": "") }}'>
                                                {!! Inbox::renderAttachment($chat->attachment) !!}
                                                <em class="text-white-50" style='font-size:11px;'>{{ DateManager1::diffForHumans($chat->created_at) }}</em>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                @endforeach
                            @else
                                <div class="text-muted m-5 text-center">
                                    <h2 class="text-muted"><i class='fa fa-wechat'></i></h2>
                                    <h5 class="text-muted"><strong>Chat with {{ $partnerInfo['full_name'] }}</strong></h5>
                                </div>
                            @endif
                            {{--<a name='last'></a>--}}
                        </div>


                        <div class='card-footer' style='margin-top:-30px;'>
                            {!!
                                HtmlForm1::open("Inbox@processSendMessage()").
                                HtmlForm1::addHidden('to_user_id', $partnerInfo['id']).
                                HtmlForm1::addTextArea(null, ['name'=>'message', 'rows'=>7, 'required']).
                                "<div class='mt-3 '>".
                                    HtmlForm1::submit("Send Message", ['class'=>'btn btn-primary']).
                                    "<label class='btn btn-default' style='width:160px;'> <i class='fa fa-clipboard'></i> <span id='fileCover'>Attachment</span> <input style='opacity:0' type='file' onchange='$(\"#fileCover\").html(\"<strong class=text-primary>File Added!</strong>\")' name='attachment'></label>
                                     <a class='btn btn-default float-right text-danger' href=".url("/inbox")."?track_id=".Inbox::$APP_CONFIG['SPAM_REPORT_ID'].",".Auth1::id()."&message=".urlencode("I am reporting this conversation... ".Url1::getPageFullUrl()."#report")."><i class='fa fa-flag'></i> Report Spam</a>
                                </div>".
                                HtmlForm1::close(null)
                             !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif





        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                <div class="card card-small">
                    <div class="card-header border-bottom">
                        <h6 class="m-0"> {!! Inbox::getModelClassName(true) !!}
                            <button class="btn btn-danger float-right"  onclick="Popup1.confirmLink('Delete All Messages', 'Are you sure you want to delete all messages?', '{{ Url1::actionLink(Inbox::class, "deleteAllConversationForUser()") }}')"><i class="fa fa-trash" aria-hidden="true"></i> Clear All</button>
                            <button class="mr-2 btn btn-primary float-right" onclick="adminList()"><i class="fa fa-envelope" aria-hidden="true"></i> Message Admin </button>
                            <script>
                                function adminList(){
                                    return Popup1.confirmOption('Select', 'select department to chat with', JSON.parse('{!! json_encode(Inbox::$APP_CONFIG['CHAT_DEPARTMENT_USER_ID_LIST']) !!}'), function(id){
                                        Url1.redirect("{{ url('inbox')  }}?track_id=" + id + ",{{ $userInfo->id }}" )
                                    });
                                }
                            </script>
                        </h6>
                    </div>
                    <div class="card-body pt-0" style="margin-top:10px;">{!! Inbox::manage()->render() !!}</div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .chatBox{position:relative;padding:10px;border:1px solid #ececec;border-radius:1px;max-height:60vh;min-height:50vh;overflow:scroll;}
        .chat{width:80%;padding:15px;color:#fff;border-radius:20px;margin-bottom:10px;}
        .chat a{ color:yellow; font-weight: 800; }
        .response{border:1px solid #506db1;background: #506db1}
        .request{background: #1fcc7c;border:1px solid #1fcc7c;float:right}
    </style>
    <script>Html1.scrollToElementEnd('chatBox')</script>
@endsection