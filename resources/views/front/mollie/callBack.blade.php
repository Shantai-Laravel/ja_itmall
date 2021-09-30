<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Mollie test</title>
        <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
            crossorigin="anonymous"
            />
    </head>
    <body>

        <div class="container">
            <div class="row text-center">
                <div class="col-md-12">
                    <h4>Thanks!</h4>
                </div>
                <div class="col-md-12">
                    <hr>
                    <p>
                        <img src="{{ $method->image->svg }}" alt="">
                    </p>
                    <p>
                        Order was placed with success payment <b>{{ $method->description }}</b>.
                    </p>
                    <a href="{{ url('/ro/test-mollie') }}" class="btn btn-success">New</a>
                    
                </div>
            </div>
        </div>

        <script
            src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"
            ></script>
    </body>
</html>
