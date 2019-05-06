<div class="subnav hide-print">
  <div class="page-container-responsive">
    <ul class="subnav-list">
      <li>
        <a href="{{ url('dashboard') }}" aria-selected="{{(Route::current()->uri() == 'dashboard') ? 'true' : 'false'}}" class="subnav-item">{{ trans('messages.header.dashboard') }}</a>
      </li>
      <li>
        <a href="{{ url('inbox') }}" aria-selected="{{(Route::current()->uri() == 'inbox' || Route::current()->uri() == 'z/q/{id}' || Route::current()->uri() == 'messaging/qt_with/{id}') ? 'true' : 'false'}}" class="subnav-item">{{ trans('messages.header.inbox') }}</a>
      </li>
      <li>
        <a href="{{ url('rooms') }}" aria-selected="{{(Route::current()->uri() == 'rooms' || Route::current()->uri() == 'my_reservations') ? 'true' : 'false'}}" class="subnav-item">{{ trans_choice('messages.header.your_listing',2) }}</a>
      </li>
      <li>
        <a href="{{ url('trips/current') }}" aria-selected="{{(Route::current()->uri() == 'trips/current' || Route::current()->uri() == 'trips/previous') ? 'true' : 'false'}}" class="subnav-item">{{ trans('messages.header.your_trips') }}</a>
      </li>
      <li>
        <a href="{{ url('users/edit') }}" aria-selected="{{(Route::current()->uri() == 'users/edit' || Route::current()->uri() == 'users/reviews' || Route::current()->uri() == 'users/edit/media' || Route::current()->uri() == 'users/edit_verification') ? 'true' : 'false'}}" class="subnav-item">{{ trans('messages.header.profile') }}</a>
      </li>
      <li>
        <a href="{{ url('users/security') }}" aria-selected="{{(Route::current()->uri() == 'users/security') ? 'true' : 'false'}}" class="subnav-item">{{ trans('messages.header.account') }}</a>
      </li>
      <!--<li>
        <a href="{{ url('account') }}" aria-selected="{{(Route::current()->uri() == 'account' || Route::current()->uri() == 'users/security' || Route::current()->uri() == 'users/payout_preferences/{id}' || Route::current()->uri() == 'users/transaction_history') ? 'true' : 'false'}}" class="subnav-item">{{ trans('messages.header.account') }}</a>
      </li>-->
      <li class="hide">
        <a href="{{ url('invite') }}" class="subnav-item">{{ trans('messages.referrals.travel_credit') }}</a>
      </li>
      <li class="hide">
        <a href="{{ url('disputes') }}" class="subnav-item">{{ trans('messages.disputes.disputes') }}
        @if(Auth::user()->dispute_messages_count > 0)
        <i class="alert-count text-center ">{{Auth::user()->dispute_messages_count}}</i>
        @endif
        </a>
      </li>
    </ul>
  </div>
</div>

@if(Session::has('message') && Auth::check())
  <div class="alert {{ Session::get('alert-class') }}" role="alert">
    <a href="#" class="alert-close" data-dismiss="alert"></a>
  {{ Session::get('message') }}
  </div>
@endif