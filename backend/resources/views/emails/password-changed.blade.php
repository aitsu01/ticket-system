<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Changed</title>
</head>

<body style="margin:0; padding:0; background:#f3f4f6; font-family: Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:20px;">
        <tr>
            <td align="center">

                <!-- CONTAINER -->
                <table width="500" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden;">

                    <!-- HEADER -->
                    <tr>
                        <td style="background:#3b82f6; color:white; padding:20px; text-align:center;">
                            <h2 style="margin:0;">Ticket System</h2>
                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding:30px; text-align:center;">

                            <h3 style="margin-bottom:10px;">Password Updated</h3>

                            <p style="color:#555; font-size:14px;">
                                Your password has been successfully changed.
                            </p>

                            <p style="color:#555; font-size:14px;">
                                If this wasn't you, please secure your account immediately.
                            </p>

                            <!-- BUTTON -->
                            <a href="http://localhost:5173/login"
                               style="
                                display:inline-block;
                                margin-top:20px;
                                padding:10px 20px;
                                background:#3b82f6;
                                color:white;
                                text-decoration:none;
                                border-radius:5px;
                                font-size:14px;
                               ">
                                Go to Login
                            </a>

                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background:#f9fafb; text-align:center; padding:15px; font-size:12px; color:#888;">
                            © {{ date('Y') }} Ticket System
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>