@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                  <h4>Help Category Manage</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item">Help Category</li>
                  </ul>
               </div>
            </div>
            <div class="page-body">
               <div class="row">
                 
                <div class="col-sm-12">

                    <div class="card">
                    <div class="card-header table-card-header text-right">                            
                        <a href="{{url('admin/add_help_category')}}" class="btn btn-primary">Add Help Category</a>
                    </div>
                    <div class="card-block">
                    @include('admin/common/flash-message')

                    @yield('content')
                    <div class="dt-responsive table-responsive">
                    <table id="basic-btn" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Name</th>  
                        <th>Description</th>  
                        <th>Status</th>  
                        <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($data) != 0)
                        @foreach($data as $row)
                        <tr>
                            <td>{{$row->id}}</td>                            
                            <td>{{$row->name}}</td>                                                       
                            <td>{{$row->description}}</td>                                                       
                            <td>{{$row->status}}</td>                                                       
                            <td class="text-center">
                                <a href="{{url( 'admin/edit_help_category/' . $row->id )}}" class="btn btn-xs btn-primary" data-toggle="tooltip" title="" data-original-title="Edit">
                                    <i class="icofont icofont-edit"></i>
                                </a>
                                &nbsp;
                                <button data-id="{{ $row->id }}" class="btn btn-xs btn-danger delete-btn">
                                    <i class="icofont icofont-ui-delete"></i>
                                </button>
                            </td>                            
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


         <div class="modal fade" id="default-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST" action="{{url('admin/delete_help_category')}}" accept-charset="UTF-8" class="form-horizontal bordered" role="form">
                        {{ csrf_field() }}
                         <input type="hidden" value="" name="did" id="did">
                        <div class="modal-header">
                        <h4 class="modal-title">Delete Confirm</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                        </div>
                        <div class="modal-body">
                        
                        <h5 class="text-danger text-center">Are you Sure?</h5>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light ">Delete</button>
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

        $(document).on('click', '.delete-btn', function(){
            var did = $(this).attr('data-id');
            $('#did').val(did);
            $('#default-Modal').modal("show");
        });
    
    });
</script>
@stop