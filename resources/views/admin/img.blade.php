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
                            <span
                                class="profile-text">Bienvenido, {{\Illuminate\Support\Facades\Session::get('adminName')}}</span>
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
                                    <p class="profile-name">{{\Illuminate\Support\Facades\Session::get('adminName')}}</p>
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

                    <div class="row">
                        @if(isset($error))
                            <div class="alert alert-danger" style="height: 40px; font-size: 15px;">
                                <strong>Error!</strong> {{trim($error)}}
                            </div>
                        @endif
                        @if(isset($success))
                            <div class="alert alert-success" style="height: 40px; font-size: 15px;">
                                <strong>Perfecto!</strong> {{trim($success)}}
                            </div>
                        @endif
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <center>Banner 1</center>
                            <br>

                            <img src="{{$imgURL1}}"
                                 width="500px">
                            <br>
                            <br>
                            <center>
                                <form style="padding: 0" method="POST" enctype="multipart/form-data"
                                      action="{{route('admin.img')}}">
                                    <input class="form-control" type="file" name="image" required id="file1"/>
                                    <input type="hidden" name="type" value="image1">
                                    <input type="hidden" name="id" value="{{$imgID1}}">
                                    <br>
                                    <label>Titulo</label>
                                    <input type="text" class="form-control" name="title" required/>
                                    <br>
                                    <label>Informacion</label>
                                    <br>
                                    <textarea class="form-control" name="contenido" required rows="5"></textarea>
                                    <br>
                                    <button class="btn btn-success">
                                        Cambiar
                                    </button>
                                </form>
                            </center>
                        </div>
                        <div class="col-md-6">
                            <center>Banner 2</center>
                            <br>
                            <img src="{{$imgURL2}}" width="500px">
                            <br>
                            <br>
                            <center>
                                <form style="padding: 0" method="POST" enctype="multipart/form-data"
                                      action="{{route('admin.img')}}">

                                    <input class="form-control" type="file" name="image" required/>
                                    <input type="hidden" name="type" value="image2">
                                    <input type="hidden" name="id" value="{{$imgID2}}">
                                    <br>
                                    <label>Titulo</label>
                                    <input type="text" class="form-control" name="title" required/>
                                    <br>
                                    <label>Informacion</label>
                                    <br>
                                    <textarea class="form-control" name="contenido" required rows="5"></textarea>
                                    <br>
                                    <button class="btn btn-success">
                                        Cambiar
                                    </button>
                                </form>
                            </center>
                        </div>
                    </div>


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


