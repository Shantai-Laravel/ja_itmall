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
            <div class="row">
                @foreach ($methods as $key => $method)
                    <div class="col-sm-3 text-center">
                        <div class="card">
                          <div class="card-body">
                            <h5 class="card-title">{{ $method->description }}</h5>
                            <p class="card-text"><img src="{{ $method->image->svg }}" alt=""></p>
                            <a href="{{ url('/'. $lang->lang .'/test-mollie/payment/'. $method->id) }}" class="btn btn-success">Choose</a>  <hr>
                            {{ $method->_links->self->href }}
                            @foreach ($method->pricing as $key => $pricing)
                                <p class="text-left">
                                    <small>{{ $pricing->description }} {{ $pricing->fixed->value }} {{ $pricing->fixed->currency }}</small>
                                </p>
                            @endforeach
                          </div>
                        </div>
                      </div>
                @endforeach
            </div>
        </div>

        <script
            src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"
            ></script>
    </body>
</html>
