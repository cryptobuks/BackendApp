<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel</title>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <style>

        .hand:hover {
            cursor: pointer;
        }

        .login-form-1 {
            padding: 5%;
            box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
        }

        .login-form-1 h3 {
            text-align: center;
            color: #333;
        }

        form {
            padding: 10%;
        }
    </style>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!--<link rel="stylesheet" href="{asset('css/style.css')}}">
    <link rel="stylesheet" href="{asset('vendors/iconfonts/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{asset('vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{asset('vendors/css/vendor.bundle.addons.css')}}">
    <link rel="shortcut icon" href="{asset('images/favicon.png')}}"/>-->
</head>
<body>
<!--<div class="container-scroller">
   nclude('__partials/nav')
   <div class="container-fluid page-body-wrapper">
       include('__partials/menu')
       <div class="main-panel">
           <div class="content-wrapper">
               yield('content')
           </div>
       </div>
       include('__partials/footer')
   </div>

</div> -->
@yield('content')
</body>

<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>

<script>

    $(document).ready(function () {
        $('#flag-div').hide();
        totalMesCategory();
        totalMSGCiudades();
    });

    $('#reload').on('click', function () {
        if (location.href === 'http://transitocurumani.com/ettcurumaniServe/public/admin/dashboard/1') {
            location.reload();
        }

        if (location.href === 'http://transitocurumani.com/ettcurumaniServe/public/admin/dashboard/2') {
            location.reload();
        }

        if (location.href === 'http://transitocurumani.com/ettcurumaniServe/public/admin/dashboard/3') {
            location.reload();
        }

        if (location.href === 'http://transitocurumani.com/ettcurumaniServe/public/admin/dashboard/4') {
            location.reload();
        }

        let loc = location.href;
        let response = 'http://transitocurumani.com/ettcurumaniServe/public/admin/response/';
        let solved = 'http://transitocurumani.com/ettcurumaniServe/public/admin/solved/';
        let graph = 'http://transitocurumani.com/ettcurumaniServe/public/admin/graph';
        let img = 'http://transitocurumani.com/ettcurumaniServe/public/admin/img-panel';

        if (loc.includes(response)) {
            $id = '{{$id}}';
            let replaceUrl = 'http://transitocurumani.com/ettcurumaniServe/public/admin/dashboard/' + $id;
            location.href = replaceUrl;
        }

        if (loc.includes(solved)) {
            $id = '{{$id}}';
            let replaceUrl = 'http://transitocurumani.com/ettcurumaniServe/public/admin/dashboard/' + $id;
            location.href = replaceUrl;
        }

        if (loc.includes(graph)) {
            $id = '{{$id}}';
            let replaceUrl = 'http://transitocurumani.com/ettcurumaniServe/public/admin/dashboard/' + $id;
            location.href = replaceUrl;
        }

        if (loc.includes(img)) {
            $id = '{{$id}}';
            let replaceUrl = 'http://transitocurumani.com/ettcurumaniServe/public/admin/dashboard/' + $id;
            location.href = replaceUrl;
        }
    });
</script>

<script>
    setInterval(() => {
        $id = '{{$id}}';

        $.get("http://transitocurumani.com/ettcurumaniServe/public/admin/pendientes", function (data, status) {
            $('#pendientes1').text(data);
            $('#pendientes2').text(data);
            $('#reloadLabel').text('Hay ' + data + ' Mensaje(s) Pendiente(s) Recargue la pagina para verlos.');
        });

    }, 60000);
</script>

<script>
    $('#show').on('click', function () {
        if ($(this).hasClass('btn-success')) {
            $(this).removeClass('btn-success');
            $(this).addClass('btn-danger');
            $(this).text('Ocultar');
            $('#flag-div').show();
        } else {
            $(this).removeClass('btn-danger');
            $(this).addClass('btn-success');
            $(this).text('Ver');
            $('#flag-div').hide();
        }
    });
</script>

<script>
    $('#graph').on('click', function () {
        location.href = 'http://transitocurumani.com/ettcurumaniServe/public/admin/graph/';
    });

    $('#img').on('click', function () {
        location.href = 'http://transitocurumani.com/ettcurumaniServe/public/admin/img-panel';
    });
</script>

<script>
    function totalMesCategory() {
        let $url = 'http://transitocurumani.com/ettcurumaniServe/public/admin/graph/getTotalesDashboard';
        $.ajax({
            url: $url,
            type: "GET",
            data: {
                format: 'json'
            },
            success: function (result) {


                var barOptions = {
                    responsive: true,
                    maintainAspectRatio: true

                };
                var $data = result[0];
                var $json = JSON.stringify($data);
                var response = JSON.parse($json);
                var index = 5;
                var randomColorGenerator = function () {
                    index++;
                    return '#' + (((index + 1500) / 100).toString(16) + '0000000').slice(2, 6);
                };

                var ctx2 = document.getElementById("char").getContext("2d");
                for (var i in response.datasets) {
                    response.datasets[i].backgroundColor = randomColorGenerator();
                }
                new Chart(ctx2, {type: 'bar', data: response, options: barOptions});

            },
            error: function (error) {
                alert("error " + error.error)
            }
        });

    }
</script>

<script>
    function totalMSGCiudades() {
        let $url = 'http://transitocurumani.com/ettcurumaniServe/public/admin/graph/getCiudades';
        $.ajax({
            url: $url,
            type: "GET",
            data: {
                format: 'json'
            },
            success: function (result) {

                var barOptions = {
                    responsive: true,
                    maintainAspectRatio: true

                };
                var $json = JSON.stringify(result[0]);
                var response = JSON.parse($json);
                var index = 5;
                var randomColorGenerator = function () {
                    index++;
                    return '#' + (((index + 1500) / 100).toString(16) + '0000000').slice(2, 6);
                };

                var ctx2 = document.getElementById("charCiudades").getContext("2d");
                for (var i in response.datasets) {
                    response.datasets[i].backgroundColor = randomColorGenerator();
                }
                new Chart(ctx2, {type: 'bar', data: response, options: barOptions});
                let $code = null;

                for (let j in response.sents){
                    $code +=
                        "  <tr>\n" +
                        "   <th scope=\"row\">"+response.sents[j].ciudad+"</th>\n" +
                        "   <td>"+response.sents[j].total+"</td>\n" +
                        "  </tr>";
                }
                $("#tableCiudades tbody").empty();
                $('#tableCiudades tbody').append($code);

            },
            error: function (error) {
                alert("error " + error.error)
            }
        });

    }
</script>

<script>
    $f = $;
    $f(document).ready(function () {
        $f("#mescombo").trigger('change');
    });

    $f("#mescombo").on('change', function () {
        let $mes = $f(this).val();
        let $url = 'http://transitocurumani.com/ettcurumaniServe/public/admin/getResueltos/' + $mes;


        $f.ajax({
            url: $url,
            type: "GET",
            data: {
                format: 'json'
            },
            success: function ($datas) {
                let $code = "";
                for (i = 0; i < $datas.length; i++) {
                    let $urlSolved = 'http://transitocurumani.com/ettcurumaniServe/public/admin/solved/' + $datas[i].id;
                    $code +=
                        "<tr>\n" + "<td>" + $datas[i].id + "</td>\n" +
                        "        <td>" + $datas[i].nombre + "</td>\n" +
                        "        <td>" + $datas[i].asunto + "</td>\n" +
                        "        <td>" + $datas[i].contenido + "</td>\n" +
                        "        <td>" + $datas[i].remitente + "</td>\n" +
                        "        <td>" + $datas[i].hora.date.split(' ')['0'] + "</td>\n" +
                        "        <td>Resuelto</td>\n" +
                        "        <form class=\"ui form\" method=\"GET\"\n" +
                        "              action='" + $urlSolved + "'>\n" +
                        "            <td>\n" +
                        "                <button class=\"btn btn-success\" urlaction='" + $urlSolved + "'>\n" +
                        "                    Ver\n" +
                        "                </button>\n" +
                        "            </td>\n" +
                        "        </form>\n" +
                        "    </tr>";


                }
                $("#table tbody").empty();
                $('#table tbody').append($code);
                $('#pendientesT').text($datas.length);
            },
            error: function ($error) {
                alert("error")
            }
        });
    });
</script>

<script>
    $('#table').on('click', function (ev) {
        let $url = ev.target.attributes['urlaction'].value;
        location.href = $url;
    })
</script>

</html>
