@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                  <h4>Rooms Management</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item">Rooms</li>
                  </ul>
               </div>
            </div>
            <style>
                #basic-btn, #basic-btn a{
                    font-size: 12px !important;
                    text-align: center                
                }
               
                #basic-btn tbody .btn{
                    padding: 7px;
                }
                #basic-btn tbody .delete-btn{
                    padding: 5px;
                    margin: 2px;
                }
                #basic-btn td,#basic-btn th{
                    max-width: 30px !important;
                    white-space: inherit !important;
                }
                #basic-btn td:nth-child(2){
                    max-width: 150px !important;
                    white-space: inherit !important;
                }
                
               
            </style>
            <div class="page-body">
               <div class="row">
                 
                <div class="col-sm-12">

                    <div class="card">
                    <div class="card-header table-card-header text-right">                            
                        <a href="{{url('admin/add_room')}}" class="btn btn-primary">Add Room</a>
                    </div>
                    <div class="card-block">
                    @include('admin/common/flash-message')

                    @yield('content')
                    
                    <div class="dt-responsive ">
                    <table id="basic-btn"  class=" display table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                        <th >ID</th>
                        <th >Name</th>
                        <th >Host First Name</th>
                        <th >Host Last Name</th>
                        <th >Host Id</th>
                        <th >Address</th>
                        <th >City</th>
                        <th >State</th>
                        {{-- <th >Country</th> --}}
                        <th >Property Type</th>
                        <th >Status</th>
                        <th >Subscriptions</th>
                        <th  >Expira tion</th>                        
                        {{-- <th >Created At</th> --}}
                        {{-- <th >Updated At</th> --}}
                        {{-- <th >Viewed Count</th> --}}
                        {{-- <th >Popular</th> --}}
                        {{-- <th >Recom mended</th> --}}
                        <th >Edit</th>
                        <th >Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($data) != 0)
                        @foreach($data as $row)
                        <tr>
                            <td>{{$row->id}}</td>
                            <td>{{$row->name}}</td>
                            <td>{{$row->getFirstnameByUserID()}}</td>                            
                            <td>{{$row->getlastnameByUserID()}}</td>
                            <td><a href="{{url( 'admin/edit_user/' . $row->user_id )}}">{{$row->user_id}}</a></td>
                            <td>{{$row->getRoomAddressByID()}}</td>
                            <td>{{$row->getRoomCityByID()}}</td>
                            <td>{{$row->getRoomStateByID()}}</td>
                            {{-- <td>{{$row->getRoomCountryByID()}}</td>                             --}}
                            <td>{{$row->property_type}}</td>
                            <td>
                                @php
                                if($row->status=="Draft"){
                                    echo '<button class="btn btn-danger"  style="cursor: not-allowed;">'.$row->status.'</button>';
                                }else if($row->status=="Listed"){
                                    echo '<a href="'.url('admin/publish_room/' . $row->id ).'" class="btn btn-success">'.$row->status.'</a>';
                                }else{
                                    echo '<a href="'.url('admin/publish_room/' . $row->id ).'" class="btn btn-warning" >'.$row->status.'</a>';
                                }
                                @endphp
                            </td>
                            <td>
                                {!! $row->hasActiveSubscription() ? '<span class="label label-success">'.$row->getMembership().'</span>' : ''!!}
                            </td>
                            <td>{{strtotime($row->subscription_end_date)>19880514?date('d/m/Y', strtotime($row->subscription_end_date)):"n/a"}}</td>
                            {{-- <td>{{date('d/m/Y', strtotime($row->created_at))}}</td> --}}
                            {{-- <td>{{date('d/m/Y', strtotime($row->update_at))}}</td> --}}
                            {{-- <td>{{$row->views_count}}</td> --}}
                            {{-- <td>                                
                                @php
                                if($row->popular=="Yes"){
                                    echo '<a href="'.url('admin/popular_room/' . $row->id ).'" class="btn btn-success">'.$row->popular.'</a>';
                                }else{
                                    echo '<a href="'.url('admin/popular_room/' . $row->id ).'" class="btn btn-warning" style="">'.$row->popular.'</a>';
                                }
                                @endphp                                
                            <td>                                
                                @php
                                if($row->recommended=="Yes"){
                                    echo '<a href="'.url('admin/recommended_room/' . $row->id ).'" class="btn btn-success">'.$row->recommended.'</a>';
                                }else{
                                    echo '<a href="'.url('admin/recommended_room/' . $row->id ).'" class="btn btn-warning" style="">'.$row->recommended.'</a>';
                                }
                                @endphp     --}}
                            <td>
                                <a href="{{url( 'admin/edit_room/' . $row->id )}}" class="btn btn-xs btn-primary" data-toggle="tooltip" title="" data-original-title="Edit">
                                    <i class="icofont icofont-edit"></i>
                                </a>
                                                           
                               
                            </td>    
                            <td>
                                    <button data-id="{{ $row->id }}" class="btn btn-xs btn-danger delete-btn">
                                            <i class="icofont icofont-ui-delete"></i>
                                        </a>
                                    </td>                        
                        </tr>
                        @endforeach
                    @endif

                    </tbody>
                   
                    </table>

                    </div>
                        <div class="text-right" style="position: absolute;right: 0;">
                        </div>
                    </div>
                    </div>
               </div>
            </div>
         </div>


         <div class="modal fade" id="default-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST" action="{{url('admin/delete_room')}}" accept-charset="UTF-8" class="form-horizontal bordered" role="form">
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
            //dom: 'lBfrtip',
            responsive: true,
            "sPaginationType": "full_numbers",
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
        "order": [[ 0, "desc" ]],
        "lengthMenu": [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, "All"]]
        });   
        
        $(document).on('click', '.delete-btn', function(){
            var did = $(this).attr('data-id');
            $('#did').val(did);
            $('#default-Modal').modal("show");
        });
    
    });
</script>
@stop