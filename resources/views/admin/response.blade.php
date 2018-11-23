@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/iconfonts/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/vendor.bundle.addons.css')}}">
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}"/>


    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
                <a class="navbar-brand brand-logo">
                    <img src="{{asset('images/admin.png')}}" alt="logo"/>
                </a>
                <a class="navbar-brand brand-logo-mini">
                    <img src="{{asset('images/admin.png')}}" alt="logo"/>
                </a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center">
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#"
                           data-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-file-document-box"></i>
                            <span class="count">{{$pendientes}}</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown d-none d-xl-inline-block">
                        <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown"
                           aria-expanded="false">
                            <span class="profile-text">Bienvenido, {{$name}}</span>
                            <img class="img-xs rounded-circle" src="{{asset('images/faces/face1.png')}}"
                                 alt="Profile image">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                            <a class="dropdown-item p-0">
                                <div class="d-flex border-bottom">
                                    <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                                        <i class="mdi mdi-bookmark-plus-outline mr-0 text-gray"></i>
                                    </div>
                                    <div
                                        class="py-3 px-4 d-flex align-items-center justify-content-center border-left border-right">
                                        <i class="mdi mdi-account-outline mr-0 text-gray"></i>
                                    </div>
                                    <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                                        <i class="mdi mdi-alarm-check mr-0 text-gray"></i>
                                    </div>
                                </div>
                            </a>
                            <a class="dropdown-item">
                                Cambiar Contraseña
                            </a>

                            <a class="dropdown-item" href="{{url('/admin/logout')}}">
                                Salir
                            </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                        data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item nav-profile">
                        <div class="nav-link">
                            <div class="user-wrapper">
                                <div class="profile-image">
                                    <img src="{{asset('images/faces/face1.png')}}" alt="profile image">
                                </div>
                                <div class="text-wrapper">
                                    <p class="profile-name">{{$name}}</p>
                                    <div>
                                        <small class="designation text-muted">Admin</small>
                                        <span class="status-indicator online"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item hand" id="reload">
                        <a class="nav-link">
                            <i class="menu-icon mdi mdi-television"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item hand">
                        <a class="nav-link" id="graph">
                            <i class="menu-icon mdi mdi-bulletin-board"></i>
                            <span class="menu-title">Graficas</span>
                        </a>
                    </li>
                    <li class="nav-item hand">
                        <a class="nav-link" id="img">
                            <i class="menu-icon mdi mdi-image"></i>
                            <span class="menu-title">Imágenes</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="alert alert-primary" role="alert">
                        <div class="row">
                            <div class="col-md-5">
                                <h4>Mensaje de:</h4>{{$data->remitente}}
                            </div>
                            <div class="col-md-4">
                                <h4>Nombre:</h4> {{$data->nombre}}
                            </div>
                            <div class="col-md-3">
                                <h4>Fecha:</h4> {{$data->created_at}}
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-secondary" role="alert">
                        <h4><b>Asunto:</b> {{$data->asunto}}</h4>
                    </div>

                    <div class="jumbotron jumbotron-fluid" style="padding-top: 20px !important;">
                        <div class="container">
                            <h3>Mensaje:</h3>
                            <p style="font-size: 15px">{{$data->contenido}}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{route('admin.sendResponse')}}" style="padding: 0;">

                        <input type="hidden" name="idUser" value="{{$data->id_user}}">
                        <input type="hidden" name="idSent" value="{{$data->id}}">
                        <input type="hidden" name="destinatario" value="{{$data->remitente}}">
                        <input type="hidden" name="nombre" value="{{$data->nombre}}">
                        <input type="hidden" name="asunto" value="{{$data->asunto}}">
                        <input type="hidden" name="pregunta" value="{{$data->contenido}}">
                        <input type="hidden" name="adminId" value="{{\Illuminate\Support\Facades\Session::get('adminId')}}">

                        <h4>Respuesta:</h4>
                        <textarea class="form-control" name="contenido" rows="5"></textarea>
                        <br>
                        <button class="btn btn-success">Responder!</button>
                    </form>

                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="container-fluid clearfix">
                    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018
                       <a href="#" target="_blank">Datafis S.A.S.</a> All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                    </span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
@endsection


