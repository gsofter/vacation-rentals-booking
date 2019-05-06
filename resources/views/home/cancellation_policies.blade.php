@extends('template')
@section('main')
<main id="site-content" role="main">
  <div class="page-container page-container-responsive space-top-4 space-4">
    <h1 class="row-space-2">{{trans('messages.cancellation_policy.cancellation_policies')}}
    </h1>
    <p class="text-lead">
      {{trans('messages.cancellation_policy.site_cancel_policy_description_content', ['site_name' => $site_name])}}
    </p>
    <div class="panel">
      <ul class="panel-header tabs tabs-header" role="tablist" data-permalink="true">
        <li>
          <a href="#flexible" aria-controls="flexible" aria-selected="true" class="tab-item flexible" role="tab">{{trans('messages.cancellation_policy.flexible')}}
          </a>
        </li>
        <li>
          <a href="#moderate" aria-controls="moderate" aria-selected="false" class="tab-item moderate" role="tab">{{trans('messages.cancellation_policy.moderate')}}
          </a>
        </li>
        <li>
          <a href="#strict" aria-controls="strict" aria-selected="false" class="tab-item strict" role="tab">{{trans('messages.cancellation_policy.strict')}}
          </a>
        </li>
        <!--         
        <li>
          <a href="#super-strict-30" aria-controls="super-strict-30" aria-selected="false" class="tab-item super-strict-30" role="tab">Super Strict 30 Days
          </a>
        </li>
        <li>
          <a href="#super-strict-60" aria-controls="super-strict-60" aria-selected="false" class="tab-item super-strict-60" role="tab">Super Strict 60 Days
          </a>
        </li>
        <li>
          <a href="#long-term" aria-controls="long-term" aria-selected="false" class="tab-item long-term" role="tab">Long Term
          </a>
        </li> 
        -->
      </ul>
      <div id="flexible" class="panel-body tab-panel" role="tabpanel" aria-hidden="false">
        <h3>{{trans('messages.your_reservations.flexible_desc')}}
        </h3>
        <ul>
          <li>{{trans('messages.cancellation_policy.cleaning_fees_always_refundable')}}
          </li>
          <li>{{trans('messages.cancellation_policy.service_fee_non_refundable', ['site_name' => $site_name])}}
          </li>
          <li>{{trans('messages.cancellation_policy.if_complaint_notice_must_be_before_24_hour', ['site_name' => $site_name])}}
          </li>
          <li>{{trans('messages.cancellation_policy.site_will_mediate_when_need_final_say', ['site_name' => $site_name])}}
          </li>
          <li>{{trans('messages.cancellation_policy.reservation_officially_cancelled_when_click_cancel_button')}}
          </li>
          <li>{{trans('messages.cancellation_policy.cancel_policy_may_supres_by_refund_safety_exceptions')}}
          </li>
          <li>{{trans('messages.cancellation_policy.applicable_taxes_will_be_retained_remitted')}}
          </li>
        </ul>
        <div class="timeline-container hide-sm">
          <div class="row clearfix">
            <div class="col-md-4 timeline-segment-refundable timeline-segment">
              <div class="timeline-point">
                <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle tooltip-fixed timeline-point-tooltip">
                  {{trans('messages.cancellation_policy.1_day_prior')}}
                </div>
                <div class="timeline-point-marker">
                </div>
                <div class="timeline-point-label">
                  {{trans('messages.cancellation_policy.the_jul_16')}}
                  <br>{{trans('messages.cancellation_policy.3pm')}}
                </div>
              </div>
            </div>
            <div class="col-md-4 timeline-segment timeline-segment-partly-refundable">
              <div id="second-point" class="timeline-point">
                <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle tooltip-fixed timeline-point-tooltip">
                  {{trans('messages.your_reservations.checkin')}}
                </div>
                <div class="timeline-point-marker">
                </div>
                <div class="timeline-point-label">{{trans('messages.cancellation_policy.fri_jul_17')}}
                  <br>{{trans('messages.cancellation_policy.3pm')}}
                </div>
              </div>
            </div>
            <div class="col-md-4 timeline-segment timeline-segment-nonrefundable">
              <div id="third-point" class="timeline-point">
                <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle tooltip-fixed timeline-point-tooltip">
                  {{trans('messages.your_reservations.checkout')}}
                </div>
                <div class="timeline-point-marker">
                </div>
                <div class="timeline-point-label">{{trans('messages.cancellation_policy.mon_jul_20')}}
                  <br>{{trans('messages.cancellation_policy.11am')}}
                </div>
              </div>
            </div>
          </div>
          <div class="timeline-fineprint">
            {{trans('messages.cancellation_policy.example')}}
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-md-4">
            <p>{{trans('messages.cancellation_policy.flexible_full_refund_24_hours_prior_from_checkin_time')}}
            </p>
          </div>
          <div class="col-md-4">
            <p>{{trans('messages.cancellation_policy.flexible_first_night_non_refundable_less_than_24_hours')}}
            </p>
          </div>
          <div class="col-md-4">
            <p>{{trans('messages.cancellation_policy.flexible_not_spent_24_hours_after_100%_refundable')}}
            </p>
          </div>
        </div>
        <br>
      </div>
      <div id="moderate" class="panel-body tab-panel" role="tabpanel" aria-hidden="true">
        <h3>{{trans('messages.your_reservations.moderate_desc')}}
        </h3>
        <ul>
          <li>{{trans('messages.cancellation_policy.cleaning_fees_always_refundable')}}
          </li>
          <li>{{trans('messages.cancellation_policy.service_fee_non_refundable', ['site_name' => $site_name])}}
          </li>
          <li>{{trans('messages.cancellation_policy.if_complaint_notice_must_be_before_24_hour', ['site_name' => $site_name])}}
          </li>
          <li>{{trans('messages.cancellation_policy.site_will_mediate_when_need_final_say', ['site_name' => $site_name])}}
          </li>
          <li>{{trans('messages.cancellation_policy.reservation_officially_cancelled_when_click_cancel_button')}}
          </li>
          <li>{{trans('messages.cancellation_policy.cancel_policy_may_supres_by_refund_safety_exceptions')}}
          </li>
          <li>{{trans('messages.cancellation_policy.applicable_taxes_will_be_retained_remitted')}}
          </li>
        </ul>
        <div class="timeline-container hide-sm">
          <div class="row clearfix">
            <div class="col-md-4 timeline-segment-refundable timeline-segment">
              <div class="timeline-point">
                <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle tooltip-fixed timeline-point-tooltip">
                  {{trans('messages.cancellation_policy.5_days_prior')}}
                </div>
                <div class="timeline-point-marker">
                </div>
                <div class="timeline-point-label">
                  {{trans('messages.cancellation_policy.sun_jul_12')}}
                  <br>{{trans('messages.cancellation_policy.3pm')}}
                </div>
              </div>
            </div>
            <div class="col-md-4 timeline-segment timeline-segment-partly-refundable">
              <div id="second-point" class="timeline-point">
                <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle tooltip-fixed timeline-point-tooltip">
                  {{trans('messages.your_reservations.checkin')}}
                </div>
                <div class="timeline-point-marker">
                </div>
                <div class="timeline-point-label">{{trans('messages.cancellation_policy.fri_jul_17')}}
                  <br>{{trans('messages.cancellation_policy.3pm')}}
                </div>
              </div>
            </div>
            <div class="col-md-4 timeline-segment timeline-segment-nonrefundable">
              <div id="third-point" class="timeline-point">
                <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle tooltip-fixed timeline-point-tooltip">
                  {{trans('messages.your_reservations.checkout')}}
                </div>
                <div class="timeline-point-marker">
                </div>
                <div class="timeline-point-label">{{trans('messages.cancellation_policy.mon_jul_20')}}
                  <br>{{trans('messages.cancellation_policy.11am')}}
                </div>
              </div>
            </div>
          </div>
          <div class="timeline-fineprint">
            {{trans('messages.cancellation_policy.example')}}
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-md-4 ar_can">
            <p>{{trans('messages.cancellation_policy.moderate_full_refund_5_days_prior_from_checkin_time')}}
            </p>
          </div>
          <div class="col-md-4 ar_can">
            <p>{{trans('messages.cancellation_policy.moderate_less_than_5_days_in_advance_1st_night_50%_not')}}
            </p>
          </div>
          <div class="col-md-4 ar_can">
            <p>{{trans('messages.cancellation_policy.moderate_not_spent_50%_refunded')}}
            </p>
          </div>
        </div>
        <br>
      </div>
      <div id="strict" class="panel-body tab-panel" role="tabpanel" aria-hidden="true">
        <h3>{{trans('messages.your_reservations.Strict_desc')}}
        </h3>
        <ul>
          <li>{{trans('messages.cancellation_policy.cleaning_fees_always_refundable')}}
          </li>
          <li>{{trans('messages.cancellation_policy.service_fee_non_refundable', ['site_name' => $site_name])}}
          </li>
          <li>{{trans('messages.cancellation_policy.if_complaint_notice_must_be_before_24_hour', ['site_name' => $site_name])}}
          </li>
          <li>{{trans('messages.cancellation_policy.site_will_mediate_when_need_final_say', ['site_name' => $site_name])}}
          </li>
          <li>{{trans('messages.cancellation_policy.reservation_officially_cancelled_when_click_cancel_button')}}
          </li>
          <li>{{trans('messages.cancellation_policy.cancel_policy_may_supres_by_refund_safety_exceptions')}}
          </li>
          <li>{{trans('messages.cancellation_policy.applicable_taxes_will_be_retained_remitted')}}
          </li>
        </ul>
        <div class="timeline-container hide-sm">
          <div class="row clearfix">
            <div class="col-md-4 timeline-segment-refundable timeline-segment">
              <div class="timeline-point">
                <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle tooltip-fixed timeline-point-tooltip">
                  {{trans('messages.cancellation_policy.7_days_prior')}}
                </div>
                <div class="timeline-point-marker">
                </div>
                <div class="timeline-point-label">
                  {{trans('messages.cancellation_policy.fri_jul_10')}}
                  <br>{{trans('messages.cancellation_policy.3pm')}}
                </div>
              </div>
            </div>
            <div class="col-md-4 timeline-segment timeline-segment-nonrefundable">
              <div id="second-point" class="timeline-point">
                <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle tooltip-fixed timeline-point-tooltip">
                  {{trans('messages.your_reservations.checkin')}}
                </div>
                <div class="timeline-point-marker">
                </div>
                <div class="timeline-point-label">{{trans('messages.cancellation_policy.fri_jul_17')}}
                  <br>{{trans('messages.cancellation_policy.3pm')}}
                </div>
              </div>
            </div>
            <div class="col-md-4 timeline-segment timeline-segment-nonrefundable">
              <div id="third-point" class="timeline-point">
                <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle tooltip-fixed timeline-point-tooltip">
                  {{trans('messages.your_reservations.checkout')}}
                </div>
                <div class="timeline-point-marker">
                </div>
                <div class="timeline-point-label">{{trans('messages.cancellation_policy.mon_jul_20')}}
                  <br>{{trans('messages.cancellation_policy.11am')}}
                </div>
              </div>
            </div>
          </div>
          <div class="timeline-fineprint">
            {{trans('messages.cancellation_policy.example')}}
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-md-4">
            <p>{{trans('messages.cancellation_policy.strict_50%_refund_on_7_days_prior_checkin_time')}}
            </p>
          </div>
          <div class="col-md-4">
            <p>{{trans('messages.cancellation_policy.strict_less_than_7_days_in_advance_no_refund')}}
            </p>
          </div>
          <div class="col-md-4">
            <p>{{trans('messages.cancellation_policy.strict_not_spent_days_no_refund')}}
            </p>
          </div>
        </div>
        <br>
      </div>
      <div id="super-strict-30" class="panel-body tab-panel" role="tabpanel" aria-hidden="true">
        <h3>Super Strict 30 Days: 50% refund up until 30 days prior to arrival, except fees
        </h3>
        <ul>
          <li>Note: The Super Strict cancellation policy applies to special circumstances and is by invitation only.
          </li>
          <li>Cleaning fees are always refunded if the guest did not check in.
          </li>
          <li>The {{ $site_name }} service fee is non-refundable.
          </li>
          <li>If there is a complaint from either party, notice must be given to {{ $site_name }} within 24 hours of check-in.
          </li>
          <li>{{ $site_name }} will mediate when necessary, and has the final say in all disputes.
          </li>
          <li>A reservation is officially canceled when the guest clicks the cancellation button on the cancellation confirmation page, which they can find in Dashboard &gt; Your Trips &gt; Change or Cancel.
          </li>
          <li>Cancellation policies may be superseded by the Guest Refund Policy, safety cancellations, or extenuating circumstances. Please review these exceptions.
          </li>
          <li>Applicable taxes will be retained and remitted.
          </li>
        </ul>
        <div class="timeline-container hide-sm">
          <div class="row clearfix">
            <div class="col-md-4 timeline-segment-refundable timeline-segment">
              <div class="timeline-point">
                <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle tooltip-fixed timeline-point-tooltip">
                  30 days prior
                </div>
                <div class="timeline-point-marker">
                </div>
                <div class="timeline-point-label">
                  Wed, Jun 17
                  <br>3:00 PM
                </div>
              </div>
            </div>
            <div class="col-md-4 timeline-segment timeline-segment-nonrefundable">
              <div id="second-point" class="timeline-point">
                <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle tooltip-fixed timeline-point-tooltip">
                  Check in
                </div>
                <div class="timeline-point-marker">
                </div>
                <div class="timeline-point-label">Fri, Jul 17
                  <br>3:00 PM
                </div>
              </div>
            </div>
            <div class="col-md-4 timeline-segment timeline-segment-nonrefundable">
              <div id="third-point" class="timeline-point">
                <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle tooltip-fixed timeline-point-tooltip">
                  Check out
                </div>
                <div class="timeline-point-marker">
                </div>
                <div class="timeline-point-label">Mon, Jul 20
                  <br>11:00 AM
                </div>
              </div>
            </div>
          </div>
          <div class="timeline-fineprint">
            Example
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-md-4">
            <p>For a 50% refund, cancellation must be made 30 full days prior to listing’s local check in time (or 3:00 PM if not specified) on the day of check in.
            </p>
          </div>
          <div class="col-md-4">
            <p>If the guest cancels less than 30 days in advance, the nights not spent are not refunded.
            </p>
          </div>
          <div class="col-md-4">
            <p>If guest arrives and decides to leave early, the nights not spent are not refunded.
            </p>
          </div>
        </div>
        <br>
      </div>
      <div id="super-strict-60" class="panel-body tab-panel" role="tabpanel" aria-hidden="true">
        <h3>Super Strict 60 Days: 50% refund up until 60 days prior to arrival, except fees
        </h3>
        <ul>
          <li>Note: The Super Strict cancellation policy applies to special circumstances and is by invitation only.
          </li>
          <li>Cleaning fees are always refunded if the guest did not check in.
          </li>
          <li>The {{ $site_name }} service fee is non-refundable.
          </li>
          <li>If there is a complaint from either party, notice must be given to {{ $site_name }} within 24 hours of check-in.
          </li>
          <li>{{ $site_name }} will mediate when necessary, and has the final say in all disputes.
          </li>
          <li>A reservation is officially canceled when the guest clicks the cancellation button on the cancellation confirmation page, which they can find in Dashboard &gt; Your Trips &gt; Change or Cancel.
          </li>
          <li>Cancellation policies may be superseded by the Guest Refund Policy, safety cancellations, or extenuating circumstances. Please review these exceptions.
          </li>
          <li>Applicable taxes will be retained and remitted.
          </li>
        </ul>
        <div class="timeline-container hide-sm">
          <div class="row clearfix">
            <div class="col-md-4 timeline-segment-refundable timeline-segment">
              <div class="timeline-point">
                <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle tooltip-fixed timeline-point-tooltip">
                  60 days prior
                </div>
                <div class="timeline-point-marker">
                </div>
                <div class="timeline-point-label">
                  Mon, May 18
                  <br>3:00 PM
                </div>
              </div>
            </div>
            <div class="col-md-4 timeline-segment timeline-segment-nonrefundable">
              <div id="second-point" class="timeline-point">
                <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle tooltip-fixed timeline-point-tooltip">
                  Check in
                </div>
                <div class="timeline-point-marker">
                </div>
                <div class="timeline-point-label">Fri, Jul 17
                  <br>3:00 PM
                </div>
              </div>
            </div>
            <div class="col-md-4 timeline-segment timeline-segment-nonrefundable">
              <div id="third-point" class="timeline-point">
                <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle tooltip-fixed timeline-point-tooltip">
                  Check out
                </div>
                <div class="timeline-point-marker">
                </div>
                <div class="timeline-point-label">Mon, Jul 20
                  <br>11:00 AM
                </div>
              </div>
            </div>
          </div>
          <div class="timeline-fineprint">
            Example
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-md-4">
            <p>For a 50% refund, cancellation must be made 60 full days prior to listing’s local check in time (or 3:00 PM if not specified) on the day of check in.
            </p>
          </div>
          <div class="col-md-4">
            <p>If the guest cancels less than 60 days in advance, the nights not spent are not refunded.
            </p>
          </div>
          <div class="col-md-4">
            <p>If guest arrives and decides to leave early, the nights not spent are not refunded.
            </p>
          </div>
        </div>
        <br>
      </div>
      <div id="long-term" class="panel-body tab-panel" role="tabpanel" aria-hidden="true">
        <h3>Long Term: First month down payment, 30 day notice for lease termination
        </h3>
        <ul>
          <li>Note: The Long Term cancellation policy applies to all reservations of 28 nights or more.
          </li>
          <li>Cleaning fees are always refunded if the guest did not check in.
          </li>
          <li>The {{ $site_name }} service fee is non-refundable.
          </li>
          <li>If there is a complaint from either party, notice must be given to {{ $site_name }} within 24 hours of check-in.
          </li>
          <li>{{ $site_name }} will mediate when necessary, and has the final say in all disputes.
          </li>
          <li>A reservation is officially canceled when the guest clicks the cancellation button on the cancellation confirmation page, which they can find in Dashboard &gt; Your Trips &gt; Change or Cancel.
          </li>
          <li>Cancellation policies may be superseded by the Guest Refund Policy, safety cancellations, or extenuating circumstances. Please review these exceptions.
          </li>
          <li>Applicable taxes will be retained and remitted.
          </li>
        </ul>
        <div class="timeline-container hide-sm">
          <div class="row clearfix">
            <div class="col-md-4 timeline-segment timeline-segment-partly-refundable">
              <div id="second-point" class="timeline-point">
                <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle tooltip-fixed timeline-point-tooltip">
                  Check in
                </div>
                <div class="timeline-point-marker">
                </div>
                <div class="timeline-point-label">Fri, Jul 17
                  <br>3:00 PM
                </div>
              </div>
            </div>
            <div class="col-md-4 timeline-segment timeline-segment-nonrefundable">
              <div id="third-point" class="timeline-point">
                <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle tooltip-fixed timeline-point-tooltip">
                  Check out
                </div>
                <div class="timeline-point-marker">
                </div>
                <div class="timeline-point-label">Mon, Jul 20
                  <br>11:00 AM
                </div>
              </div>
            </div>
          </div>
          <div class="timeline-fineprint">
            Example
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-md-4">
            <p>If the guest books a long term stay and decides to cancel the long term agreement before the start date, the first payment is paid to the host in full.
            </p>
          </div>
          <div class="col-md-4">
            <p>If the guest books a long term stay and decides to cancel the long term agreement during their stay, the guest must use the online alteration tool in order to agree to a new checkout date.  Regardless of the checkout date chosen, the guest is required to pay the host for the 30 days following the cancellation date, or up to the end date of the guest’s original reservation if the remaining days of the original reservation is less than 30 days.
            </p>
          </div>
        </div>
        <br>
      </div>
    </div>
  </div>
</main>
@endsection
@push('scripts')
<script type="text/javascript">
  $('.tab-item').click(function()
  {
    $('.tab-item').each(function()
    {
      $($(this).attr('href')).hide();
      $(this).attr('aria-selected', 'false');
    });
    $($(this).attr('href')).show();
    $(this).attr('aria-selected', 'true');
  });
  var cal_type = window.location.hash.substr(1);
  var type =  cal_type.toLowerCase();
  $('.tab-item').attr('aria-selected', 'false');
  $('.tab-panel').hide();
  $('#'+type).show();
  $('.'+type).attr('aria-selected', 'true');
</script>
@endpush
