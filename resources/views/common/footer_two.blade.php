  <div id="footer" class="pull-left container-brand-dark footer-surround footer-container" style="width:100%; background-image:url({{$footer_cover_image}})">
 <footer class="page-container-responsive" ng-controller="footer">
  <div class="row row-condensed" style="     padding-bottom: 40px;border-bottom: 1px solid rgb(220, 224, 224) ! important;">

    <div class="col-md-3 th_foot ">
      <div class="language-curr-picker clearfix">
        <div class="select select-large select-block row-space-2">
  <label id="language-selector-label" class="screen-reader-only">
    {{ trans('messages.footer.choose_language') }}
  </label>
 {!! Form::select('language',$language, (Session::get('language')) ? Session::get('language') : $default_language[0]->value, ['class' => 'language-selector footer-select', 'aria-labelledby' => 'language-selector-label', 'id' => 'language_footer']) !!}
</div>

<div class="select select-large select-block row-space-2">
  <label id="currency-selector-label" class="screen-reader-only">{{ trans('messages.footer.choose_currency') }}</label>
  {!! Form::select('currency',$currency, (Session::get('currency')) ? Session::get('currency') : $default_currency[0]->code, ['class' => 'currency-selector footer-select', 'aria-labelledby' => 'currency-selector-label', 'id' => 'currency_footer']) !!}
</div>

        <div class="cx-number"></div>
      </div>
    </div>

    <div class="col-md-3 hide-sm">
    <div class="foot-column">
      <h2 class="h5 font_strong">{{ trans('messages.footer.company') }}</h2>
      <ul class="list-layout">
      @foreach($company_pages as $company_page)
        <li><a href="{{ url($company_page->url) }}" class="link-contrast">{{ $company_page->name }}</a></li>

      @endforeach
       <li> <a href="{{ url('contact') }}" class="link-contrast">Contact Us</a></li>
      </ul>
      </div>
    </div>

    <div class="col-md-3 hide-sm">
     <div class="foot-column">
      <h2 class="h5 font_strong">{{ trans('messages.footer.discover') }}</h2>
      <ul class="list-layout">
        <li><a href="{{ url('invite') }}" class="link-contrast">{{ trans('messages.referrals.travel_credit') }}</a></li>
      @foreach($discover_pages as $discover_page)
        <li><a href="{{ url($discover_page->url) }}" class="link-contrast">{{ $discover_page->name }}</a></li>
      @endforeach
      </ul>
      </div>
    </div>

    <div class="col-md-3 hide-sm">
     <div class="foot-column">
      <h2 class="h5 font_strong">{{ trans('messages.footer.hosting') }}</h2>
      <ul class="list-layout">
      @foreach($hosting_pages as $hosting_page)
        <li><a href="{{ url($hosting_page->url) }}" class="link-contrast">{{ $hosting_page->name }}</a></li>
      @endforeach
      </ul>
      </div>
    </div>
     <div class="col-sm-12 space-4 space-top-4 show-sm footadde">
    <ul class="list-layout list-inline text-center h5">
      @foreach($company_pages as $company_page)
        <li><a href="{{ url($company_page->url) }}" class="link-contrast">{{ $company_page->name }}</a></li>
      @endforeach
      <li> <a href="{{ url('contact') }}" class="link-contrast">Contact Us</a></li>
    </ul>
  </div>
  </div>

  <!-- <div class="col-sm-12 space-4 space-top-4 show-sm footrem">
    <ul class="list-layout list-inline text-center h5">
      @foreach($company_pages as $company_page)
        <li><a href="{{ url($company_page->url) }}" class="link-contrast">{{ $company_page->name }}</a></li>
      @endforeach
    </ul>
  </div> -->

 <!-- <hr class="footer-divider space-top-8 space-4 hide-sm"> -->

  <div class="" style="margin-top:20px;">
  <!--  <h2 class="h5 space-4 hide-sm">{{ trans('messages.footer.join_us_on') }}</h2> -->
    <ul class="list-layout list-inline pull-right float-none-sm">
      <link itemprop="url" href="">
      <meta itemprop="logo" content="">
      @for($i=0; $i<count($join_us); $i++)
      @if($join_us[$i]->value)
        <li>
          <a href="{{ $join_us[$i]->value }}" class="link-contrast footer-icon-container" target="_blank">
            <span class="screen-reader-only">{{ ucfirst($join_us[$i]->name) }}</span>
            <i class="icon footer-icon icon-{{ str_replace('_','-',$join_us[$i]->name) }}"></i> 
          </a>        
        </li>
      @endif
      @endfor
    </ul>
    <div class="space-top-2 text-muted pull-left float-none-sm">
      © {{ $site_name }}, Inc.
    </div>
  </div>
</footer>
</div>