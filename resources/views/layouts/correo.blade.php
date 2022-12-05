<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet"> 
</head>
<body style="margin: 0; padding: 0; font-family: 'Montserrat', sans-serif;" >
<table cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td>
            <table align="center" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
                <tr>
                    <td align="center" style="padding:40px 0 30px 0;background:#c7caca;">
                        <img src="https://appex.j-pintuexpress.com/img/LogoJP400x81.png" alt="" width="300" style="height:auto;display:block;" />  
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                        <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td>
                                <b>
                                {{--SALUDO--}}
                                @yield('saludo')
                                </b> 
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 20px 0 30px 0;">
                                {{--CONTENIDO--}}
                                @yield('contenido')
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <hr>
                                <p style="font-size: 12px;">
                                    {{--NOTA--}}
                                    @yield('nota')
                                </p>
                            </td>
                        </tr>
                        </table>
                     </td>
                </tr>
                <tr>
                    <td bgcolor="#312a41" style="padding: 30px 30px 30px 30px; color: #c3c0ca;">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="75%">
                                     <a style="text-decoration:none !important; color: #c3c0ca;" href="#">&reg; {{ env('APP_NAME', 'SGS') }}<br/></a>
                                </td>
                                <td align="right" width="25%">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td>
                                                <a href="https://es-la.facebook.com/">
                                                <img src="http://www.tuparte.co/img/mails/fb.png" alt="Twitter" width="38" height="38" style="display: block;" border="0" />
                                                </a>
                                            </td>
                                            <td style="font-size: 0; line-height: 0;" width="20"></td>
                                            <td>
                                                <a href="http://www.twitter.com/">
                                                <img src="http://www.tuparte.co/img/mails/tw.png" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
                                                </a>
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
    </tr>
</table>
</body>
</html>