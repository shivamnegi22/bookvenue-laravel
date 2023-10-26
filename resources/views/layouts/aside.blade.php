<!doctype html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Giks - BookVenue</title>
    <meta name="description" content="Giks">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <link rel="stylesheet" href="{{asset('assest/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assest/css/form.css')}}">
    <link rel="stylesheet" href="{{asset('assest/css/table.css')}}">
</head>

<body>
    <!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                        <a href="{{url('dashboard')}}"><i class="menu-icon fa-solid fa-laptop"></i>Dashboard </a>
                    </li>
                    <li class="menu-title">Facility Management</li><!-- /.menu-title -->
                    <!-- <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa-solid fa-cogs"></i>Components</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa-solid fa-puzzle-piece"></i><a href="ui-buttons.html">Buttons</a></li>
                            <li><i class="fa-solid fa-id-badge"></i><a href="ui-badges.html">Badges</a></li>
                            <li><i class="fa-solid fa-bars"></i><a href="ui-tabs.html">Tabs</a></li>

                            <li><i class="fa-solid fa-id-card-o"></i><a href="ui-cards.html">Cards</a></li>
                            <li><i class="fa-solid fa-exclamation-triangle"></i><a href="ui-alerts.html">Alerts</a></li>
                            <li><i class="fa-solid fa-spinner"></i><a href="ui-progressbar.html">Progress Bars</a></li>
                            <li><i class="fa-solid fa-fire"></i><a href="ui-modals.html">Modals</a></li>
                            <li><i class="fa-solid fa-book"></i><a href="ui-switches.html">Switches</a></li>
                            <li><i class="fa-solid fa-th"></i><a href="ui-grids.html">Grids</a></li>
                            <li><i class="fa-solid fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li>
                        </ul>
                    </li> -->

                    <li
                        class="menu-item-has-children dropdown {{ Request::is('category','service') ? 'active show' : '' }}">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="{{ Request::is('category','service') ? 'false' : 'true' }}">
                            <i class="menu-icon fa-solid fa-laptop-file"></i>Service Management</a>
                        <ul class="sub-menu children dropdown-menu {{ Request::is('category','service') ? 'show' : '' }}">
                            <li class="{{ Request::is('category') ? 'sub_active' : '' }}"><a href="{{'category'}}">Category</a></li>
                            <li class="{{ Request::is('service') ? 'sub_active' : '' }}"><a href="{{'service'}}">Service</a></li>
                        </ul>
                    </li>
                    <li
                        class="menu-item-has-children dropdown {{ Request::is('createFacility','addServices','') ? 'active show': '' }}">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="{{ Request::is('createFacility','addServices','') ? 'false' : 'true' }}"> <i
                                class="menu-icon fa-solid fa-calendar"></i>Facility Management</a>
                        <ul
                            class="sub-menu children dropdown-menu {{ Request::is('createFacility','addServices','') ? 'show' : '' }}">
                            <li class="{{ Request::is('createFacility') ? 'sub_active' : '' }}"><a href="{{'createFacility'}}">Create Facility</a></li>
                            <li class="{{ Request::is('addServices') ? 'sub_active' : '' }}"><a
                                    href="{{'addServices'}}">Add Services</a></li>
                        </ul>
                    </li>
                    <li
                        class="menu-item-has-children dropdown {{ Request::is('','create-amenities','') ? 'active show': '' }}">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="{{ Request::is('','create-amenities','') ? 'false' : 'true' }}"> <i
                                class="menu-icon fa-solid fa-cog"></i>Configuration</a>
                        <ul
                            class="sub-menu children dropdown-menu {{ Request::is('','create-amenities','') ? 'show' : '' }}">
                            <li class="{{ Request::is('create-amenities') ? 'sub_active' : '' }}"><a
                                    href="{{'create-amenities'}}">Create Amenities</a></li>
                        </ul>
                    </li>
                    <li class="menu-title">Booking Management</li>
                    <li
                        class="menu-item-has-children dropdown {{ Request::is('book-facility','allBooking','') ? 'active show' : '' }}">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="{{ Request::is('book-facility','allBooking','') ? 'false' : 'true' }}"> <i
                                class="menu-icon fa-solid fa-book"></i>Booking</a>
                        <ul
                            class="sub-menu children dropdown-menu {{ Request::is('book-facility','allBooking','') ? 'show' : '' }}">
                            <li class="{{ Request::is('book-facility') ? 'sub_active' : '' }}"><a
                                    href="{{'book-facility'}}">Create Booking</a></li>
                            <li class="{{ Request::is('allBooking') ? 'sub_active' : '' }}"><a
                                    href="{{'allBooking'}}">All Booking</a></li>
                        </ul>
                    </li>
                    <li class="menu-title">Files Upload</li>
                    <li class="{{ Request::is('uploads') ? 'active' : '' }}"><a href="{{'uploads'}}">
                        <i class="menu-icon fa-solid fa-file-arrow-up"></i>Images Uploads</a></li>
                    <!-- <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa-solid fa-th"></i>Forms</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa-solid fa-th"></i><a href="forms-basic.html">Basic Form</a></li>
                            <li><i class="menu-icon fa-solid fa-th"></i><a href="forms-advanced.html">Advanced Form</a></li>
                        </ul>
                    </li> -->
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <header id="header" class="header">
            <div class="top-left">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./">
                        <img src="{{asset('image/bookvenue-logo.png')}}" alt="Logo">
                    </a>
                    <a class="navbar-brand hidden" href="./"><img src="images/logo2.png" alt="Logo"></a>
                    <a id="menuToggle" class="menutoggle"><i class="fa-solid fa-bars"></i></a>
                </div>
            </div>
            <div class="top-right">
                <div class="header-menu">
                    <div class="header-right">
                        @yield('breadcrumb')
                    </div>
                    <div>
                        <div class="header-left">
                            <button class="search-trigger"><i class="fa-solid fa-search"></i></button>
                            <div class="form-inline">
                                <form class="search-form">
                                    <input class="form-control mr-sm-2" type="text" placeholder="Search ..."
                                        aria-label="Search">
                                    <button class="search-close" type="submit"><i class="fa-solid fa-close"></i></button>
                                </form>
                            </div>

                            <div class="dropdown for-notification">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="notification"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-bell"></i>
                                    <span class="count bg-danger">3</span>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="notification">
                                    <p class="red">You have 3 Notification</p>
                                    <a class="dropdown-item media" href="#">
                                        <i class="fa-solid fa-check"></i>
                                        <p>Server #1 overloaded.</p>
                                    </a>
                                    <a class="dropdown-item media" href="#">
                                        <i class="fa-solid fa-info"></i>
                                        <p>Server #2 overloaded.</p>
                                    </a>
                                    <a class="dropdown-item media" href="#">
                                        <i class="fa-solid fa-warning"></i>
                                        <p>Server #3 overloaded.</p>
                                    </a>
                                </div>
                            </div>

                            <div class="dropdown for-message">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="message"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-envelope"></i>
                                    <span class="count bg-primary">4</span>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="message">
                                    <p class="red">You have 4 Mails</p>
                                    <a class="dropdown-item media" href="#">
                                        <span class="photo media-left"><img alt="avatar"
                                                src="images/avatar/1.jpg"></span>
                                        <div class="message media-body">
                                            <span class="name float-left">Jonathan Smith</span>
                                            <span class="time float-right">Just now</span>
                                            <p>Hello, this is an example msg</p>
                                        </div>
                                    </a>
                                    <a class="dropdown-item media" href="#">
                                        <span class="photo media-left"><img alt="avatar"
                                                src="images/avatar/2.jpg"></span>
                                        <div class="message media-body">
                                            <span class="name float-left">Jack Sanders</span>
                                            <span class="time float-right">5 minutes ago</span>
                                            <p>Lorem ipsum dolor sit amet, consectetur</p>
                                        </div>
                                    </a>
                                    <a class="dropdown-item media" href="#">
                                        <span class="photo media-left"><img alt="avatar"
                                                src="images/avatar/3.jpg"></span>
                                        <div class="message media-body">
                                            <span class="name float-left">Cheryl Wheeler</span>
                                            <span class="time float-right">10 minutes ago</span>
                                            <p>Hello, this is an example msg</p>
                                        </div>
                                    </a>
                                    <a class="dropdown-item media" href="#">
                                        <span class="photo media-left"><img alt="avatar"
                                                src="images/avatar/4.jpg"></span>
                                        <div class="message media-body">
                                            <span class="name float-left">Rachel Santos</span>
                                            <span class="time float-right">15 minutes ago</span>
                                            <p>Lorem ipsum dolor sit amet, consectetur</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="user-area dropdown float-right">
                            <a href="#" class="dropdown-toggle active" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <img class="user-avatar rounded-circle" src="{{asset('image/admin.png')}}"
                                    alt="user Avatar">
                            </a>

                            <div class="user-menu dropdown-menu">
                                <a class="nav-link" href="#"><i
                                        class="fa-solid fa- user"></i>{{Auth::user()->getRoleNames()->first()}}</a>

                                <a class="nav-link" href="#"><i class="fa-solid fa- user"></i>Notifications <span
                                        class="count">13</span></a>

                                <a class="nav-link" href="#"><i class="fa fa -cog"></i>Settings</a>

                                <a class="nav-link" href="#"><i class="fa-solid fa-power -off"></i>Logout</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </header>
        <!-- /#header -->
        <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                @yield('content')
            </div>
            <!-- .animated -->
        </div>
        <!-- /.content -->
        <div class="clearfix"></div>
        <!-- Footer -->
        <footer class="site-footer">
            <div class="footer-inner bg-white">
                <div class="row">
                    <div class="col-sm-6">
                        Copyright &copy; <script>
                        document.write(new Date().getFullYear())
                        </script>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-end">
                        Designed by <a href="#">&nbsp;GIKS India Private Limited</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- /.site-footer -->
    </div>
    <!-- /#right-panel -->

    <!-- Scripts -->
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"
        integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"
        integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>

    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.js"></script>
    <script src="{{asset('assest/js/main.js')}}"></script>
    @yield('script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDiCaUv3ZKC-Zlo0Jjt3_AJ6Obs2vFc6w0&libraries=places&callback=initMap" async defer></script>
    <script>
    tinymce.init({
        selector: '#editor'
    });
    </script>
    <script>
    let table = new DataTable('#myTable', {
        responsive: true
    });
    </script>

    
    
</body>

</html>