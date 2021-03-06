{{--
    Required Paramenter
     -- ['url'=>'http://activa....']
--}}
<div style="background:#f5f5f5">
    <div style="background-color:#f5f5f5; padding-top:80px">
        <div style="margin:0 auto; max-width:600px; background:#FFFFFF">
            <table role="presentation" cellpadding="0" cellspacing="0" align="center" border="0" style="font-size:14px; width:100%; background:#FFFFFF; border-top:3px solid #fead0d">
                <tbody>
                <tr>
                    <td style="text-align:center; vertical-align:top; font-size:14px; padding:40px 30px 30px 30px">
                        <div aria-labelledby="mj-column-per-100" class="x_mj-column-per-100" style="vertical-align:top; display:inline-block; font-size:13px; text-align:left; width:100%">
                            <div></div><table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                                <tbody>
                                <tr>
                                    <td align="center" style="word-break:break-word; font-size:14px; padding: 10px 10px 30px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" align="center" border="0" style="border-collapse:collapse; border-spacing:0px">
                                            <tbody>
                                                <tr>
                                                    <td style="width:180px">
                                                        <a href="{{ url('/') }}" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable">
                                                            <img data-imagetype="External" src="{{ Picture1::toBase64(path_asset('logo.png')) }}" alt="" title="" height="140" width="160" style="border:none; display:block; outline:none; text-decoration:none; width:160px; height:140px" />
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>


                                <tr>
                                    <td align="center" style="word-break:break-word; font-size:20px; padding: 10px 10px 30px;">
                                        <div style="color: rgb(85, 87, 93); font-family:'Open Sans', Helvetica, Arial, sans-serif, serif, EmojiFont; font-size: 22px; font-weight: 700; line-height: 22px;">Activate Your Account </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" style="word-break:break-word; font-size:14px; padding: 10px 10px 35px;">
                                        <div style="color: rgb(140, 140, 140); font-family: Roboto, Helvetica, Arial, sans-serif, serif, EmojiFont; font-size: 16px; line-height: 25px">
                                            We just need to validate your email address to activate your {!! Config1::APP_FANCY_TITLE !!} account. Simply click the following button:</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="word-break:break-word; font-size:14px; padding: 10px 10px 35px;">
                                        <div style="color: rgb(140, 140, 140); font-family: Roboto, Helvetica, Arial, sans-serif, serif, EmojiFont; font-size: 14px; line-height: 22px;">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="word-break:break-word; font-size:14px; padding: 10px 10px 40px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" align="center" border="0" style="border-collapse:separate">
                                            <tbody>
                                            <tr>
                                                <td align="center" valign="middle" bgcolor="#fead0d" style="border-radius:2px; color:#fff; padding:10px 25px"><a href="{{ $url }}" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" style="display:inline-block; text-decoration:none; background:#fead0d; color:#fff; font-family:Roboto,Helvetica,Arial,sans-serif,Helvetica,Arial,sans-serif; font-size:14px; font-weight:normal; margin:0">Activate my account </a></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="word-break:break-word; font-size:14px; padding:10px; padding-bottom:8px">
                                        <div style="color: rgb(140, 140, 140); font-family: Roboto, Helvetica, Arial, sans-serif, serif, EmojiFont; font-size: 14px; line-height: 22px;">
                                            If the link does not work, please copy the URL below into your browser:
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="word-break:break-word; font-size:14px; padding:10px; padding-bottom:35px">
                                        <div style="color: rgb(53, 134, 255); font-family: Roboto, Helvetica, Arial, sans-serif, serif, EmojiFont; font-size: 14px; line-height: 22px;">
                                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" style="text-decoration:none; color:inherit">{{ $url }}</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="word-break:break-word; font-size:14px; padding:10px">
                                        <div style="color: rgb(140, 140, 140); font-family: Roboto, Helvetica, Arial, sans-serif, serif, EmojiFont; font-size: 14px; line-height: 22px;">Welcome aboard! </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="word-break:break-word; font-size:14px; padding:10px">
                                        <div style="color: rgb(140, 140, 140); font-family: Roboto, Helvetica, Arial, sans-serif, serif, EmojiFont; font-size: 14px; line-height: 22px;">The {!! Config1::APP_TITLE !!} Crew </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" style="word-break:break-word; font-size:14px; padding:10px">
                                        <div style="color: rgb(140, 140, 140); font-family: Roboto, Helvetica, Arial, sans-serif, serif, EmojiFont; font-size: 14px; line-height: 22px;">PS: you have agreed to receive our newsletter. Your newsletter subscription may be cancelled at any time by clicking on the unsubscribe link included in each email we send out.</div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div style="margin:0 auto; max-width:600px">
            <table role="presentation" cellpadding="0" cellspacing="0" align="center" border="0" style="font-size:14px; width:100%">
                <tbody>
                <tr>
                    <td style="text-align:center; vertical-align:top; font-size:14px; padding:30px">
                        <div aria-labelledby="mj-column-per-100" class="x_mj-column-per-100" style="vertical-align:top; display:inline-block; font-size:13px; text-align:left; width:100%">
                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                                <tbody>

                                <tr>
                                    <td align="center" style="word-break:break-word; font-size:14px; padding: 10px;">
                                        <div style="color: rgb(140, 140, 140); font-family: Roboto, Helvetica, Arial, sans-serif, serif, EmojiFont; font-size: 12px; line-height: 22px;">
                                            <span>This email was sent to you by {{ Config1::APP_TITLE }} because you signed up for a {{ Config1::APP_TITLE }} account.</span>
                                            <span>Please let us know if you feel that this email was sent to you by error.</span>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" style="word-break:break-word; font-size:14px; padding: 10px 10px 15px;">
                                        <div style="color: rgb(140, 140, 140); font-family: Roboto, Helvetica, Arial, sans-serif, serif, EmojiFont; font-size: 12px; line-height: 22px;">
                                            © {{ date('Y') }} | {{ Config1::APP_TITLE }} </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="word-break:break-word; font-size:14px; padding: 10px;">
                                        <div style="color: rgb(140, 140, 140); font-family: Roboto, Helvetica, Arial, sans-serif, serif, EmojiFont; font-size: 12px; line-height: 22px;">
                                            <a href="{{ url('/privacy_policy') }}" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" style="color:inherit; padding:0 7px">Privacy Policy</a>
                                            <a href="{{ url('/privacy_policy') }}" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" style="color:inherit; padding:0 7px">Sending Policy</a>
                                            <a href="{{ url('/terms_and_condition') }}" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" style="color:inherit; padding:0 7px">Terms of Use</a> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="word-break:break-word; font-size:14px; padding:10px">
                                        <div style="color: rgb(140, 140, 140); font-family: Roboto, Helvetica, Arial, sans-serif, serif, EmojiFont; font-size: 12px; line-height: 22px;">
                                            <?php $frontendPage = FrontendPage::getDefault(); ?>
                                            <a href="{{ $frontendPage->social_facebook }}" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" style="text-decoration:none; color:inherit; padding:0 4px"><img data-imagetype="External" src="https://app.mailjet.com/images/email/transac/fb.png" alt="" width="-22" height="auto" style="border:none; outline:none; text-decoration:none; height:auto">
                                            </a><a href="{{ $frontendPage->social_twitter }}" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" style="text-decoration:none; color:inherit; padding:0 4px"><img data-imagetype="External" src="https://app.mailjet.com/images/email/transac/tw.png" alt="" width="-22" height="auto" style="border:none; outline:none; text-decoration:none; height:auto">
                                            </a><a href="{{ $frontendPage->rss_feed }}" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" style="text-decoration:none; color:inherit; padding:0 4px"><img data-imagetype="External" src="https://app.mailjet.com/images/email/transac/rss.png" alt="" width="-22" height="auto" style="border:none; outline:none; text-decoration:none; height:auto"></a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <br>
    {{--<img data-imagetype="External" src="{{ $frontendPage->social_facebook }}" originalsrc="http://gtpx.mjt.lu/oo/BAAAAB7dCn8AAAAAAAAAAG5btzcAARpwxasAAAAAAAicvQBcfeP7nMM7USD4T_iw0xQIa6zdvwAG4VU/a69f930a/e.gif" data-connectorsauthtoken="1" data-imageproxyendpoint="/actions/ei" data-imageproxyid="" height="1" width="1" alt="" border="0" style="height:1px; width:1px; border:0">--}}
</div>