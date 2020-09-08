<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0;">
    <meta name="format-detection" content="telephone=no">
    <title>BMP IMS ALERT Mail</title>

</head>
<body topmargin="0" rightmargin="0" bottommargin="0" leftmargin="0" marginwidth="0" marginheight="0" width="100%"
      style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%; height: 100%; -webkit-font-smoothing: antialiased; text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; line-height: 100%;
  background-color: #F0F0F0;
  color: #000000;" bgcolor="#F0F0F0" text="#000000">
<!-- Set message background color one again -->
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0"
       style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%;" class="background">
    <tbody>
    <tr>
        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;"
            bgcolor="#F0F0F0">
            <!-- Set conteiner background color -->
            <table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#FFFFFF" width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
  max-width: 560px;" class="container">
                <tbody>
                <tr>
                    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 0; padding-right: 0; width: 96.5%; font-size: 24px; font-weight: bold; line-height: 130%; padding-left: 6.25%; padding-right: 6.25%;
      color: #000000;
      font-family: sans-serif;" class="header">
                        <!-- opening of new table to divide block into 2 half -->

                    </td>
                </tr>


                <tr>
                    <td align="left" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 14px; line-height: 170%;
      padding-top: 25px;
      color: #000000;
      font-family: sans-serif;" class="paragraph">
                        <b> Hello ,</b>
                        <br>
                        Following Investment are about to expire. Please review the investment.<br>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 14px; line-height: 170%; color: #000000;
      font-family: sans-serif;" class="paragraph">
                        <hr color="#ED1C24" align="center" width="100%" size="1" noshade=""
                            style="margin: 0;border-color: #0d74a9;">
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="top" style="
      border-collapse: collapse;
      border-spacing: 0;
      margin: 0;
      padding: 0;
      padding-left: 6.25%;
      padding-right: 6.25%;
      width: 87.5%;
      font-size: 16px;
      line-height: 170%;
      padding-top: 5px;
      color: #000000;
      font-family: sans-serif;
      " class="paragraph">
                        <ul>
                            @foreach($deposits as $deposit)
                                <li style="font-size: 18px;">Deposit:
                                    <b><a href="{{route('deposit.index',['id'=>$deposit->id])}}">{{$deposit->institute->institution_name ?? ''}}
                                            , {{$deposit->branch->branch_name ?? ''}}
                                            , {{$deposit->document_no ?? ''}}</a></b>
                                    <br>
                                    Transaction Start:<b>{{$deposit->trans_date_en}} </b>
                                    <br>
                                    Mature Date: <b>{{$deposit->mature_date_en}}  </b>
                                    <br>
                                    Expiry Days:<b>{{$deposit->expiry_days}} Days</b>
                                </li>
                            @endforeach

                        </ul>
                    </td>
                </tr>


                <tr>
                    <td align="left" valign="top" style="
          border-collapse: collapse;
          border-spacing: 0;
          margin: 0;
          padding: 0;
          padding-left: 6.25%;
          padding-right: 6.25%;
          width: 87.5%;
          font-size: 16px;
          line-height: 12px;
          padding-top: 5px;
          color: #39a9a4;
          font-family: sans-serif;
          " class="paragraph">
                        BMP IMS <br>
                        <a href="mailto:contact@bmpinfology.com" target="_blank"
                           style="color: #127DB3; font-family: sans-serif; font-size: 17px; font-weight: 400; line-height: 160%;">contact@bmpinfology.com</a><br>
                        www.bmpinfology.com
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
      padding-top: 25px;" class="line">
                        <hr color="#ED1C24" align="center" width="100%" size="1" noshade=""
                            style="margin: 0;padding: 0;border-color: #0d74a9;">
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 17px; font-weight: 400; line-height: 160%;
      padding-top: 20px;
      padding-bottom: 25px;
      color: #000000;
      font-family: sans-serif;" class="paragraph">
                        <a target="_blank" style="text-decoration: none;" href="https://bmpinfology.com/">
                            <img border="0" vspace="0" hspace="0"
                                 style="padding: 0;margin: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;border: none;display: block;color: #000000;width: 70px;"
                                 src="http://bmpinfology.com/wp-content/themes/bmpinfology/vault/images/bmp-infology-logo.png"
                                 alt="H" title="Highly compatible" width="200px">
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" align="center" width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
  max-width: 560px;" class="wrapper">
                <tbody>
                <tr>
                    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
      padding-top: 25px;" class="social-icons">
                        <table width="256" border="0" cellpadding="0" cellspacing="0" align="center"
                               style="border-collapse: collapse; border-spacing: 0; padding: 0;">
                            <tbody>
                            <tr>
                                <td align="center" valign="middle"
                                    style="margin: 0; padding: 0; padding-left: 10px; padding-right: 10px; border-collapse: collapse; border-spacing: 0;">
                                    <a target="_blank" href="https://facebook.com/bmpinfology"
                                       style="text-decoration: none;">
                                        <img border="0" vspace="0" hspace="0"
                                             style="padding: 0; margin: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: inline-block; color: #000000;"
                                             alt="" title="Facebook" width="44" height="44"
                                             src="https://cdn.carport1.com/2019/01/facebook.png">
                                    </a>
                                </td>
                                <td align="center" valign="middle"
                                    style="margin: 0; padding: 0; padding-left: 10px; padding-right: 10px; border-collapse: collapse; border-spacing: 0;">
                                    <a target="_blank" href="https://www.twitter.com/bmpinfology/"
                                       style="text-decoration: none;">
                                        <img border="0" vspace="0" hspace="0"
                                             style="padding: 0; margin: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: inline-block; color: #000000;"
                                             alt="T" title="Twitter" width="44" height="44"
                                             src="https://cdn.carport1.com/2019/01/twitter.png">
                                    </a>
                                </td>
                                <td align="center" valign="middle"
                                    style="margin: 0; padding: 0; padding-left: 10px; padding-right: 10px; border-collapse: collapse; border-spacing: 0;">
                                    <a target="_blank" href="https://www.instagram.com/bmpinfology/"
                                       style="text-decoration: none;">
                                        <img border="0" vspace="0" hspace="0" style="padding: 0; margin: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: inline-block;
          color: #000000;" alt="G" title="Google Plus" width="44" height="44"
                                             src="https://cdn.carport1.com/2019/01/googleplus.png">
                                    </a>
                                </td>
                                <td align="center" valign="middle"
                                    style="margin: 0; padding: 0; padding-left: 10px; padding-right: 10px; border-collapse: collapse; border-spacing: 0;">
                                    <a target="_blank" href="https://www.instagram.com/bmpinfology/"
                                       style="text-decoration: none;">
                                        <img border="0" vspace="0" hspace="0"
                                             style="padding: 0; margin: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: inline-block; color: #000000;"
                                             alt="I" title="Instagram" width="44" height="44"
                                             src="https://cdn.carport1.com/2019/01/instagram.png">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <br>
                                    <br>
                                    <br>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <!-- End of WRAPPER -->
                </tbody>
            </table>
            <!-- End of SECTION / BACKGROUND -->
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>