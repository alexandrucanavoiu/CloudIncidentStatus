<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Page Not Found :(</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <style>
        @import url(https://fonts.googleapis.com/css?family=Arvo);


        /* SELECTED TEXT */
        ::selection { background: #ff5e99; color: #FFFFFF; text-shadow: 0; }
        ::-moz-selection { background: #ff5e99; color: #FFFFFF; }

        html {
            font-size: 18px;font-size: 1.13rem;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        html, input { font-family: "arvo", "Helvetica Neue", Helvetica, Arial, sans-serif; }



        body {
            background: #4A575A;
            margin: auto;
            color: #fff;
        }


        a {
            -webkit-transition: all 200ms ease;
            -moz-transition: all 200ms ease;
            -ms-transition: all 200ms ease;
            -o-transition: all 200ms ease;
            transition: all 200ms ease;

            -webkit-transform: translate3d(0, 0, 0);
            -webkit-backface-visibility: hidden;

            opacity: 1;
        }

        a:hover {
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)"; /* IE 8 */
            filter: alpha(opacity=50); /* IE7 */
            opacity: 0.6;
        }

        a, a:visited, a:active {
            color: #fff;
            text-decoration: none;
        }

        .unicorn {
            max-width: 100%;
            height: 400px;
            margin: 20px 0 0 26px;
        }

        .container {
            max-width: 400px;
            _width: 400px;
            margin: 0 auto 80px;
            text-align: center;
        }

        h1 {
            margin: 0;
        }

        h2 {
            font-size: 12px;font-size: 1rem;
            font-weight: 400;
            margin: 0;
            padding: 4px 0 10px;
            color: #aaa;
        }

        h3 {
            margin: 20px 0 8px;
            text-align: center;
            font-size: 20px;
            font-weight: 500;
            line-height: 1.4;
            padding: 0 30px;
        }

        .warning {
            margin: 0px 0 30px 0;
            padding: 0px 20px 8px;
        }
        .warning p {
            font-size: 12px;font-size: 0.75rem;
        }

        .warning a {
            display: block;
            margin-top: 30px;
            padding: 20px;
            background: #16A085;
        }


        .copyright {
            font-size: 12px;
            text-align: center;
        }



        /* SVG */
        .unicorn {
            max-width: 100%;
            height: 400px;
            background: url('/404.png') no-repeat center center;
        }



        /* Responsive
        -------------------------------------------------------*/

        /* Desktop only */
        @media only screen and (min-width : 1800px) {
            h2 {
                font-size: 20px;font-size: 1.75rem;

            }
            .warning p {
                font-size: 14px;font-size: 0.88rem;
            }
            .unicorn {
                max-width: 100%;
                height: 400px;
                margin: 60px 0 0 26px;
            }
        }

        @media only screen and (max-width : 568px) {
            body {
                background: #16A085;
            }
            .warning a {
                background: #037c63;
            }
            h2 {
                color: #fff;
            }
        }

        @media only screen and (max-width : 320px) {

            .unicorn {
                height: 150px;
                margin: 20px 0 0 0px !important;
            }
            .four-oh-four {
                height:40px;
                margin: 10px auto 10px;
            }
            h2 {
                font-size: 0.88rem;
                font-weight: bold;
            }
            .warning {
                margin: 0;
            }
            .warning p {
                margin-top: 10px;
                font-size: 0.63rem;
            }
            .warning a {
                margin-top: 20px;
                font-size: 0.63rem;
            }

        }
    </style>
</head>
<body>
<div class="unicorn"></div>
<div class="container">
    <div class="warning">
        <h3>The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</h3>
        <a href="javascript:history.back()">Please go back to the previous page</a>
    </div>

</div>
<script>
    /mobile/i.test(navigator.userAgent) && !window.location.hash && setTimeout(function () {
        window.scrollTo(0, 1);
    }, 1000);
</script>
</body>
</html>
