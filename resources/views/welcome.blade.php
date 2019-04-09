<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">

    <div class="row  ">
        <div class="col-2 border">
            <form method="get" id="filter">

            <select class="form-control-sm" name="filter" id="region">
                <option value="">Choose region</option>
                <option value="central">central</option>
                <option value="eastern">eastern</option>
                <option value="western">western</option>
            </select>
            </form>
        </div>
        <div class="col-2 border">Tara</div>
        <div class="col-2 border">Limba</div>
        <div class="col-2 border">Monedă </div>
        <div class="col-2 border">Latitudine </div>
        <div class="col-2 border">Longitudine </div>
    </div>
            @foreach($data as $linie)
                <div class="row ">
                    <div class="col-2">{!! $linie['zone'] !!}   </div>
                    <div class="col-2">{!! $linie['name'] !!} <br><small>({!! $linie['country_native'] !!})</small></div>
                    <div class="col-2">{!! $linie['language'] !!}   <br><small>({!! $linie['lang_native'] !!})</small></div>
                    <div class="col-2">{!! $linie['currency'] !!}   ({!! $linie['currency_code'] !!})</div>
                    <div class="col-2">{!! $linie['lat'] !!}  </div>
                    <div class="col-2">{!! $linie['long'] !!}  </div>
                </div>

            @endforeach

    <a id="euros" class="btn btn-default" href="">Get EUR countries</a><br>
    <div id="countries"></div>
    </div>

</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#region').change(function () {
       $('#filter').submit();

    })

    $('#euros').click(function (e) {
        e.preventDefault();
        console.log('prev')

        var html ='';
        $.ajax({
            url: "/eurCountries",
            type:"post",

            success:function(data){
                $.each(data,function ($k,$v) {
                    html += $v+',';
                })


                $('#countries').html(html)
            }
        }); //end of ajax
    })

</script>

</body>
</html>
