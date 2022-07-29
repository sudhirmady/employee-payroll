@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            {{-- message --}}
            {!! Toastr::message() !!}
            <!-- Page Header -->
            <div class="page-header">
                <div class="cmn_card_view mb-4 cmn_ttl_sec">
                    <div class="row">
                        <div class="col-md-6 lft">
                            <h3>Designation Management</h3>
                            <h6>Add your own designations</h6> 
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <div class="icon_with_cnts"> <i class="fas fa-user-friends"></i>
                                <aside>
                                    <strong>{{ $designations->count() }}</strong> 
                                    <span> Total Designations</span> 
                                </aside>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Page Body -->
            <div class="cmn_card_view">
                <div class="row">
                    <div class="col-sm-9">
                        Showing all the designations listed down
                    </div>
                    <div class="col-sm-3">
                        <aside style="margin-left:80px;"> 
                            <button class="btn btn-dark account-btn" data-toggle="modal" data-target="#add_designation"> Add Designation </button> 
                        </aside>
                    </div>                     
                </div>
                <br>

                <div class="row">
                    <div class="col-sm-12 mt-3">
                        @if($designations->isEmpty())
                        <div class="alert alert-warning"> <strong> There are no designations added yet! </strong> </div>
                        @else
                            <table id="dataTable" class="table table-striped table-hover custom-table">
                                <thead>
                                    <tr>
                                        <th scope="col">S.no</th>
                                        <th scope="col">Designation</th>
                                        <th scope="col">Created on </th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($designations as $key => $desig)
                                    <tr>
                                        <td> {{ $key + 1 }} </td>
                                        <td> {{ $desig->name }} </td>
                                        <td> {{ $desig->created_at->translatedFormat('j F Y') }} </td>
                                        <td> 
                                            <a href="#" class="text-dark" role="button" onclick="edit_Modal(this)" data-name="{{$desig->name}}" data-target="#editModal" data-toggle="modal" data-id="{{$desig->id}}"><i class="fas fa-edit"></i></a> &nbsp; &nbsp;
                                            <a href="/designations/delete/{{$desig->id}}" class="delete-confirm-desig text-danger" data-id="{{$desig->id}}" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Page Body -->
            
             <!-- Add Employee Modal -->
            <div id="add_designation" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Please add the designation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('organisation/designations/add') }}" method="POST">
                                @csrf
                                <div class="row">

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Designation Name <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="desig" name="name" placeholder="Enter Designation Name">
                                        </div>
                                    </div>
                                </div>                          
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn">Submit</button>
                                </div>
                            </form>
        
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Add Employee Modal -->

             <!-- Edit Employee Modal -->
            <div id="editModal" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Please edit the designation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('organisation/designations/edit') }}" method="POST">
                                {{ method_field('POST') }}
                              @csrf
                              <input type="hidden" class="form-control" id="id" name="id">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Designation Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control"  id="name" name="name">
                                        </div>
                                    </div>
                                </div>                          
                                <div class="submit-section">
                                    <button type="submit" class="btn btn-primary submit-btn">Update Record</button>
                                </div>
                            </form>
                          
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Edit Employee Modal -->
                              

        </div> 
    </div>
    <script src="{{ URL::to('assets/js/jquery-3.5.1.min.js') }}"></script>
    
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            //Table search and paginate filter
            var table = $('#dataTable').DataTable();  
        });

        //fetching pre-data from db for edit 
        function edit_Modal(el) {
            var link = $(el) 
            var modal = $("#editModal") //your modal id

            //here we have only 1 field to update which is name
            var name = link.data('name')
            var id = link.data('id')
            modal.find('#name').val(name);
            modal.find('#id').val(id);
        }

        //Delete the record popup are you sure
        $('.delete-confirm-desig').on('click', function (event) {
            event.preventDefault();
            const url = $(this).attr('href');
            swal({
                title: 'Are you sure?',
                text: 'This record details will be permanantly deleted!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then(function(value) {
                if (value) {
                    window.location.href = url;
                }
            });
        });


    </script>
@endsection