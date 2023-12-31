@php
    $frontendPage = FrontendPage::getDefault();
@endphp


@extends('pages.emails.layout.minimenu', ['frontendPage'=>$frontendPage])

@section('page_content')
    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
        <th class="x_bodyWrapper x_small-12 x_large-12 x_columns x_first x_last"
            style="margin:0 auto; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0 auto; padding:0; padding-bottom:0; padding-left:35px!important; padding-right:35px!important; padding-top:35px!important; text-align:left; width:615px">
            <table style="border-collapse:collapse; border-spacing:0; padding:0; text-align:left; vertical-align:top; width:100%">
                <tbody>
                <tr style="padding:0; text-align:left; vertical-align:top">
                    <th style="margin:0; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0; padding:0; text-align:left">
                        <table align="center" class="x_container x_table"
                               style="margin:0 auto; background:#fff; border-collapse:collapse; border-spacing:0; margin:0 auto; padding:0; text-align:inherit; vertical-align:top; width:100%">
                            <tbody>
                            <tr style="padding:0; text-align:left; vertical-align:top">
                                <td style="margin:0; border-collapse:collapse!important; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0; padding:0; text-align:left; vertical-align:top; word-wrap:break-word">
                                    <table class="x_row"
                                           style="border-collapse:collapse; border-spacing:0; display:table; padding:0; text-align:left; vertical-align:top; width:100%">
                                        <tbody>
                                        <tr style="padding:0; text-align:left; vertical-align:top">
                                            <th class="x_small-12 x_large-12 x_columns x_first x_last"
                                                style="margin:0 auto; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0 auto; padding:0; padding-bottom:0; padding-left:0!important; padding-right:0!important; text-align:left; width:100%">
                                                <table style="border-collapse:collapse; border-spacing:0; padding:0; text-align:left; vertical-align:top; width:100%">
                                                    <tbody>
                                                    <tr style="padding:0; text-align:left; vertical-align:top">
                                                        <th style="margin:0; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0; padding:0; text-align:left">
                                                            <h1 style="margin:0; margin-bottom:8px; color:#232a65!important; font-family:'Open Sans',Arial,sans-serif; font-size:1.728em; font-weight:700; line-height:1.3; margin:0; margin-bottom:8px; padding:0; text-align:left; word-wrap:normal">
                                                                Successful Login</h1></th>
                                                        <th class="x_expander"
                                                            style="margin:0; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0; padding:0!important; text-align:left; visibility:hidden; width:0"></th>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </th>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="x_spacer"
                                           style="border-collapse:collapse; border-spacing:0; padding:0; text-align:left; vertical-align:top; width:100%">
                                        <tbody>
                                        <tr style="padding:0; text-align:left; vertical-align:top">
                                            <td height="8px"
                                                style="margin:0; border-collapse:collapse!important; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:8px; font-weight:400; line-height:8px; margin:0; padding:0; text-align:left; vertical-align:top; word-wrap:break-word">
                                                &nbsp;
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="x_row"
                                           style="border-collapse:collapse; border-spacing:0; display:table; padding:0; text-align:left; vertical-align:top; width:100%">
                                        <tbody>
                                        <tr style="padding:0; text-align:left; vertical-align:top">
                                            <th class="x_small-12 x_large-12 x_columns x_first x_last"
                                                style="margin:0 auto; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0 auto; padding:0; padding-bottom:0; padding-left:0!important; padding-right:0!important; text-align:left; width:100%">
                                                <table style="border-collapse:collapse; border-spacing:0; padding:0; text-align:left; vertical-align:top; width:100%">
                                                    <tbody>
                                                    <tr style="padding:0; text-align:left; vertical-align:top">
                                                        <th style="margin:0; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0; padding:0; text-align:left">
                                                            <p style="margin:0; margin-bottom:10px; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0; margin-bottom:0!important; padding:0; text-align:left">
                                                                We detected a new login to your
                                                                {!! Config1::APP_TITLE !!} account from:</p></th>
                                                        <th class="x_expander"
                                                            style="margin:0; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0; padding:0!important; text-align:left; visibility:hidden; width:0"></th>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </th>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="x_spacer"
                                           style="border-collapse:collapse; border-spacing:0; padding:0; text-align:left; vertical-align:top; width:100%">
                                        <tbody>
                                        <tr style="padding:0; text-align:left; vertical-align:top">
                                            <td height="35px"
                                                style="margin:0; border-collapse:collapse!important; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:35px; font-weight:400; line-height:35px; margin:0; padding:0; text-align:left; vertical-align:top; word-wrap:break-word">
                                                &nbsp;
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table align="center"
                                           class="x_container x_tableWrapper x_collapse"
                                           style="margin:0 auto; background:#fff; background-color:#f7f7fa; border-collapse:collapse; border-spacing:0; margin:0 auto; padding:0; text-align:inherit; vertical-align:top; width:100%">
                                        <tbody>
                                        <tr style="padding:0; text-align:left; vertical-align:top">
                                            <td style="margin:0; border-collapse:collapse!important; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0; padding:0; text-align:left; vertical-align:top; word-wrap:break-word">
                                                <table class="x_spacer"
                                                       style="border-collapse:collapse; border-spacing:0; padding:0; text-align:left; vertical-align:top; width:100%">
                                                    <tbody>
                                                    <tr style="padding:0; text-align:left; vertical-align:top">
                                                        <td height="16px"
                                                            style="margin:0; border-collapse:collapse!important; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:16px; margin:0; padding:0; text-align:left; vertical-align:top; word-wrap:break-word">
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <table class="x_row"
                                                       style="border-collapse:collapse; border-spacing:0; display:table; padding:0; text-align:left; vertical-align:top; width:100%">
                                                    <tbody>
                                                    <tr style="padding:0; text-align:left; vertical-align:top">
                                                        <th class="x_small-12 x_large-7 x_columns x_first"
                                                            style="margin:0 auto; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0 auto; padding:0; padding-bottom:0; padding-left:0!important; padding-right:0!important; text-align:left; width:58.33333%">
                                                            <table style="border-collapse:collapse; border-spacing:0; padding:0; text-align:left; vertical-align:top; width:100%">
                                                                <tbody>
                                                                <tr style="padding:0; text-align:left; vertical-align:top">
                                                                    <th style="margin:0; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0; padding:0; text-align:left">
                                                                        <p class="x_boldText x_paddingLeft"
                                                                           style="margin:0; margin-bottom:10px; color:#424770!important; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:700!important; line-height:1.3; margin:0; margin-bottom:0!important; padding:0; padding-left:20px; text-align:left">
                                                                            IP:</p></th>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </th>
                                                        <th class="x_small-12 x_large-5 x_columns x_last"
                                                            style="margin:0 auto; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0 auto; padding:0; padding-bottom:0; padding-left:0!important; padding-right:0!important; text-align:left; width:41.66667%">
                                                            <table style="border-collapse:collapse; border-spacing:0; padding:0; text-align:left; vertical-align:top; width:100%">
                                                                <tbody>
                                                                <tr style="padding:0; text-align:left; vertical-align:top">
                                                                    <th style="margin:0; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0; padding:0; text-align:left">
                                                                        <p class="x_valueText x_paddingRight"
                                                                           style="margin:0; margin-bottom:10px; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0; margin-bottom:0!important; padding:0; padding-right:20px; text-align:right">
                                                                            {{ Url1::getIPAddress() }}</p>
                                                                    </th>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </th>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <table class="x_spacer"
                                                       style="border-collapse:collapse; border-spacing:0; padding:0; text-align:left; vertical-align:top; width:100%">
                                                    <tbody>
                                                    <tr style="padding:0; text-align:left; vertical-align:top">
                                                        <td height="16px"
                                                            style="margin:0; border-collapse:collapse!important; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:16px; margin:0; padding:0; text-align:left; vertical-align:top; word-wrap:break-word">
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <table class="x_row x_tableField"
                                                       style="background-color:#737a82; border-collapse:collapse; border-spacing:0; display:table; height:1px; margin:0 auto; opacity:.15; padding:0; text-align:left; vertical-align:top; width:92%!important">
                                                    <tbody>
                                                    <tr style="padding:0; text-align:left; vertical-align:top"></tr>
                                                    </tbody>
                                                </table>
                                                <table class="x_spacer"
                                                       style="border-collapse:collapse; border-spacing:0; padding:0; text-align:left; vertical-align:top; width:100%">
                                                    <tbody>
                                                    <tr style="padding:0; text-align:left; vertical-align:top">
                                                        <td height="16px"
                                                            style="margin:0; border-collapse:collapse!important; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:16px; margin:0; padding:0; text-align:left; vertical-align:top; word-wrap:break-word">
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <table class="x_row"
                                                       style="border-collapse:collapse; border-spacing:0; display:table; padding:0; text-align:left; vertical-align:top; width:100%">
                                                    <tbody>

                                                    <tr style="padding:0; text-align:left; vertical-align:top">
                                                        <th class="x_small-12 x_large-7 x_columns x_first"
                                                            style="margin:0 auto; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0 auto; padding:0; padding-bottom:0; padding-left:0!important; padding-right:0!important; text-align:left; width:58.33333%">
                                                            <table style="border-collapse:collapse; border-spacing:0; padding:0; text-align:left; vertical-align:top; width:100%">
                                                                <tbody>
                                                                <tr style="padding:0; text-align:left; vertical-align:top">
                                                                    <th style="margin:0; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0; padding:0; text-align:left">
                                                                        <p class="x_boldText x_paddingLeft"
                                                                           style="margin:0; margin-bottom:10px; color:#424770!important; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:700!important; line-height:1.3; margin:0; margin-bottom:0!important; padding:0; padding-left:20px; text-align:left">
                                                                            Device:</p></th>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </th>
                                                        <th class="x_small-12 x_large-5 x_columns x_last"
                                                            style="margin:0 auto; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0 auto; padding:0; padding-bottom:0; padding-left:0!important; padding-right:0!important; text-align:left; width:41.66667%">
                                                            <table style="border-collapse:collapse; border-spacing:0; padding:0; text-align:left; vertical-align:top; width:100%">
                                                                <tbody>
                                                                <tr style="padding:0; text-align:left; vertical-align:top">
                                                                    <th style="margin:0; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0; padding:0; text-align:left">
                                                                        <p class="x_valueText x_paddingRight"
                                                                           style="margin:0; margin-bottom:10px; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0; margin-bottom:0!important; padding:0; padding-right:20px; text-align:right">
                                                                            {{ $_SERVER['HTTP_USER_AGENT'] }}
                                                                        </p>
                                                                    </th>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </th>


                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <table class="x_spacer"
                                                       style="border-collapse:collapse; border-spacing:0; padding:0; text-align:left; vertical-align:top; width:100%">
                                                    <tbody>
                                                    <tr style="padding:0; text-align:left; vertical-align:top">
                                                        <td height="16px"
                                                            style="margin:0; border-collapse:collapse!important; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:16px; margin:0; padding:0; text-align:left; vertical-align:top; word-wrap:break-word">
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="x_spacer"
                                           style="border-collapse:collapse; border-spacing:0; padding:0; text-align:left; vertical-align:top; width:100%">
                                        <tbody>
                                        <tr style="padding:0; text-align:left; vertical-align:top">
                                            <td height="35px"
                                                style="margin:0; border-collapse:collapse!important; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:35px; font-weight:400; line-height:35px; margin:0; padding:0; text-align:left; vertical-align:top; word-wrap:break-word">
                                                &nbsp;
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="x_row"
                                           style="border-collapse:collapse; border-spacing:0; display:table; padding:0; text-align:left; vertical-align:top; width:100%">
                                        <tbody>
                                        <tr style="padding:0; text-align:left; vertical-align:top">
                                            <th class="x_small-12 x_large-12 x_columns x_first x_last"
                                                style="margin:0 auto; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0 auto; padding:0; padding-bottom:0; padding-left:0!important; padding-right:0!important; text-align:left; width:100%">
                                                <table style="border-collapse:collapse; border-spacing:0; padding:0; text-align:left; vertical-align:top; width:100%">
                                                    <tbody>
                                                    <tr style="padding:0; text-align:left; vertical-align:top">
                                                        <th style="margin:0; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0; padding:0; text-align:left">
                                                            <p style="margin:0; margin-bottom:10px; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0; margin-bottom:0!important; padding:0; text-align:left">
                                                                If you did not make this request
                                                                please <a
                                                                        href="{!! url('/contact') !!}"
                                                                        target="_blank"
                                                                        rel="noopener noreferrer"
                                                                        data-auth="NotApplicable"
                                                                        class="x_link"
                                                                        style="margin:0; color:#4155a4!important; font-family:'Open Sans',Arial,sans-serif; font-weight:400; line-height:1.3; margin:0; padding:0; text-align:left; text-decoration:none"
                                                                        data-linkindex="0">contact
                                                                    {!! Config1::APP_TITLE !!} Support</a>.</p>
                                                            <table class="x_spacer"
                                                                   style="border-collapse:collapse; border-spacing:0; padding:0; text-align:left; vertical-align:top; width:100%">
                                                                <tbody>
                                                                <tr style="padding:0; text-align:left; vertical-align:top">
                                                                    <td height="35px"
                                                                        style="margin:0; border-collapse:collapse!important; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:35px; font-weight:400; line-height:35px; margin:0; padding:0; text-align:left; vertical-align:top; word-wrap:break-word">
                                                                        &nbsp;
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>

                                                            {{--<p style="margin:0; margin-bottom:10px; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0; margin-bottom:0!important; padding:0; text-align:left">
                                                                <a href="{!! url('/contact') !!}"
                                                                   target="_blank"
                                                                   rel="noopener noreferrer"
                                                                   data-auth="NotApplicable"
                                                                   class="x_link"
                                                                   style="margin:0; color:#4155a4!important; font-family:'Open Sans',Arial,sans-serif; font-weight:400; line-height:1.3; margin:0; padding:0; text-align:left; text-decoration:none"
                                                                   data-linkindex="1">Click here
                                                                    to freeze your account
                                                                    immediately</a></p>--}}

                                                        </th>
                                                        <th class="x_expander"
                                                            style="margin:0; color:#7a7e9b; font-family:'Open Sans',Arial,sans-serif; font-size:16px; font-weight:400; line-height:1.3; margin:0; padding:0!important; text-align:left; visibility:hidden; width:0"></th>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </th>
                </tr>
                </tbody>
            </table>
        </th>
    </table>

@endsection




