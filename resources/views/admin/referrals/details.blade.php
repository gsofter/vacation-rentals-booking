@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                  <h4>User Management</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item"><a href="{{route('admin.referrals')}}">Referrals</a></li>
                     <li class="breadcrumb-item">Details</li>
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
                        <th>Referrer Name</th>                        
                        <th>Credited Amount</th>                        
                        <th>Booking Count</th>
                        <th>Listing Count</th>                        
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($data) != 0)
                        @foreach($data as $row)                       
                            <tr>
                                <td>{{$row->user_id}}</td>
                                <td>{{$row->getUsernameByID()}}</td>                                  
                                <td>{{$row->credited_amount}}</td>
                                <td>{{$row->countBooking()}}</td>
                                <td>{{$row->countListingForDetails()}}</td>                                
                                <td class="text-center">
                                    <a href="{{url( 'admin/edit_referral/' . $row->id )}}" class="btn btn-xs btn-primary" data-toggle="tooltip" title="" data-original-title="Edit">                                       
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