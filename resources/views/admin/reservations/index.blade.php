@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                  <h4>Reservations Manage</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item">Reservations</li>
                  </ul>
               </div>
            </div>
            <div class="page-body">
               <div class="row">
                 <style>
                     #basic-btn td:nth-child(4), #basic-btn th:nth-child(4){
                        max-width: 100px !important;
                        white-space: inherit !important;
                     }
                     #basic-btn td:nth-child(5), #basic-btn th:nth-child(5){
                        max-width: 200px !important;
                        white-space: inherit !important;
                     }
                 </style>
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
                        <th>Host Name</th>  
                        <th>Guest Name</th>  
                        <th>Confirmation Code</th>  
                        <th>Room Name</th>                          
                        <th>Total Amount</th>                          
                        <th>Status</th>                          
                        <th>Created At</th>                         
                        <th>Updated At</th>                         
                        <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($data) != 0)
                        @foreach($data as $row)
                        <tr>
                            <td>{{$row->id}}</td>                            
                            <td><a href="edit_user/{{$row->host_id}}">{{$row->getUserNameByHostID()}}</a></td>                                                       
                            <td><a href="edit_user/{{$row->user_id}}">{{$row->getUserNameByUserID()}}</a></td>
                            <td>{{$row->code}}</td>                                                       
                            <td><a href="edit_room/{{$row->room_id}}">{{$row->getRoomNameByRoomID()}}</a></td>  
                            <td>{{$row->total}}</td>          
                            <td>{{$row->status}}</td>          
                            <td>{{$row->created_at}}</td>          
                            <td>{{$row->updated_at}}</td>          
                            <td class="text-center" style=" width:50px;">
                                <a href="{{url( 'admin/reservation/detail/' . $row->id )}}" class="btn btn-xs btn-primary" data-toggle="tooltip" title="" data-original-title="Edit">
                                    <i class="icofont icofont-eye"></i>
                                </a>
                                &nbsp;                               
                                <a href="{{url( 'admin/reservation/conversation/' . $row->id )}}" class="btn btn-xs btn-primary" data-toggle="tooltip" title="" data-original-title="Edit">
                                    <i class="icofont icofont-email"></i>
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