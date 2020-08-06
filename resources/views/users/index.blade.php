@extends('layouts.app')
 
@section('content')
 
    <div class="container">
 
        <div class="card card-block">
            <h2 class="card-title">User List
            </h2>
            <button id="btn-add" name="btn-add" class="btn btn-primary btn-xs">Add New User</button>
        </div>
 		<div class="panel-body">    
 
		<a href="{{ URL::to('downloadExcel/xlsx') }}"><button class="btn btn-success">Download Excel xlsx</button></a>
		<a href="{{ URL::to('downloadExcel/csv') }}"><button class="btn btn-success">Download CSV</button></a>
		<form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;" action="{{ URL::to('importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">|
			<input type="file" name="import_file" />
			<button class="btn btn-primary">Import File</button>
		</form>
        <div>
            <table class="table table-inverse">
                <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="users-list" name="users-list">
                @php
                	$i=1;
                @endphp
                @foreach($users as $user)
                    <tr id="user{{$user->id}}">
                        <td>{{$i}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->city}}</td>
                        <td>
                            <button class="btn btn-info open-modal" value="{{$user->id}}">Edit
                            </button>
                            <button class="btn btn-danger delete-link" value="{{$user->id}}">Delete
                            </button>
                        </td>
                    </tr>
                    @php $i++; @endphp
                @endforeach
                </tbody>
            </table>
 
            <div class="modal fade" id="userEditorModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    	<div class="alert alert-danger" style="display:none"></div>
                        <div class="modal-header">
                            <h4 class="modal-title" id="UserEditorModalLabel">User Manager</h4>
                        </div>
                        <div class="modal-body">
                            <form id="modalFormData" name="modalFormData" class="form-horizontal">
 
                                <div class="form-group">
                                    <label for="inputLink" class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" name="name"
                                               placeholder="Enter Name" value="" required>
                                    </div>
                                </div>
 
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="email" name="email"
                                               placeholder="Enter Email" value="" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Phone</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="phone" name="phone"
                                               placeholder="Enter Phone" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">City</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="city" name="city"
                                               placeholder="Enter City" value="">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes
                            </button>
                            <button type="button" class="btn btn-danger btn-close" data-dismiss="modal">Close
                            </button>
                            <input type="hidden" id="user_id" name="user_id" value="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
@endsection