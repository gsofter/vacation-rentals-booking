@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                  <h4>Property Manager Manage</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item">Property Manager</li>
                  </ul>
               </div>
            </div>
            <div class="page-body">
               <div class="row">
                 
                <div class="col-sm-12">

                    <div class="card">
                    <div class="card-header table-card-header text-right">                            
                        <button id="btn-add"  class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Property Manager</a>
                    </div>
                    <div class="card-block">
                    @include('admin/common/flash-message')

                    @yield('content')
                    <div class="dt-responsive table-responsive">
                    <table id="basic-btn" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>User ID</th>  
                        <th>First Name</th>  
                        <th>Last Name</th>  
                        <th>Email</th>  
                        <th>Access Code</th>  
                        <th>Created</th>  
                        <th>Updated</th>  
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($data) != 0)
                        @foreach($data as $row)
                        <tr>
                            <td>{{$row->id}}</td>                            
                            <td>{{$row->user_id}}</td>                            
                            <td>{{$row->getUserFirstnameByUserID()}}</td>                            
                            <td>{{$row->getUserLastnameByUserID()}}</td>                            
                            <td>{{$row->email}}</td>                            
                            <td>{{$row->access_code}}</td>                            
                            <td>{{$row->created_at}}</td>                            
                            <td>{{$row->updated_at}}</td> 
                        </tr>
                        @endforeach
                    @endif

                    </tbody>
                   
                    </table>
                    </div>
                    </div>
                    </div>
               </div>
            </div>
         </div>


         <div class="modal fade" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST" action="{{url('admin/add_property_manager')}}" accept-charset="UTF-8" class="form-horizontal bordered" role="form">
                        {{ csrf_field() }}
                         <input type="hidden" value="" name="did" id="did">
                        <div class="modal-header">
                        <h4 class="modal-title">Delete Confirm</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                        </div>
                        <div class="modal-body">
                        
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Email<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="email" name="property_email" class="form-control required"  placeholder="email" required>
                                </div>
                            </div>   
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light ">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


         <div id="styleSelector"></div>
      </div>
   </div>
</div>

<script>
    $(document).ready(function() {

        $('#basic-btn').DataTable({
            dom: 'lBfrtip',
            buttons: [{
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [0, ':visible']
                }
            }, {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            }, {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 5]
                }
            },
            'colvis'            
        ],
        "order": [[ 0, "desc" ]]
        });   

        
    });
</script>
@stop