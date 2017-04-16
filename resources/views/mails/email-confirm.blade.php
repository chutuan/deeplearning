<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Verify Your Email Address</h2>

        <div style="color: #414141;font-size: 14px;">
            Thanks for creating an account with the Cleaner Nerd.
            Please follow use code below to verify your email address
            <div style="width: 100px;text-align: center;padding: 10px;margin: 0 auto;font-weight: bold;font-size: 20px;border: 1px solid #414141;
                    border-radius: 3px;color: #424242;margin-top: 20px;">
                {{ $user->confirmation_code }}
            </div>
        </div>
    </body>
</html>