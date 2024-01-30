<!DOCTYPE html>
<html dir="ltr"
      lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1"
          name="viewport">
    <meta content="noindex,nofollow,noarchive,nosnippet,noodp,notranslate,noimageindex"
          name="robots">
    <title>Successfully logged out</title>

    <style>
        body {
            background: #f4f4f4;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        @media (max-width: 600px) {
            #nameplate {
                height: 15px;
            }
        }
    </style>
</head>
<div>
    <div style="width:100%; background:#900; padding:12px 24px;">
        <img alt="logout success page logo"
             height="25"
             id="nameplate"
             src="{{ asset('vendor/ms-graph-api/images/nameplate_Reverse.png') }}">
    </div>

    <div style="margin-top: 4rem;">
        <h1 style="font-size:2rem; text-align:center">You have successfully logged out</h1>
        <a href="{{ env('APP_URL') }}"
           style="display:block;text-align:center;color:#900;text-decoration: underline;font-size:1.5rem;">Click here to login again</a>

    </div>

</div>

</html>
