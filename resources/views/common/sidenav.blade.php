<ul class="sidenav-list">

@if (Route::current()->uri() == 'rooms' || Route::current()->uri() == 'reservation/{id}' || Route::current()->uri() == 'my_reservations')
  <li>
    <a href="{{ url('rooms') }}" aria-selected="{{ (Route::current()->uri() == 'rooms') ? 'true' : 'false' }}" class="sidenav-item">{{ trans_choice('messages.header.your_listing',2) }}</a>
  </li>
  <li>
    <a href="{{ url('my_reservations') }}" aria-selected="{{ (Route::current()->uri() == 'my_reservations') ? 'true' : 'false' }}" class="sidenav-item">{{ trans('messages.header.your_reservations') }}</a>
  </li>
  <li>
  <a href="{{ url('hosting/requirements') }}" aria-selected="false" class="sidenav-item hide">{{ trans('messages.header.reservation_requirements') }}</a>
  </li>
@endif

@if (Route::current()->uri() == 'trips/current' || Route::current()->uri() == 'trips/previous')
  <li>
    <a class="sidenav-item" aria-selected="{{ (Route::current()->uri() == 'trips/current') ? 'true' : 'false' }}" href="{{ url('/') }}/trips/current">{{ trans('messages.header.your_trips') }}</a>
  </li>
  <li>
    <a class="sidenav-item" aria-selected="{{ (Route::current()->uri() == 'trips/previous') ? 'true' : 'false' }}" href="{{ url('/') }}/trips/previous">{{ trans('messages.header.prev_trips') }}</a>
  </li>
@endif

@if (Route::current()->uri() == 'users/edit' || Route::current()->uri() == 'users/reviews' || Route::current()->uri() == 'users/edit/media' || Route::current()->uri() == 'users/edit_verification')
    <li>
      <a href="{{ url('users/edit') }}" aria-selected="{{ (Route::current()->uri() == 'users/edit') ? 'true' : 'false' }}" class="sidenav-item">{{ trans('messages.header.edit_profile') }}</a>
    </li>
    <li>
      <a href="{{ url('users/edit/media') }}" aria-selected="{{ (Route::current()->uri() == 'users/edit/media') ? 'true' : 'false' }}" class="sidenav-item">{{ trans_choice('messages.header.photo', 2) }}</a>
    </li>
    <li>
      <a href="{{ url('users/edit_verification') }}" aria-selected="{{ (Route::current()->uri() == 'users/edit_verification') ? 'true' : 'false' }}" class="sidenav-item">{{ trans('messages.header.trust_verification') }}</a>
    </li>
    <li>
      <a href="{{ url('users/reviews') }}" aria-selected="{{ (Route::current()->uri() == 'users/reviews') ? 'true' : 'false' }}" class="sidenav-item">{{ trans_choice('messages.header.review', 2) }}</a>
    </li>
    <li>
      <a href="{{ url('users/references') }}" aria-selected="false" class="hide sidenav-item">{{ trans_choice('messages.header.reference', 2) }}</a>
    </li>
@endif

@if (Route::current()->uri() == 'users/security' || Route::current()->uri() == 'users/payout_preferences/{id}' || Route::current()->uri() == 'users/transaction_history')
  <li>
    <a href="{{ url('users/notifications') }}" aria-selected="false" class="hide sidenav-item">{{ trans_choice('messages.header.notification', 2) }}</a>
  </li>

  <li>
    <a href="{{ url('users/payment_methods') }}" aria-selected="false" class="hide sidenav-item">{{ trans_choice('messages.header.payment_method', 2) }}</a>
  </li>

  <li style="display:none;">
    <a href="{{ url('users/payout_preferences/'.Auth::user()->id) }}" aria-selected="{{ (Route::current()->uri() == 'users/payout_preferences/{id}') ? 'true' : 'false' }}" class="sidenav-item">{{ trans('messages.header.payout_preferences') }}</a>
  </li>

  <li style="display:none;">
    <a href="{{ url('users/transaction_history') }}" aria-selected="{{ (Route::current()->uri() == 'users/transaction_history') ? 'true' : 'false'}}" class="sidenav-item">{{ trans('messages.header.transaction_history') }}</a>
  </li>


  <li>
    <a href="{{ url('users/privacy') }}" aria-selected="false" class="hide sidenav-item">{{ trans('messages.header.privacy') }}</a>
  </li>

  <li>
    <a href="{{ url('users/security') }}" aria-selected="{{ (Route::current()->uri() == 'users/security') ? 'true' : 'false' }}" class="sidenav-item">{{ trans('messages.header.security') }}</a>
  </li>

  <li>
    <a href="{{ url('users/settings') }}" aria-selected="false" class="hide sidenav-item">{{ trans('messages.header.settings') }}</a>
  </li>
@endif

</ul>