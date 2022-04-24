<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Currencies</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body class="antialiased">
<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
    <div class="container">
        <div class="mt-3 mb-3">
            <h1 class="text-center">Currencies</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-3 mb-3">
                <form method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="ValueId">ValueId</label>
                            <select class="form-control" id="ValueId" name="value_id">

                                @if(is_null(request('value_id')))
                                    <option value="">All</option>
                                @else
                                    <option value="{{request('value_id')}}">{{request('value_id')}}</option>
                                @endif

                                @foreach($items['values'] as $value)
                                    <option value="{{$value}}">{{$value}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="from">From</label>
                            @if(is_null(request('from')))
                                <input id="from" name="from" class="form-control" type="date">
                            @else
                                <input value="{{request('from')}}" id="from" name="from" class="form-control" type="date">
                            @endif
                        </div>
                        <div class="col-md-3">
                            <label for="to">To</label>
                            @if(is_null(request('to')))
                                <input id="to" name="to" class="form-control" type="date">
                            @else
                                <input value="{{request('to')}}" id="to" name="to" class="form-control" type="date">
                            @endif
                        </div>
                        <div class="col-md-3">
                            <br>
                            <button type="submit" class="mt-2 form-control btn btn-primary">Filter data</button>
                        </div>
                    </div>
                </form>
            </div>

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">ValueId</th>
                    <th scope="col">NumCode</th>
                    <th scope="col">CharCode</th>
                    <th scope="col">Name</th>
                    <th scope="col">Value</th>
                    <th scope="col">Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items['currencies'] as $currency)
                <tr>
                    <th>{{$currency->value_id}}</th>
                    <th>{{$currency->num_code}}</th>
                    <th>{{$currency->char_code}}</th>
                    <th>{{$currency->name}}</th>
                    <th>{{$currency->value}}</th>
                    <th>{{$currency->date}}</th>
                </tr>
                @endforeach
                </tbody>
            </table>

            <div class="row">
                <div class="col-md-6">
                    {!! $items['currencies']->links() !!}
                </div>
                <div class="col-md-6">

                    <form method="POST" action="{{route('loadCurrencies')}}">
                        @csrf
                        <div class="d-flex justify-content-center">
                            <input name="days" type="number" min="30" max="250" value="30" class="form-control mr-2">
                            <button type="submit" class="form-control btn btn-primary">Load data from CBR</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
