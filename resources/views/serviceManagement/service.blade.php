@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="/dashboard">Dashboard</a></li>
    <li><a href="#0">Service Management</a></li>
    <li class="current"><em>Service</em></li>
</ul>
@endsection

<div class="tableStyle">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-end">
            <a href="createServices" class="linkButton">Create Services</a>
        </div>
        <div class="col-md-12">
            <table id="myTable" class="display table table-bordered responsive nowrap" cellspacing="0">
                <thead>
                    <tr>
                        <th>Service Category</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($service as $data)
                    <tr>
                    <td>{{\App\Models\Service_category::where('id',$data->service_category_id)->value('name')}}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ substr($data->description, 0, 20) }}</td>
                        @if($data->status == '1')
                        <td>Active</td>
                        @else
                        <td>Deactive</td>
                        @endif
                    
                        <td><a href="{{url('update-service/'.$data->id)}}"><button class="btn btn-success">Edit</button></a>
                        <a href="{{url('delete-service/'.$data->id)}}"> <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                                Delete
                            </button></a>
                    </td>
                    </tr>
                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content blowup">
                                <p class="Heading">Delete</p>
                                <p class="Description">Are you sure you want to delete the entry.</p>
                                <div class="buttonContainer">
                                    <a href="{{url('delete-service/'.$data->id)}}"><button type="button"
                                            class="acceptButton">Yes</button></a>
                                    <button type="button" class="declineButton" data-bs-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Delete Modal End -->

                   @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection