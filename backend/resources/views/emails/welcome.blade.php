<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
</head>
<body style="margin:0; padding:0; background:#f3f4f6; font-family:Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
        <tr>
            <td align="center">

                <!-- CONTAINER -->
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 5px 15px rgba(0,0,0,0.08);">

                    <!-- HEADER -->
                    <tr>
                        <td style="background:#3b82f6; padding:20px; text-align:center;">
                            <h1 style="color:white; margin:0; font-size:22px;">
                                 Ticket System
                            </h1>
                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding:30px; color:#374151;">

                            <h2 style="margin-top:0; font-size:20px;">
                                Welcome {{ $user->name }} 
                            </h2>

                            <p style="line-height:1.6;">
                                Your account has been successfully verified.
                                You can now start using the platform.
                            </p>

                            <!-- CTA -->
                            <div style="text-align:center; margin:30px 0;">
                                <a href="http://localhost:5173/login"
                                   style="
                                       background:#3b82f6;
                                       color:white;
                                       padding:12px 20px;
                                       border-radius:6px;
                                       text-decoration:none;
                                       font-weight:bold;
                                       display:inline-block;
                                   ">
                                    Go to Dashboard
                                </a>
                            </div>

                            <p style="font-size:14px; color:#6b7280;">
                                If you did not create this account, you can safely ignore this email.
                            </p>

                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background:#f9fafb; padding:20px; text-align:center; font-size:12px; color:#9ca3af;">
                            © {{ date('Y') }} Ticket System • All rights reserved
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>