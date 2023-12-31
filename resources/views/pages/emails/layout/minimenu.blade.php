<!DOCTYPE html>
<html>
    <div style="background:#f5f5f5">
        <div style="background-color:#f5f5f5; padding-top:80px">
            <div style="margin:0 auto; max-width:600px; background:#FFFFFF">

                <table role="presentation" cellpadding="0" cellspacing="0" align="center" border="0" style="font-size:14px; width:100%; background:#FFFFFF; border-top:3px solid #f6ac11">
                    <tbody>
                        <tr>
                            <td style=" background:#fead0d">
                                <p style="font-size: 1.5em; font-weight: 800; padding:15px; font-family:'Open Sans',Arial,sans-serif; letter-spacing: 2px">{!! Config1::APP_TITLE !!}</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center; vertical-align:top; font-size:14px; padding:40px 30px 30px 30px">
                                <div style="vertical-align:top; display:inline-block; font-size:13px; text-align:left; width:100%">

                                    @yield('page_content')

                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
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
                                        <a href="{{ url('/privacy-policy') }}" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" style="color:inherit; padding:0 7px">Privacy Policy</a>
                                        <a href="{{ url('/privacy-policy') }}" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" style="color:inherit; padding:0 7px">Sending Policy</a>
                                        <a href="{{ url('/terms-and-conditions') }}" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" style="color:inherit; padding:0 7px">Terms of Use</a> </div>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="word-break:break-word; font-size:14px; padding:10px">
                                    <div style="color: rgb(140, 140, 140); font-family: Roboto, Helvetica, Arial, sans-serif, serif, EmojiFont; font-size: 12px; line-height: 22px;">
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

</html>