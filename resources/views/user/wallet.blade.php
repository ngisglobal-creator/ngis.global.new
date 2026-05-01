@extends($layoutPrefix . 'layouts.master')

@section('title', 'محفظتي')

@section('content')
<section class="content-header text-center">
  <h1 style="font-size: 32px; font-weight: bold; margin-bottom: 20px;">محفظتي</h1>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="box box-success" style="border-top-color: #00a65a; border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div class="box-body text-center" style="padding: 40px;">
          <div style="margin-bottom: 30px;">
            <i class="fa fa-google-wallet" style="font-size: 120px; color: #00a65a;"></i>
          </div>
          
          <h3 class="text-muted" style="margin-bottom: 10px;">الرصيد المتاح</h3>
          
          <div style="direction: ltr; font-family: 'Arial', sans-serif;">
            <span style="font-size: 60px; font-weight: bold; color: #333;">
              {{ number_format($user->wallet_balance, 2, '.', '') }}
            </span>
            <span style="font-size: 24px; font-weight: bold; color: #888; margin-left: 10px;">USD</span>
          </div>
          
          <hr style="margin: 30px 0;">
          
          <p class="help-block" style="font-size: 16px;">
            يمكنك استخدام هذا الرصيد لإتمام عملياتك داخل المنصة.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
