{{--

    Required
        - $url

--}}


@php
    $frontendPage = FrontendPage::getDefault();
@endphp


@extends('pages.emails.layout.minimenu', ['frontendPage'=>$frontendPage])

@section('page_content')
    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
        <tr>
            <td align="center" style="word-break:break-word; font-size:20px; padding: 10px 10px 30px;">
                <div style="color: rgb(85, 87, 93); font-family:'Open Sans', Helvetica, Arial, sans-serif, serif, EmojiFont; font-size: 22px; font-weight: 700; line-height: 22px;">Activate Your Account </div>
            </td>
        </tr>

        <tr>
            <td align="center" style="word-break:break-word; font-size:14px; padding: 10px">
                <div style="color: rgb(140, 140, 140); font-family: Roboto, Helvetica, Arial, sans-serif, serif, EmojiFont; font-size: 16px; line-height: 25px">
                    {{--<br>{!! Config1::APP_FANCY_TITLE !!}<br>--}}
                    To activate your account. We just need to validate your email address.
                    Simply click the following button:</div>
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
    </table>

@endsection