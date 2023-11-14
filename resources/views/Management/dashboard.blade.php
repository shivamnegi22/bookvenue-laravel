@extends('layouts.aside')

@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li class="current"><em>Dashboard</em></li>
</ul>
@endsection

<!-- Widgets  -->
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="stat-widget-five">
                    <div class="stat-icon dib flat-color-1">
                        <i class="pe-7s-cash"></i>
                    </div>
                    <div class="stat-content">
                        <div class="text-left dib">
                            <div class="stat-text"><span class="count">{{ $approovedFacility }}</span></div>
                            <div class="stat-heading">Approoved Facility</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="stat-widget-five">
                    <div class="stat-icon dib flat-color-2">
                        <i class="pe-7s-cart"></i>
                    </div>
                    <div class="stat-content">
                        <div class="text-left dib">
                            <div class="stat-text"><span class="count">{{ $pendingFacility }}</span></div>
                            <div class="stat-heading">Pending Facility</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="stat-widget-five">
                    <div class="stat-icon dib flat-color-3">
                        <i class="pe-7s-browser"></i>
                    </div>
                    <div class="stat-content">
                        <div class="text-left dib">
                            <div class="stat-text"><span class="count">{{ $activeFacility }}</span></div>
                            <div class="stat-heading">Active Facility</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="stat-widget-five">
                    <div class="stat-icon dib flat-color-4">
                        <i class="pe-7s-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="text-left dib">
                            <div class="stat-text"><span class="count">{{ $deactiveFacility }}</span></div>
                            <div class="stat-heading">Deactive Facility</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Widgets -->
<!-- Orders -->
<div class="orders">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="box-title">Recent Facility</h4>
                </div>
                <div class="card-body--">
                    <div class="table-stats order-table ov-h">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th class="avatar">Service Category</th>
                                    <th>Name</th>
                                    <th>status</th>
                                    <th>address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($facility as $data)
                                <tr>
                                 
                                    <td> {{\App\Models\Service_category::where('id',$data->service_category_id)->value('name')}} </td>
                                    <td> <span class="name">{{ $data->official_name }}</span> </td>
                                    <td> <span class="product">{{ $data->status }}</span> </td>
                                    <td><span class="count">{{ $data->address }}</span></td>
                                
                                </tr>
                                <tr>
                                @endforeach
                                   
                            </tbody>
                        </table>
                    </div> <!-- /.table-stats -->
                </div>
            </div> <!-- /.card -->
        </div> <!-- /.col-lg-12 -->
    </div>
</div>
<!-- /.orders -->
<!-- To Do and Live Chat -->
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title box-title">To Do List</h4>
                <div class="card-content">
                    <div class="todo-list">
                        <div class="tdl-holder">
                            <div class="tdl-content">
                                <ul>
                                    <li>
                                        <label>
                                            <input type="checkbox"><i class="check-box"></i><span>Conveniently fabricate
                                                interactive technology for ....</span>
                                            <a href='#' class="fa fa-times"></a>
                                            <a href='#' class="fa fa-pencil"></a>
                                            <a href='#' class="fa fa-check"></a>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox"><i class="check-box"></i><span>Creating component
                                                page</span>
                                            <a href='#' class="fa fa-times"></a>
                                            <a href='#' class="fa fa-pencil"></a>
                                            <a href='#' class="fa fa-check"></a>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" checked><i class="check-box"></i><span>Follow back
                                                those who follow
                                                you</span>
                                            <a href='#' class="fa fa-times"></a>
                                            <a href='#' class="fa fa-pencil"></a>
                                            <a href='#' class="fa fa-check"></a>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" checked><i class="check-box"></i><span>Design One
                                                page theme</span>
                                            <a href='#' class="fa fa-times"></a>
                                            <a href='#' class="fa fa-pencil"></a>
                                            <a href='#' class="fa fa-check"></a>
                                        </label>
                                    </li>

                                    <li>
                                        <label>
                                            <input type="checkbox" checked><i class="check-box"></i><span>Creating
                                                component
                                                page</span>
                                            <a href='#' class="fa fa-times"></a>
                                            <a href='#' class="fa fa-pencil"></a>
                                            <a href='#' class="fa fa-check"></a>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div> <!-- /.todo-list -->
                </div>
            </div> <!-- /.card-body -->
        </div><!-- /.card -->
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title box-title">Live Chat</h4>
                <div class="card-content">
                    <div class="messenger-box">
                        <ul>
                            <li>
                                <div class="msg-received msg-container">
                                    <div class="avatar">
                                        <img src="images/avatar/64-1.jpg" alt="">
                                        <div class="send-time">11.11 am</div>
                                    </div>
                                    <div class="msg-box">
                                        <div class="inner-box">
                                            <div class="name">
                                                John Doe
                                            </div>
                                            <div class="meg">
                                                Lorem ipsum dolor sit amet, consectetur adipisicing
                                                elit. Perspiciatis sunt placeat velit ad reiciendis
                                                ipsam
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.msg-received -->
                            </li>
                            <li>
                                <div class="msg-sent msg-container">
                                    <div class="avatar">
                                        <img src="images/avatar/64-2.jpg" alt="">
                                        <div class="send-time">11.11 am</div>
                                    </div>
                                    <div class="msg-box">
                                        <div class="inner-box">
                                            <div class="name">
                                                John Doe
                                            </div>
                                            <div class="meg">
                                                Hay how are you doing?
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.msg-sent -->
                            </li>
                        </ul>
                        <div class="send-mgs">
                            <div class="yourmsg">
                                <input class="form-control" type="text">
                            </div>
                            <button class="btn msg-send-btn">
                                <i class="pe-7s-paper-plane"></i>
                            </button>
                        </div>
                    </div><!-- /.messenger-box -->
                </div>
            </div> <!-- /.card-body -->
        </div><!-- /.card -->
    </div>
</div>
<!-- /To Do and Live Chat -->
@endsection