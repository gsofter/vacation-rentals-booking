<div class="host-calendar-container">
    <div class="calendar-month col-lg-12 col-md-12">
        <div class="content_show">
            <div class="content_showhead">
                <h1>Listing Availability</h1>
                <p>Use the calendar below to restrict your listing availability and create custom seasonal pricing for specific dates.</p>
            </div>
            <div class="content_right">
                <div class="content_buttons">
                    @if($result->status == NULL)
                        <a data-prevent-default="" href="{{ url('manage-listing/'.$room_id.'/pricing') }}" class="right_save">{{ trans('messages.lys.back') }}</a>
                    @endif
                    @if($result->status != NULL)
                        <a class="right_save_continue" href="{{ url('manage-listing/'.$room_id.'/terms') }}" data-prevent-default="">{{ trans('messages.lys.next') }}</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="calendar_viewdata" ng-init="room_id={{$room_id}}">            
            <div class="row-space-2 deselect-on-click">                
                <a href="{{url('manage-listing/'.$room_id.'/calendar')}}" class="month-nav month-nav-previous panel text-center" data-year="{{$prev_year}}" data-month="{{$prev_month}}">
                    <i class="icon icon-chevron-left h3"></i>
                </a>
                <a href="{{url('manage-listing/'.$room_id.'/calendar')}}" class="month-nav month-nav-next panel text-center" data-year="{{$next_year}}" data-month="{{$next_month}}">
                    <i class="icon icon-chevron-right h3"></i>
                </a>
                <div class="current-month-selection">
                    <h2>
                        <span class="full-month">
                            {{trans('messages.lys.'.date('F', $local_date))}}
                        </span>
                        <span>
                            {{date('Y', $local_date)}}
                        </span>
                        <span>
                            &nbsp;
                        </span>
                        <span class="current-month-arrow">
                            ▾
                        </span>
                    </h2>
                    {!!Form::select('year_month', $year_month, date('Y-m', $local_date), ['id' => 'calendar_dropdown', 'data-href' => url('manage-listing/'.$room_id.'/calendar')]) !!}
                    <div class="spinner-next-to-month-nav">
                        Just a moment...
                    </div>
                </div>
                @if(request()->segment(1) != 'admin_url')
                    <a class="btn btn-lined lined-custom pull-right" id="js-calendar-settings-btn" href="javascript:void(0)" data-prevent-default="true">
                        <i class="icon icon-cog text-lead"></i>
                        <span>
                            &nbsp;
                        </span>
                        <span class="link-icon__text">
                            {{trans('messages.header.edit_calendar')}}
                        </span>
                    </a>
                @endif
            </div>
            <div class="calendar_scroll">
                <div class="calendar_width">
                    <div class="days-of-week deselect-on-click">
                        <ul class="list-layout clearfix">
                            <li>{{trans('messages.lys.Sunday')}}</li>
                            <li>{{trans('messages.lys.Monday')}}</li>
                            <li>{{trans('messages.lys.Tuesday')}}</li>
                            <li>{{trans('messages.lys.Wednesday')}}</li>
                            <li>{{trans('messages.lys.Thursday')}}</li>
                            <li>{{trans('messages.lys.Friday')}}</li>
                            <li>{{trans('messages.lys.Saturday')}}</li>
                        </ul>
                    </div>
                    <div id="calendar_selection">
                        <div class="days-container panel clearfix">
                            <ul class="list-unstyled">
                                @foreach($calendar_data as $data)
                                    <li class="tile {{@$data['class']}} no-tile-status both get_click" id="{{@$data['date']}}" data-day="{{@$data['day']}}" data-month="" data-year="">
                                        <div class="date">
                                            <span class="day-number">
                                                <span class="date-badge">
                                                    {{@$data['day']}}
                                                </span>
                                                {{--@if($data['date'] == date('Y-m-d'))--}}
                                                {{--<span class="today-label">--}}
                                                {{--{{trans('messages.lys.today')}}--}}
                                                {{--</span>--}}
                                                {{--@endif--}}
                                            </span>
                                            <div class="price">
                                                <span>{{$rooms_price->currency->original_symbol}}</span>
                                                <span class="price_amountlist">{{$rooms_price->price($data['date'])}}</span>
                                            </div>
                                        </div>
                                        <div class="colored-back">
                                        </div>
                                        <div class="previous-price hidden">
                                            <span>{{$rooms_price->currency->original_symbol}}</span>
                                            <span class="price_amountlist">{{$rooms_price->price($data['date'])}}</span>
                                        </div>
                                        @if(((strpos(@$data['class'], 'reserve-checkin') != false) || (strpos(@$data['class'], 'imported-checkin') != false)) && isset($data['reservation_details']))
                                            {{-- @if(strpos(@$data['class'], 'reserve-checkin') != false) --}}
                                            <div class="info_quests d-none d-lg-block">
                                                <i class="flaticon-guest"></i>
                                                <span class="info-badge">{{ $data['reservation_details']->number_of_guests or $data['reservation_details']->guests }}</span>
                                            </div>
                                            <div class="info_nights d-none d-lg-block">
                                                <i class="flaticon-night-symbol-of-the-moon-with-a-cloud-and-stars"></i>
                                                <span class="info-badge">{{ $data['reservation_details']->duration }}</span>
                                            </div>
                                            <div class="info_detail"><i class="icon icon-question"></i></div>
                                            {{-- @elseif(strpos(@$data['class'], 'imported-checkin') != false)
												<div class="info_quests">
													<i class="flaticon-guest"></i>
												</div>
												<div class="info_nights">
													<i class="flaticon-night-symbol-of-the-moon-with-a-cloud-and-stars"></i>
												</div>
												<div class="info_detail"><i class="icon icon-question"></i></div> --}}
                                            
                                            <div class="reservation-details">
                                                <div class="" style="padding-left: 20px; color: #0190e2; margin-bottom: 5px; text-overflow: ellipsis; white-space: nowrap;">
                                                    {{ $data['reservation_details']->seasonal_name or ($data['reservation_details']->user_id  . "-" . $data['reservation_details']->code) }}
                                                </div>
                                                <div class="" style="padding-left: 0">
                                                    <i class="flaticon-enter"></i>
                                                    &nbsp;&nbsp;{{ $data['reservation_details']->checkin_dmy or $data['reservation_details']->seasonal_start_date }}
                                                </div>
                                                <div class="" style="padding-left: 0">
                                                    <i class="flaticon-exit"></i>
                                                    &nbsp;&nbsp;{{ $data['reservation_details']->checkout_dmy or $data['reservation_details']->seasonal_end_date }}
                                                </div>
                                                <div style="padding-left: 20px;">
                                                    <span><i class="icon icon-currency-usd" style="font-size: 20px"></i></span>
                                                    <span>&nbsp;&nbsp;{{ $data['reservation_details']->currency->symbol or $rooms_price->currency->original_symbol }} {{$data['reservation_details']->base_per_night or $data['reservation_details']->price }} / Night
                                                    </span>
                                                </div>
                                                @if(isset($data['reservation_details']->code))
                                                    <div class="" style="padding-left: 21px;">
                                                        Confirmation:
                                                        {{ $data['reservation_details']->code }}
                                                    </div>
                                                    <div class="text-center">
                                                        <a class="alert-link" href="{{ route('reservation.print_confirmation', ['code' => $data['reservation_details']->code ]) }}">View Itinerary</a>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                        
                                        @if($rooms_price->spots_left($data['date']) != '')
                                            <div class="spots_left">
                                                <span class="small h6">{{trans('messages.shared_rooms.spots_left')}} {{$rooms_price->spots_left($data['date'])}}</span>
                                            </div>
                                        @endif
                                        {{--@if($rooms_price->notes($data['date']) != '')--}}
                                        {{--<div class="tile-notes">--}}
                                        {{--<div class="va-container va-container-v va-container-h">--}}
                                        {{--<ul class="tags">--}}
                                        {{--<li><a href="#">{{trans('messages.lys.notes')}}<span><i class="fa fa-hand-o-up"></i> </span></a></li>--}}
                                        {{--</ul>--}}
                                        {{--<span class="va-middle tile-notes-text">{{$rooms_price->notes($data['date'])}}</span>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--@endif--}}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="legend">
                            <div class="legend_item">{{trans('messages.lys.calendar_legend_seasonal')}}<span class="seasonal_price_highlight legend_key"></span></div>
                            <div class="legend_item"> {{trans('messages.lys.calendar_legend_reserved')}} <span class="reserved_highlight legend_key"></span></div>
                            <div class="legend_item">{{trans('messages.lys.calendar_legend_unavailable')}} <span class="unavailable_highlight legend_key"></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        
        <div class="base_price">
            <div class="baseamt_price">
                <div class="table-responsive-container">
                    <table class="dt-responsive no-wrap compact row-border table " id="base_price_tbl">
                        <thead>
                        <tr>
                            <th colspan="6" align="center">{{trans('messages.lys.price_table_base')}}</th>
                        </tr>
                        <tr>
                            <th><h6 class="row-margin-zero">{{ trans('messages.lys.table_col_name') }}</h6></th>
                            <th><h6 class="row-margin-zero">{{trans('messages.lys.nightly')}}</h6></th>
                            <th><h6 class="row-margin-zero"> {{ trans('messages.lys.weekly') }} </h6></th>
                            <th><h6 class="row-margin-zero">{{ trans('messages.lys.monthly') }}</h6></th>
                            <th data-priority="1000"><h6 class="row-margin-zero">{{ trans('messages.lys.min_stay') }}</h6></th>
                            <th data-priority="1"><h6 class="row-margin-zero">{{ trans('messages.lys.table_col_action') }}</h6></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{trans('messages.lys.price_table_base')}}</td>
                            <td>{{$rooms_price->currency->original_symbol}}{{$rooms_price->original_night}}</td>
                            <td>{{$rooms_price->original_week == '0' ? '-' : $rooms_price->currency->original_symbol . $rooms_price->original_week}}</td>
                            <td>{{ $rooms_price->original_month == '0' ? '-' : $rooms_price->currency->original_symbol . $rooms_price->original_month}}</td>
                            <td>{{$rooms_price->minimum_stay == ('0' || null) ? '-' : $rooms_price->minimum_stay . ' ' . trans_choice('messages.lys.nights', $rooms_price->minimum_stay) }}</td>
                            <td><a href="{{url('manage-listing/'.$result->id.'/pricing')}}" title="Edit" class="table_edit"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="bs_nav calendar_price_tbl_nav">
                    <ul class="nav nav-tabs mt-4" id="calendar_pricing_tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#nav-seasonal-tab" aria-controls="nav-seasonal-tab" role="tab" data-toggle="tab">{{trans('messages.lys.price_table_seasonal')}}</a></li>
                        <li role="presentation"><a href="#nav-reservation-tab" aria-controls="nav-reservation-tab" role="tab" data-toggle="tab">{{trans('messages.lys.price_table_reservation')}}</a></li>
                        <li role="presentation"><a href="#nav-not_available-tab" aria-controls="nav-not_available-tab" role="tab" data-toggle="tab">{{ trans('messages.lys.price_table_unavailable')}}</a></li>
                    </ul>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane active" id="nav-seasonal-tab" role="tabpanel" aria-labelledby="nav-seasonal-tab">
                            @if(count($seasonal_price_detail))
                                <div class="table-responsive-container">
                                    <table class="dt-responsive  compact row-border table " id="seasonal_price_detail_tbl">
                                        <thead>
                                        <tr>
                                            <th><h6 class="row-margin-zero"></h6></th>
                                            <th><h6 class="row-margin-zero">{{ trans('messages.lys.table_col_name') }}</h6></th>
                                            <th><h6 class="row-margin-zero">{{trans('messages.lys.nightly')}}</h6></th>
                                            <th><h6 class="row-margin-zero"> {{ trans('messages.lys.weekly') }} </h6></th>
                                            <th><h6 class="row-margin-zero">{{ trans('messages.lys.monthly') }}</h6></th>
                                            <th data-priority="1000"><h6 class="row-margin-zero">{{ trans('messages.lys.min_stay') }}</h6></th>
                                            <th data-priority="1"><h6 class="row-margin-zero">{{ trans('messages.lys.table_col_action') }}</h6></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        
                                        @foreach(@$seasonal_price_detail as $season)
                                            <tr>
                                                <td>{{$season->start_date}}</td>
                                                <td><span class="per_name">{{$season->seasonal_name}}</span><span class="per_dayselect">({{$season->seasonal_start_date}} - {{$season->seasonal_end_date}}) </span></td>
                                                <td>{{ $rooms_price->currency->original_symbol}}{{$season->price}}</td>
                                                <td>{{ $season->week == '0' ? '-' : $rooms_price->currency->original_symbol . $season->week}}</td>
                                                <td>{{ $season->week == '0' ? '-' : $rooms_price->currency->original_symbol . $season->month}}</td>
                                                <td>{{ $season->minimum_stay == ('0' || null) ? '-' : $season->minimum_stay . ' ' .  trans_choice('messages.lys.nights', $season->minimum_stay) }}</td>
                                                <td><a href="javascript:void(0)" title="Edit" class="table_edit edit_seasonal" id="edit_seasonal_{{$season->seasonal_name}}" data-name="{{$season->seasonal_name}}" ><i class="fa fa-pencil"></i></a>
                                                    <a href="javascript:void(0)" class="delete_details delete_seasonal"  data-name="{{$season->seasonal_name}}" ><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="nav-reservation-tab" role="tabpanel" aria-labelledby="nav-reservation-tab">
                            @if(count($reservation_detail))
                                <div class="table-responsive-container">
                                    <table class="dt-responsive  compact row-border table " id="reservation_detail_tbl">
                                        <thead>
                                        <tr>
                                            <th><h6 class="row-margin-zero"></h6></th>
                                            <th><h6 class="row-margin-zero">{{ trans('messages.lys.table_col_name') }}</h6></th>
                                            <th><h6 class="row-margin-zero">{{ trans('messages.lys.table_col_price') }}</h6></th>
                                            <th><h6 class="row-margin-zero">{{ trans('messages.lys.table_col_guests') }}</h6></th>
                                            <th><h6 class="row-margin-zero">{{ trans('messages.lys.table_col_duration') }}</h6></th>
                                            <th><h6 class="row-margin-zero">{{ trans('messages.lys.table_col_type') }}</h6></th>
                                            <th data-priority="1"><h6 class="row-margin-zero">{{ trans('messages.lys.table_col_action') }}</h6></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        
                                        @foreach($reservation_detail as $reservation)
                                            <tr>
                                                <td>{{$reservation->start_date}}</td>
                                                <td><span class="per_name">{{$reservation->seasonal_name}}</span><span class="per_dayselect">({{$reservation->seasonal_start_date}} - {{$reservation->seasonal_end_date}}) </span></td>
                                                <td>{{ $reservation->price == "0" || null ? '-' : $rooms_price->currency->original_symbol . $reservation->price }}</td>
                                                <td> {{ $reservation->guests == "0" || null ? '-' : $reservation->guests }}</td>
                                                <td>{{ $reservation->duration }}</td>
                                                @if($reservation->source == 'Calendar')
                                                    <td>Calendar</td>
                                                @elseif($reservation->source == 'Reservation')
                                                    <td>VR</td>
                                                @else
                                                    <td>Imported</td>
                                                @endif
                                                <td>
                                                    <a href="javascript:void(0)" title="Edit" class="table_edit edit_reservation" id="edit_reservation_{{$reservation->seasonal_name}}" data-name="{{$reservation->seasonal_name}}" data-type="{{$reservation->source}}"><i class="fa fa-pencil"></i></a>
                                                    {{-- todo-vr get reservation id in the $reservation_detail object --}}
                                                    @if(($reservation->source == 'Reservation') && ($reservation->reservation_id() != false))
                                                        <a href="{{ route('reservation.index', ['id' => $reservation->reservation_id() ]) }}" title="View" class="table_view view_reservation" id="view_reservation_{{$reservation->seasonal_name}}" data-name="{{$reservation->seasonal_name}}" ><i class="fa fa-eye"></i></a>
                                                    @endif
                                                    @if(!(($reservation->source == 'Reservation') && ($reservation->status == 'Reserved')))
                                                        <a href="javascript:void(0)" class="delete_details delete_reservation"  data-name="{{$reservation->seasonal_name}}" ><i class="fa fa-trash"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="nav-not_available-tab" role="tabpanel" aria-labelledby="nav-not_available-tab">
                            @if(count($not_available_dates))
                                <div class="table-responsive-container">
                                    <table class="dt-responsive  compact row-border table " id="not_available_dates_tbl">
                                        <thead>
                                        <tr>
                                            <th><h6 class="row-margin-zero"></h6></th>
                                            <th><h6 class="row-margin-zero">Date Name</h6></th>
                                            <th><h6 class="row-margin-zero">Action</h6></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($not_available_dates as $not_available)
                                            {{-- @if($not_available->seasonal_start_date_month == date('F', $local_date)) --}}
                                            <tr>
                                                <td>{{$not_available->start_date}}</td>
                                                <td><span class="per_name">{{$not_available->seasonal_name}}</span><span class="per_dayselect">({{$not_available->seasonal_start_date}} - {{$not_available->seasonal_end_date}}) </span></td>
                                                
                                                <td>
                                                    <a href="javascript:void(0)" title="Edit" class="table_edit edit_unavailable" id="edit_unavailable_{{$not_available->seasonal_name}}" data-name="{{$not_available->seasonal_name}}" ><i class="fa fa-pencil"></i></a>
                                                    <a href="javascript:void(0)" class="delete_details delete_not_available"  data-name="{{$not_available->seasonal_name}}" ><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            {{-- @endif --}}
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="calendar_savebuttons">
            @if($result->status == NULL)
                <a data-prevent-default="" href="{{ url('manage-listing/'.$room_id.'/pricing') }}" class="right_save">{{ trans('messages.lys.back') }}</a>
            @endif
            @if($result->status != NULL)
                <a class="right_save_continue" href="{{ url('manage-listing/'.$room_id.'/terms') }}" data-prevent-default="">
                    {{ trans('messages.lys.next') }}
                </a>
            @endif
        </div>
    </div>    
    
    <div id="calendar_form_group" class="sidebar-overlay" ng-init="rs_errors = []">
        <div class="sidebar-overlay-inner js-section">
            <div class="form-group-header">
                <div style="height: 30px; background: #1fb1a6;">
                    <a href="javascript:void(0)" id="js-close-calendar-settings-btn" class="modal-close" data-prevent-default=""></a>
                </div>
                <div class="js-saving-progress reservation_settings-saving saving-progress" style="display: none;">
                    <h5>{{ trans('messages.lys.saving') }}...
                    </h5>
                </div>
            </div>
            <div id="calendar_form_tabs" class="c-tabs book-it-panel">
                <div class="form-tab-header">
                    <div style="padding: 0 25px;">
                        <h3 class="row-space-4 sidebar-overlay-heading">
                            {{ trans('messages.lys.calendar_settings') }}
                        </h3>
                    </div>
                    <div class="c-tabs-nav">
                        <nav class="tabs-nav" style="display: inline; padding-left: 10px;"><i class="material-icons icon-chevron-left" id="prev"></i></nav>
                        <span href="#" class="c-tabs-nav__link is-active">Reservation</span>
                        <span href="#" class="c-tabs-nav__link">Season</span>
                        <span href="#" class="c-tabs-nav__link">Blocked</span>
                        {{--<span href="#" class="c-tabs-nav__link" style="display: none">Setting</span>--}}
                        {{--<span href="#" class="c-tabs-nav__link" style="display: none">Extra</span>--}}
                        {{--<nav class="tabs-nav" style="display: inline;"><i class="material-icons icon-chevron-right" id="next"></i></nav>--}}
                        <nav class="tabs-nav" style="display: inline;"><span id="next"></span> </nav>
                        {{-- todo-vr add nav icon back when we reactivate calendar settings --}}
                        <div class="c-tab-nav-marker"></div>
                    </div>
                    <div style="height: 1px;"></div>
                </div>
                <div class="c-tab is-active">
                    <div class="c-tab__content">
                        <div class="seasonal_price">
                            <form id="reservation_form_t" data-mode='create'>
                                <div class="ses_time datepicker-wrapper" ng-init="rsv_data.room_id={{$rooms_price->room_id}}">
                                    <div class="col-md-6 col-sm-6 col-6 ses_pop">
                                        <label class="h6">Check in <b class="text-danger">*</b></label>
                                        <input type="text"  id="reservation_checkin_t" name="start_date" readonly="readonly" class="checkin text-truncate input-large input-contrast ui-datepicker-target seasonal_checkin" placeholder="{{ strtolower(DISPLAY_DATE_FORMAT) }}" >
                                        <input type="hidden"  id="formatted_reservation_checkin_t" class="formatted_seasonal_checkin">
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-6 ses_pop1">
                                        <label class="h6">Check out <b class="text-danger">*</b></label>
                                        <input type="text"  id="reservation_checkout_t" name="end_date" readonly="readonly" class="checkin text-truncate input-large input-contrast ui-datepicker-target seasonal_checkout" placeholder="{{ strtolower(DISPLAY_DATE_FORMAT) }}">
                                        <input type="hidden"  id="formatted_reservation_checkout_t" class="formatted_seasonal_checkout">
                                    </div>
                                    <span id="check_date_err" class="check_date_err" style="display: none; color:red;">Your date is already in another reservation, you can cancel/delete it, select a new range of dates or edit the other reservation.</span>
                                </div>
                                
                                <div class="ses_time">
                                    <div class="col-md-12 col-sm-12 col-12 ses_pop1">
                                        <label class="h6">Name <b class="text-danger">*</b> <i rel="tooltip" class="icon icon-question" title="{{ trans('messages.lys.calendar_settings_reservattion_name_info') }}"></i></label>
                                        <input type="text" id="reservation_name_t" name="seasonal_name" ng-model="rsv_data.seasonal_name">
                                        <input type="hidden" id="edit_reservation_name_t" name="edit_seasonal_name" ng-init="rsv_data.edit_seasonal_name=''" ng-model="rsv_data.edit_seasonal_name">
                                        <input type="hidden"  id="reservation_type_t">
                                    </div>
                                    <span id="err_msg" style="display: none; color:red;">Reservation name already used</span>
                                </div>

                                <div class="ses_time">
                                    <div class="col-md-6 col-sm-6 col-6 ses_pop1">
                                        <label class="h6">Price <b class="text-danger">*</b></label>
                                        <div class="pricelist">
                                            <div class="price_doller">{{$rooms_price->currency->original_symbol}}</div>
                                            <input type="text" id="reservation_price_t" name="price" ng-init="rsv_data.price={{$rooms_price->night}}" ng-model="rsv_data.price" >
                                        </div>
                                        <p data-error="price" class="ml-error"></p>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-6 ses_pop1">
                                        <label class="h6">Number of Guests <i rel="tooltip" class="icon icon-question" title="Number of guests for the reservation."></i></label>
                                        <div class="pricelist">                                            
                                            <input type="number" id="reservation_guests_t" name="guests" ng-model="rsv_data.guests">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="ses_time">
                                    <div class="col-md-12 col-sm-12 col-12 ses_pop1">
                                        <label class="h6">Note <b class="text-danger">*</b> <i rel="tooltip" class="icon icon-question" title="Add additional notes to your reservation."></i></label>
                                        <textarea id="reservation_note_t" name="notes" ng-model="rsv_data.notes"></textarea>
                                    </div>
                                    <span id="err_msg" style="display: none; color:red;">Note required</span>
                                </div>
                                
                                <div>
                                    <div class='col-md-6 col-sm-6 col-6 text-left'>
                                        <a class="day_cancel cancel_reservation" id="cancel_reservation_t">Cancel</a>    
                                    </div>                                    
                                    <div class='col-md-6 col-sm-6 col-6 text-right'>
                                        <button class="day_save" type="submit" id="save_reservation_t" name="save">Save</button>    
                                        <a class="day_delete d-none delete_reservation mt-2" id="delete_reservation_t">Delete</a>
                                    </div>                                    
                                </div>
                                <div class="loading global-ajax-form-loader" style="visibility: hidden;"></div>
                            </form>
                        </div>
                        <div class="info-wrapper d-none">
                            <!-- Info Box element v2 style 2 element - light theme -->
                            <div class="ib2-style2 ib2-text-color-light-theme ib2-custom my-3" style="background-color: #ffffff;">
                                <div class="ib2-inner p-2 ">
                                    <!-- Title -->
                                    <span class="ib2-info-message mb-0 fs-smaller" style="border-bottom:none; display: inline-block;">
                                        
                                    </span>
                                    <!--/ Title -->
                                </div>
                                <!--/ Info box v2 style 2 wrapper - .ib2-inner -->
                            </div>
                            <!--/ Info Box element v2 style 2 element - light theme -->
                        </div>
                    </div>
                    <div class="loading global-ajax-form-loader d-none"></div>     <!-- loader -->
                </div>
                
                <div class="c-tab">
                    <div class="c-tab__content">
                        <form id="season_form_t" data-mode='create'>
                            <div class="seasonal_price" ng-init="season_data.room_id={{$rooms_price->room_id}}">                                
                                <div class="ses_time datepicker-wrapper">
                                    <input type="hidden" name="room_id" value="{{$rooms_price->room_id}}">
                                    <div class="col-md-6 col-sm-6 col-6 ses_pop">
                                        <label class="h6">Start Date <b class="text-danger">*</b></label>
                                        <input type="text"  id="seasonal_checkin_t" name="start_date" readonly="readonly" class="checkin text-truncate input-large input-contrast ui-datepicker-target seasonal_checkin" placeholder="{{ strtolower(DISPLAY_DATE_FORMAT) }}" >
                                        <input type="hidden"  id="formatted_seasonal_checkin_t" class="formatted_seasonal_checkin">
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-6 ses_pop1">
                                        <label class="h6">End Date <b class="text-danger">*</b></label>
                                        <input type="text"  id="seasonal_checkout_t" name="end_date" readonly="readonly" class="seasonal_checkout checkin text-truncate input-large input-contrast ui-datepicker-target" placeholder="{{ strtolower(DISPLAY_DATE_FORMAT) }}" >
                                        <input type="hidden"  id="formatted_seasonal_checkout_t" class="formatted_seasonal_checkout" >
                                    </div>
                                    <span id="check_date_err" class="check_date_err" style="display: none; color:red;">Your date is already in another season, you can mark it as closed, select a new range of dates or update the other added season.</span>
                                </div>
                                
                                <div class="ses_time">
                                    <div class="col-md-12 col-sm-12 col-12 ses_pop1">
                                        <label class="h6">Season Name <b class="text-danger">*</b> <i rel="tooltip" class="icon icon-question" title="Each seasonal name must be unique.  If this is an annual or recurring season, try appending the year to the end of the name (i.e. Summer 2018, Summer 2019, etc"></i></label>
                                        <input type="text" id="season_name_t" name="seasonal_name" ng-model="season_data.seasonal_name">
                                        <input type="hidden" id="edit_season_name_t" name="edit_seasonal_name" ng-init="season_data.edit_seasonal_name=''" ng-model="season_data.edit_seasonal_name">
                                    </div>
                                    <span id="err_msg" style="display: none; color:red;">Season name Already used</span>
                                </div>
                                <div class="ses_time">
                                    <div class="col-md-6 col-sm-6 col-6 ses_pop1">
                                        <label class="h6">Price <b class="text-danger">*</b></label>
                                        <div class="pricelist">
                                            <div class="price_doller">{{$rooms_price->currency->original_symbol}}</div>
                                            <input type="text" id="seasonal_price_t" name="price" ng-model="season_data.price">
                                        </div>
                                        <p data-error="price" class="ml-error"></p>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-6 ses_pop1">
                                        <label class="h6">Price per Guest <i rel="tooltip" class="icon icon-question" title="Extra cost per guest per day"></i></label>
                                        <div class="pricelist">
                                            <div class="price_doller">{{$rooms_price->currency->original_symbol}}</div>
                                            <input type="text" id="seasonal_additional_price_t" name="additional_guest" ng-init="season_data.additional_guest=0" ng-model="season_data.additional_guest">
                                            <input type="hidden" id="seasonal_guests" name="seasonal_guests" value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="ses_time">
                                    <div class="col-md-6 col-sm-6 col-6 ses_pop1">
                                        <label class="h6"> Weekly Price <i rel="tooltip" class="icon icon-question" title="{{ trans('messages.lys.weekly_price_info') }}"></i></label>
                                        <div class="pricelist"  ng-init="season_data.week=0">
                                            <div class="price_doller">{{$rooms_price->currency->original_symbol}}</div>
                                            <input type="text" id="seasonal_week_t" name="week" ng-model="season_data.week">
                                        </div>
                                        <p data-error="week" class="ml-error"></p>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-6 ses_pop1">
                                        <label class="h6">Monthly Price <i rel="tooltip" class="icon icon-question" title="{{ trans('messages.lys.monthly_price_info') }}"></i></label>
                                        <div class="pricelist" ng-init="season_data.month=0">
                                            <div class="price_doller">{{$rooms_price->currency->original_symbol}}</div>
                                            <input type="text" id="seasonal_month_t" name="month" ng-model="season_data.month">
                                        </div>
                                        <p data-error="month" class="ml-error"></p>
                                    </div>
                                </div>
                                <div class="ses_time">
                                    <div class="col-md-6 col-sm-6 col-6 ses_pop1" ng-init="season_data.weekend=0">
                                        <label class="h6">Weekend Price <i rel="tooltip" class="icon icon-question" title="{{ trans('messages.lys.weekend_price_info') }}"></i></label>
                                        <div class="pricelist">
                                            <div class="price_doller">{{$rooms_price->currency->original_symbol}}</div>
                                            <input type="text" id="seasonal_weekend_t" name="weekend" ng-model="season_data.weekend">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-6 ses_pop1">
                                        <label class="h6">Minimum Stay <b class="text-danger">*</b> <i rel="tooltip" class="icon icon-question" title="Minimum amount of nights required for a reservation"></i>  </label>
                                        <div class="pricelist">
                                            <input type="text" id="seasonal_minimum_stay_t" name="minimum_stay" ng-model="season_data.minimum_stay">
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class='col-md-6 col-sm-6 col-6 text-left'>
                                        <a class="day_cancel cancel_reservation" id="cancel_season_t">Cancel</a>
                                    </div>                                    
                                    <div class='col-md-6 col-sm-6 col-6 text-right'>
                                        <button class="day_save" type="submit" id="save_season_t" name="save">Save</button>    
                                        <a class="day_delete d-none delete_seasonal mt-2" id="delete_season_t">Delete</a>
                                    </div>                                    
                                </div>                                
                                <div class="loading global-ajax-form-loader" style="visibility: hidden;"></div>
                            
                            </div>
                        </form>
                    </div>
                    <div class="loading global-ajax-form-loader d-none"></div>
                </div>
                
                <div class="c-tab">
                    <div class="c-tab__content">
                        <form id="unavailable_form_t" ng-init="unavailable_data.room_id={{$rooms_price->room_id}}" data-mode='create'>
                            <div class="seasonal_price">
                                <div class="ses_time datepicker-wrapper">
                                    <input type="hidden" name="room_id" value="{{$rooms_price->room_id}}">
                                    <div class="col-md-6 col-sm-6 col-6 ses_pop">
                                        <label class="h6">Start Date <b class="text-danger">*</b></label>
                                        <input type="text"  id="unvailable_checkin_t" name="start_date" readonly="readonly" class="checkin text-truncate input-large input-contrast ui-datepicker-target seasonal_checkin" placeholder="{{ strtolower(DISPLAY_DATE_FORMAT) }}" >
                                        <input type="hidden"  id="formatted_unavailable_checkin_t" class="formatted_seasonal_checkin">
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-6 ses_pop1">
                                        <label class="h6">End Date <b class="text-danger">*</b></label>
                                        <input type="text"  id="unvailable_checkout_t" name="end_date" readonly="readonly" class="checkin text-truncate input-large input-contrast ui-datepicker-target seasonal_checkout" placeholder="{{ strtolower(DISPLAY_DATE_FORMAT) }}" >
                                        <input type="hidden"  id="formatted_unavailable_checkout_t" class="formatted_seasonal_checkout" >
                                    </div>
                                    <span id="check_date_err" class="check_date_err" style="display: none; color:red;">Your date is already in another reservation or blocked date range, you can select a new range of dates or update the other added reservation/blocked date range.</span>
                                </div>
                                
                                <div class="ses_time">
                                    <div class="col-md-12 col-sm-12 col-12 ses_pop1">
                                        <label class="h6">Name <b class="text-danger">*</b> <i rel="tooltip" class="icon icon-question" title="Each blocked date range must be unique.  Please note:  guests cannot checkin or checkout on the start/end dates of a blocked date range. "></i></label>
                                        <input type="text" id="unavailable_name_t" name="seasonal_name" ng-model="unavailable_data.seasonal_name">
                                        <input type="hidden" id="edit_unavailable_name_t" name="edit_seasonal_name" ng-init="unavailable_data.edit_seasonal_name=''" ng-model="unavailable_data.edit_seasonal_name">
                                    </div>
                                    <span id="err_msg" style="display: none; color:red;">Season name Already used</span>
                                </div>
                                
                                <div>
                                    <div class='col-md-6 col-sm-6 col-6 text-left'>
                                        <a class="day_cancel cancel_reservation" id="cancel_unavailable_t">Cancel</a>                                        
                                    </div>                                    
                                    <div class='col-md-6 col-sm-6 col-6 text-right'>
                                        <button class="day_save" type="submit" id="save_unavailable_t" name="save">Save</button>    
                                        <a class="day_delete d-none delete_not_available mt-2" id="delete_unavailable_t">Delete</a>
                                    </div>                                    
                                </div>                                
                                <div class="loading global-ajax-form-loader" style="visibility: hidden;"></div>
                            </div>
                        </form>
                    </div>
                    
                    <div class="loading global-ajax-form-loader d-none"></div>
                </div>
                <div class="c-tab">
                    <div class="c-tab__content">
                        {{--<h2>Setting</h2>--}}
                        {{--<ul>--}}
                            {{--<li>Example--}}
                                {{--<ul>--}}
                                    {{--<li>Test</li>--}}
                                    {{--<li>Test</li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    </div>
                </div>
                <div class="c-tab">
                    <div class="c-tab__content">
                        {{--<h2>Extra</h2>--}}
                    </div>
                </div>
            </div><!-- end  #calendar_form_tabs-->
        
        </div>
    </div>
</div>