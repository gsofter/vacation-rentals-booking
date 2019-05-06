<div class="subnav wishlists-navbar" data-sticky="true">
    <div class="page-container-responsive">
      <ul class="subnav-list">
        <li>
          <a class="subnav-item" data-route="popular" href="{{ url('/') }}/wishlists/popular" aria-selected="{{(Route::current()->uri() == 'wishlists/popular') ? 'true' : 'false'}}">
             {{ trans('messages.header.popular') }}
          </a>
        </li>
        <li>
          <a class="subnav-item" data-route="picks" href="{{ url('/') }}/wishlists/picks" aria-selected="{{(Route::current()->uri() == 'wishlists/picks') ? 'true' : 'false'}}">
             {{ $site_name }} {{ trans('messages.wishlist.picks') }}
          </a>
        </li>
        @if($count=1)
        <li>
          <a class="subnav-item" data-route="my" href="{{ url('/') }}/wishlists/my" aria-selected="{{(Route::current()->uri() == 'wishlists/my') ? 'true' : 'false'}}">
             {{ trans_choice('messages.wishlist.my_wishlist',2) }}
          </a>
        </li>
        @endif
      </ul>
    </div>
  </div>
  <div class="subnav-placeholder" style="height: 40px;"></div><div class="subnav-placeholder" style="height: 40px;"></div><div class="subnav-placeholder" style="height: 40px;"></div>

@if(Session::has('message') && Auth::check())
  <div class="alert {{ Session::get('alert-class') }}" role="alert">
    <a href="#" class="alert-close" data-dismiss="alert"></a>
  {{ Session::get('message') }}
  </div>
@endif