@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="/dashboard">Dashboard</a></li>
    <li><a href="#0">Service Management</a></li>
    <li class="current"><em>Category</em></li>
</ul>
@endsection

<div class="tableStyle">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-end">
            <a href="servicesCategory" class="linkButton">Create Category</a>
        </div>
        <div class="col-md-12">
            <table id="myTable" class="display table table-bordered responsive nowrap" cellspacing="0">
                <thead>
                    <tr>
                        <th>Column 1</th>
                        <th>Column 2</th>
                        <th>Column 3</th>
                        <th>Column 4</th>
                        <th>Column 5</th>
                        <th>Column 6</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Row 1 Data 1</td>
                        <td>Row 1 Data 2</td>
                        <td>Row 1 Data 1</td>
                        <td>Row 1 Data 2</td>
                        <td>Row 1 Data 1</td>
                        <td class="d-flex justify-content-around"><a href="#" type="button" class="tableButton Update"><i class="fa-solid fa-file-pen"></i></a><button class="tableButton Delete"><i class="fa-solid fa-folder-minus"></i></button></td>
                    </tr>
                    <tr>
                        <td>Row 2 Data 1</td>
                        <td>Row 2 Data 2</td>
                        <td>Row 2 Data 1</td>
                        <td>Row 2 Data 2</td>
                        <td>Row 2 Data 1</td>
                        <td class="d-flex justify-content-around"><a href="#" type="button" class="tableButton Update"><i class="fa-solid fa-file-pen"></i></a><button class="tableButton Delete"><i class="fa-solid fa-folder-minus"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection