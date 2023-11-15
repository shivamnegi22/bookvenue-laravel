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
                        <th>Name</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($category as $data)
                    <tr>
                        <td>{{ $data->name }}</td>
                        @if($data->status == '1')
                        <td>Active</td>
                        @else
                        <td>Deactive</td>
                        @endif
                        <td>{{ substr($data->description, 0, 40) }}</td>
                        <td><a href="{{url('update-service-category/'.$data->id)}}"><button
                                    class="tableButton Update">Edit</button></a>
                            <button type="button" class="tableButton Delete" data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content blowup">
            <p class="Heading">Delete</p>
            <p class="Description">Are you sure you want to delete the entry.</p>
            <div class="buttonContainer">
                <a href="{{url('delete-service-category/'.$data->id)}}"><button type="button"
                        class="acceptButton">Yes</button></a>
                <button type="button" class="declineButton" data-bs-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<!-- Delete Modal End -->
@endsection