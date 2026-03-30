<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!--[if mso]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <style>
        table {border-collapse: collapse;}
        .spacer,.divider {mso-line-height-rule: exactly;}
        td,th,div,p,a {font-size: 16px; line-height: 25px;}
        td,th,div,p,a,h1,h2,h3,h4,h5,h6 {font-family:"Segoe UI",Helvetica,Arial,sans-serif;}
    </style>
    <![endif]-->

    <style type="text/css">
        body, table, td, a, p, h1, h2, h3, h4, h5, h6, blockquote, ul, li {
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            line-height: 1.571429;
            color: #76838f;
        }

        p {
            margin: 0;
        }

        ul li {
            margin-bottom: 5px;
        }

        strong, b {
            font-weight: 500;
        }
        .otp{
            font-size: 3rem;
            font-weight: 700;
            color: #2A3140;
            padding: 12px 12px 12px 20px;
            border-radius: 6px;
            letter-spacing: 8px;
            background-color: #F2F4F7;
        }
        /* Framework CSS - Removed for demo purposes */
        @media only screen and (max-width:768px) {
            .otp{
                font-size: 45px;
            }
        }
    </style>
</head>
<body style="box-sizing:border-box;margin:0;padding:0;width:100%;word-break:break-word;-webkit-font-smoothing:antialiased;">
<table class="wrapper" cellpadding="16" cellspacing="0" role="presentation" width="100%">
    <tr align="center">
        <td>
            <table class="container" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" role="presentation" width="80%" style="margin: auto">
                <tr>
                    <td align="left">

                        <!-- ADD ROWS HERE -->
                        <table cellpadding="0" cellspacing="0" role="presentation" align="center" style="background-color: #ffffff;" width="100%">
                            <tr>
                                <td>
                                    <div style="display: flex;align-items: center">
                                        <h4 style="font-size: 20px;color: #3E4452;font-weight: 600">{{config('app.name')}}</h4>
                                    </div>
                                </td>
                            </tr>
                            <tr align="center">
                                <td>
                                    <div class="spacer" style="height: 40px!important;"></div>
                                    <table cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                        <tr>
                                            <td class="col px-sm-16">
                                                <p style="font-weight: 400;color: #6F737E;font-size: 18px;margin-bottom: 25px">
                                                    Hello {{ $content['name'] }},
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col px-sm-16">
                                                <p style="font-weight: 400;color: #6F737E;font-size: 18px">
                                                    Enter the OTP below to log in to {{config('app.name')}}:</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="display: flex">
                                                <h1 class="otp">
                                                    @if(isset($content) && isset($content['security_code']))
                                                        {{ $content['security_code'] }}
                                                    @endif
                                                </h1>
                                            </td>
                                        </tr>
                                        <tr >
                                            <td>
                                                <p style="font-weight: 400;color: #6F737E;font-size: 18px">
                                                    The OTP will expire in 10 minutes
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p style="font-weight: 400;color: #6F737E;font-size: 18px">
                                                    If you have not tried to login, ignore this message.
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p style="margin-top:25px;font-weight: 400;color: #6F737E;font-size: 18px">
                                                    Regards,
                                                </p>
                                                <p style="font-weight: 400;color: #6F737E;font-size: 18px">
                                                    {{config('app.name')}}
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="spacer" style="height: 40px!important;"></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>
