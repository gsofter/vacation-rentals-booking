@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	
<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                  <h4>Dashboard</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#!">Pages</a></li>
                     <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                  </ul>
               </div>
            </div>
            <div class="page-body">
               <div class="row">
                  <div class="col-md-6 col-xl-4">
                     <div class="card client-blocks dark-primary-border">
                        <div class="card-block">
                           <h5>Total Users</h5>
                           <ul>
                              <li><i class="icofont icofont-ui-user-group text-primary"></i></li>
                              <li class="text-right text-primary">{{ $users_count }}</li>
                           </ul>
                           <hr>
                           <div class="text-center">
                              <a href="#" class="small-box-footer">
                              More info <i class="icofont icofont-rounded-double-right"></i>
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-xl-4">
                     <div class="card client-blocks warning-border">
                        <div class="card-block">
                           <h5>Total Property</h5>
                           <ul>
                              <li><i class="icofont icofont-building-alt text-warning"></i></li>
                              <li class="text-right text-warning">{{ $rooms_count }}</li>
                           </ul>
                           <hr>
                           <div class="text-center">
                              <a href="#" class="small-box-footer">
                              More info <i class="icofont icofont-rounded-double-right"></i>
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-xl-4">
                     <div class="card client-blocks success-border">
                        <div class="card-block">
                           <h5>Total Reservations</h5>
                           <ul>
                              <li><i class="icofont icofont-ui-flight text-success"></i></li>
                              <li class="text-right text-success">{{ $reservations_count }}</li>
                           </ul>
                           <hr>
                           <div class="text-center">
                              <a href="#" class="small-box-footer">
                              More info <i class="icofont icofont-rounded-double-right"></i>
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-xl-4">
                     <div class="card client-blocks dark-primary-border">
                        <div class="card-block">
                           <h5>Today Users</h5>
                           <ul>
                              <li><i class="icofont icofont-ui-user-group text-primary"></i></li>
                              <li class="text-right text-primary">{{ $today_users_count }}</li>
                           </ul>
                           <hr>
                           <div class="text-center">
                              <a href="#" class="small-box-footer">
                              More info <i class="icofont icofont-rounded-double-right"></i>
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-xl-4">
                     <div class="card client-blocks warning-border">
                        <div class="card-block">
                           <h5>Today Rooms</h5>
                           <ul>
                              <li><i class="icofont icofont-building-alt text-warning"></i></li>
                              <li class="text-right text-warning">{{ $today_rooms_count }}</li>
                           </ul>
                           <hr>
                           <div class="text-center">
                              <a href="#" class="small-box-footer">
                              More info <i class="icofont icofont-rounded-double-right"></i>
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-xl-4">
                     <div class="card client-blocks success-border">
                        <div class="card-block">
                           <h5>Today Reservations</h5>
                           <ul>
                              <li><i class="icofont icofont-ui-flight text-success"></i></li>
                              <li class="text-right text-success">{{ $today_reservations_count }}</li>
                           </ul>
                           <hr>
                           <div class="text-center">
                              <a href="#" class="small-box-footer">
                              More info <i class="icofont icofont-rounded-double-right"></i>
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>



            <div class="page-body">
                <input type="hidden" value='{{ $line_chart_data }}' id="line-chart-data">
               <div class="row">
                  <div class="col-sm-8">
                     <div class="card">
                        
                        <div class="card-block">
                           <div class="row">
                              <div class="col-lg-12">
                                        <div class="card-header">
                                                <h5>Sales Graph</h5>      
                                        </div>
                                        <div class="card-block">
                                                <div id="line-example"></div>
                                        </div>
                              </div>
                             
                           </div>
                        </div>
                     </div>
                  </div>

                  
                  <div class="col-sm-4">
                     <div class="card">
                        <div class="card-header">
                                <h5>Calendar(Today)</h5>      
                        </div>
                        <div class="card-block">
                           <div class="row">
                              <div class="col-lg-12">
                                 <div id="clndr-default" class="overflow-hidden bg-grey bg-lighten-3"></div>
                              </div>
                             
                           </div>
                        </div>
                     </div>
                  </div>
                 
               </div>
               <div id="clndr" class="clearfix">
                  <script type="text/template" id="clndr-template">
                     <div class="clndr-controls">                         
                         <div class="current-month">
                             <%= month %>
                                 <%= year %>
                         </div>
                     </div>
                     <div class="clndr-grid">
                         <div class="days-of-the-week clearfix">
                             <% _.each(daysOfTheWeek, function(day) { %>
                                 <div class="header-day">
                                     <%= day %>
                                 </div>
                                 <% }); %>
                         </div>
                         <div class="days">
                             <% _.each(days, function(day) { %>
                                 <div class="<%= day.classes %>" id="<%= day.id %>"><span class="day-number"><%= day.day %></span></div>
                                 <% }); %>
                         </div>
                     </div>
                     
                  </script>
               </div>
            </div>



         </div>
         <div id="styleSelector"></div>
      </div>
   </div>
</div>

<script type="text/javascript" src="{{asset('admin_assets/assets/pages/clndr-calendar/js/clndr-custom.js')}}"></script>
<script type="text/javascript" src="{{asset('admin_assets/assets/pages/chart/morris/morris-custom-chart.js')}}"></script>
@stop