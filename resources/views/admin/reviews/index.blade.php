@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                  <h4>Reviews Management</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item">Reviews</li>
                  </ul>
               </div>
            </div>
            <div class="page-body">
               <div class="row">
                 
                <div class="col-sm-12">

                    <div class="card">                    
                    <div class="card-block">
                    @include('admin/common/flash-message')

                    @yield('content')
                    <div class="dt-responsive table-responsive">
                    <table id="basic-btn" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Reservation ID</th>
                        <th>Room ID</th>
                        <th>User From</th>
                        <th>User To</th>
                        <th>Review By</th>
                        <th>Comments</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($data) != 0)
                    @php
                        $i = 0;
                    @endphp
                        @foreach($data as $row)
                        @php
                            $i++;
                        @endphp
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$row->reservation_id}}</td>
                            <td>{{$row->room_id}}</td>
                            <td>{{$row->user_from}}</td>                            
                            <td>{{$row->user_to}}</td>
                            <td>{{$row->review_by}}</td>
                            <td>{{$row->comments}}</td>
                            <td>{{$row->status}}</td>
                            <td>{{$row->created_at}}</td>
                            <td>{{$row->updated_at}}</td>                            
                            <td style="width:50px;">
                                <a href="{{url( 'admin/edit_review/' . $row->id )}}" class="btn btn-xs btn-primary" data-toggle="tooltip" title="" data-original-title="Edit">
                                    <i class="icofont icofont-edit"></i>
                                </a>                                
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