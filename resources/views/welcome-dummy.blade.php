<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{env('APP_NAME')}}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


        <style>
            html, body {
                font-family: 'Nunito';
                height: 100%;
            }
        </style>
    </head>
    <body>
    <table style="height: 100%;" class="d-flex justify-content-center align-items-center">
        <tbody>
        <tr>
            <td class="align-middle" align="center">
                <img src="{{asset('images/logo.png')}}" style="max-height: 200px"   >

                <div style="font-size: 4em">
                    <?php echo config('app.name') ?>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    </body>
</html>
