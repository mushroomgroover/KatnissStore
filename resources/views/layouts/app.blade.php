<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Katniss Store</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('bootstrap-3.3.7-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap-3.3.7-dist/css/bootstrap-theme.min.css') }}">

    <!-- Slick.js -->
    <link rel="stylesheet" href="{{ asset('slick-1.6.0/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('slick-1.6.0/slick/slick-theme.css') }}">

    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>

    <!-- Bootstrap -->
    <script src="{{ asset('bootstrap-3.3.7-dist/js/bootstrap.min.js') }}"></script>

    <!-- Slick.js -->
    <script src="{{ asset('slick-1.6.0/slick/slick.min.js') }}"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('datatables/datatables.min.css') }}">

    <!-- DataTables -->
    <script src="{{ asset('datatables/datatables.min.js') }}"></script>

    <script src="{{ asset('moment/min/moment.min.js') }}"></script>

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }

        .modal .modal-content {
            border-radius: 0;
            width: 50vw;
            top: 50vh;
            left: 50vw;
            transform: translate(-50%,-50%);
        }

        .modal .modal-content .modal-header {
            background-color: rgb(0, 62, 163);
            color: white;
        }

        .modal .modal-content .modal-body {
            background-color: rgb(51, 153, 255);
        }

        .modal .modal-content .modal-footer {
            background-color: rgb(52, 52, 52);
        }

        @media screen and (max-width: 600px) {
            .modal .modal-content {
                width: 100vw;
                top: 0;
            }
        }
    </style>

    <script type="text/javascript">
        $(function() {
            if (typeof(Storage) !== 'undefined') {
                sCart = '';

                if (sessionStorage.cart) {
                    sCart = JSON.parse(sessionStorage.cart);
                }

                var cartTable = $('#tableCart').DataTable({
                    processing: true,
                    // serverSide: true,
                    ajax: {
                        url: '{{ route("datatables.product.cart") }}',
                        type: 'GET',
                        data: {
                            cartItems: sCart
                        }
                    },
                    columns: [
                        {data: 'name', name: 'name'},
                        {data: 'category.name', name: 'category.name'},
                        {data: 'price', render: function (data, type, row) {
                            return 'Php '+data;
                        }},
                        {defaultContent: '<input type="number" class="form-control" name="quantity[]" value="0">'},
                        {data: 'action', defaultContent: '<button class="btn btn-success btn-flat btnEdit"><i class="fa fa-edit"></i></button>&nbsp;<button class="btn btn-danger btn-flat btnDel"><i class="fa fa-trash"></i></button>'},
                    ]
                });

                $('#app-layout .nav.navbar-nav .cartCnt').text(sCart.length);

                $('.cartIcon').click(function() {
                    // cartTable.ajax.reload();
                    cartTable.fnClearTable();                            
                    // cartTable.fnAddData(sCart);                            
                    cartTable.fnDraw();
                });
            } else {
                console.error('No web localstorage in this browser.');
            }
        });
    </script>
</head>
<body id="app-layout">
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header" >

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Katniss Store
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @foreach ($aCats as $aCat)
                        <li><a href="{{ url('/products/'.$aCat->name) }}">{{ $aCat->name }}</a></li>
                    @endforeach
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <hr>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="" class="cartIcon" data-toggle="modal" data-target="#cartModal"><i class="fa fa-btn fa-shopping-cart"></i><span class="cartCnt">0</span></a></li>
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="" data-toggle="modal" data-target="#loginModal">Login/Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-user-circle-o"></i>&nbsp;&nbsp;&nbsp;{{ Auth::user()->first_name.' '.Auth::user()->last_name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="">Profile</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>

                <!-- <form class="navbar-form navbar-right">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </div>
                    </div>
                </form> -->
            </div>
        </div>
    </nav>

    <section id="content">
        @yield('content')
    </section>

    <footer>
        <center>
            Katniss Store 2017
        </center>
    </footer>

    @include('layouts.modal.login')
    @include('layouts.modal.cart')

    <!-- JavaScripts -->
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
