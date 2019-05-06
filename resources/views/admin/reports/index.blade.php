@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                    <h4>Reports Manage</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item"><a href="{{route('admin.reports')}}">Reports</a></li>
                     <li class="breadcrumb-item">Add</li>
                  </ul>
               </div>
            </div>
            <div class="page-body">
               <div class="row">
                 
                <div class="col-sm-12">

                    <div class="card">
                    <div class="card-header table-card-header">  
                        <div class="row">
                            <div class="col-sm-12 text-left">
                                <h5>Reports Form</h5>
                            </div>                
                        </div>      
                    </div>
                    <style>
                            .page-body div.dt-buttons {
                                text-align: center;
                                margin: auto;
                                float: unset;
                                position: inherit !important;
                                
                            }
                    </style>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-4">   
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label text-right">From</label>
                                    <div class="col-sm-6">
                                        <input id="from"  class="date-dropper form-control required " type="text" value="{{date('Y-m-d')}}" required />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-4">   
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label text-right">To</label>
                                    <div class="col-sm-6">
                                        <input id="to" name="publish_date" class="date-dropper form-control required " type="text" value="{{date('Y-m-d')}}" required />
                                    </div>
                                </div>
                            </div>

                            
                            <div class="col-sm-4">   
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label text-right">Category</label>
                                    <div class="col-sm-6">
                                        <select id="category" class="form-control form-control-default required categories-select"  required>
                                            <option value="User">User</option>
                                            <option value="Rooms">Rooms</option>                                            
                                            <option value="Reservation">Reservation</option> 
                                        </select>
                                    </div>
                                </div>    
                            </div>

                        <div class="col-sm-12">
                            <div id="usertable" class="dt-responsive table-responsive">
                                <table  class="table table-striped table-bordered nowrap basic-btn">
                                    <thead>
                                        <tr>
                                        <th>ID</th>                                       
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Created At</th>     
                                        </tr>
                                    </thead>
                                    <tbody>
                
                                    </tbody>
                                    
                                </table>
                            </div>
                            <div id="roomtable" class="dt-responsive table-responsive">
                                <table  class="table table-striped table-bordered nowrap basic-btn">
                                    <thead>
                                        <tr>
                                        <th>ID</th>                                       
                                        <th>Name</th>
                                        <th>Host Name</th>
                                        <th>Property Type</th>
                                        <th>Room Type</th>
                                        <th>Status</th>
                                        <th>Created At</th>     
                                        </tr>
                                    </thead>
                                    <tbody>
                
                                    </tbody>
                                    
                                </table>
                            </div>
                            <div id="reservationtable" class="dt-responsive table-responsive">
                                <table class="table table-striped table-bordered nowrap basic-btn">
                                    <thead>
                                        <tr>
                                        <th>ID</th>                                       
                                        <th>Host Name</th>
                                        <th>Guest Name</th>
                                        <th>Room Name</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Created At</th>     
                                        </tr>
                                    </thead>
                                    <tbody>
                
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });					
            init();

            function init(){
                $('#roomtable').css('display', 'none');
                $('#reservationtable').css('display', 'none');
                report();
            }
           
            function showTable(flag){
                console.log("showtable"+ flag)
                if(flag == "User"){
                    $('#usertable').css('display', 'inherit');
                    $('#roomtable').css('display', 'none');
                    $('#reservationtable').css('display', 'none');
                }else if(flag == "Rooms"){
                    $('#usertable').css('display', 'none');
                    $('#roomtable').css('display', 'inherit');
                    $('#reservationtable').css('display', 'none');
                }else{
                    $('#usertable').css('display', 'none');
                    $('#roomtable').css('display', 'none');
                    $('#reservationtable').css('display', 'inherit');
                }
            }

            function dataTableConfigue(){
                 $('.basic-btn').DataTable({
                    dom: 'lBfrtp',
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
                retrieve: true,
                paging: false,
                searching: false
                });                   
            }
           
            $(".date-dropper").dateDropper( {
                dropWidth: 200,
                format: "Y-m-d",
                dropPrimaryColor: "#1abc9c", 
                dropBorder: "1px solid #1abc9c"
            });
           

            $(document).on('change', '#from', function(){               
                report();
            });
            $(document).on('change', '#to', function(){               
                report();
            });
            $(document).on('change', '#category', function(){               
                report();
            });

            function report(){
                
                var from        = $('#from').val();
                var to          = $('#to').val();
                var category    = $('#category').val();
                showTable(category);
                console.log(from, to, category)
                $.ajax({
                    type:"POST",
                    url: "/admin/reports/export/" + from + "/" + to + "/" + category,							
                    success: function(result){                 
                        console.log(result);
                        if(result.status == '1'){					
                            var html = '';
                            for(var i = 0; i < result.data.length; i++){							
                                var item = result.data[i];
                                var name = "";
                                if(category == "User"){
                                    html += '<tr>'+
                                            '<td>'+item.id+'</td>'+ 
                                            '<td>'+item.first_name+'</td>'+ 
                                            '<td>'+item.last_name+'</td>'+ 
                                            '<td>'+item.email+'</td>'+ 
                                            '<td>'+item.status+'</td>'+ 
                                            '<td>'+item.created_at+'</td>'+ 
                                            '</tr>';  
                                }else if(category == "Rooms"){
                                    html += '<tr>'+
                                            '<td>'+item.id+'</td>'+ 
                                            '<td style="max-width:250px !important;white-space: inherit;">'+item.name+'</td>'+ 
                                            '<td>'+item.first_name+' '+item.last_name+'</td>'+ 
                                            '<td>'+item.pname+'</td>'+ 
                                            '<td>'+item.rname+'</td>'+ 
                                            '<td>'+item.status+'</td>'+ 
                                            '<td>'+item.created_at+'</td>'+ 
                                            '</tr>'; 
                                }else{
                                    html += '<tr>'+
                                            '<td>'+item.id+'</td>'+ 
                                            '<td>'+item.host_name+'</td>'+ 
                                            '<td>'+item.guest_name+'</td>'+ 
                                            '<td style="max-width:250px !important;white-space: inherit;">'+item.room_name+'</td>'+ 
                                            '<td>'+item.total+'</td>'+ 
                                            '<td>'+item.status+'</td>'+ 
                                            '<td>'+item.created_at+'</td>'+ 
                                            '</tr>'; 
                                }
                                                                                         
                            }
                            console.log(html);
                            if(category == "User"){
                                $('#usertable tbody').html(html);
                            }else if(category == "Rooms"){
                                $('#roomtable tbody').html(html);
                            }else{
                                $('#reservationtable tbody').html(html);
                            }					
                            
                            dataTableConfigue();		
                        }else{
                            console.log("Connect Error!");
                        }
                    }
                });
            }
        
        });   

       
        
    </script>
 
@stop