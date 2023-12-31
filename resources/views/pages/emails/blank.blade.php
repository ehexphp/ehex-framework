{{--

    Required
        - $content

--}}

@php
    $frontendPage = FrontendPage::getDefault();
@endphp


@extends('pages.emails.layout.minimenu', ['frontendPage'=>$frontendPage])

@section('page_content')
    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
        <tr>
            <td  style="word-break:break-word; font-size:14px; padding:10px">
                <div style="color: rgb(140, 140, 140); font-family: Roboto, Helvetica, Arial, sans-serif, serif, EmojiFont; font-size: 14px; line-height: 22px;">
                    {!! $content !!}
                </div>
            </td>
        </tr>
    </table>
@endsection