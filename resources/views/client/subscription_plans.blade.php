@extends('client.layouts.master')

@section('title', 'خطط العضوية المتميزة | NGIS')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;900&display=swap" rel="stylesheet">

<div class="subscription-plans-wrapper" style="font-family: 'Outfit', sans-serif; padding: 40px 20px; background: #f8fafc; min-height: calc(100vh - 100px);">
    <div class="container text-center">
        <!-- Header Section -->
        <div class="header-section" style="margin-bottom: 60px;" data-aos="fade-down">
            <h1 style="font-weight: 900; color: #1e3a8a; font-size: 42px; margin-bottom: 15px;">انتقل بتجارتك إلى <span style="color: #d4af37;">المستوى التالي</span></h1>
            <p style="color: #64748b; font-size: 18px; max-width: 600px; margin: 0 auto; line-height: 1.6;">اختر الباقة المناسبة لاحتياجاتك اللوجستية وتمتع بمزايا حصرية تساعدك على النمو في السوق العالمي.</p>
        </div>

        <div class="row align-items-stretch justify-content-center g-5" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 40px;">
            <!-- Merchant Plan Card -->
            <div class="col-md-5 col-lg-4" data-aos="fade-right" data-aos-delay="100">
                <div class="plan-card" style="background: #fff; border-radius: 32px; padding: 50px 40px; border: 1px solid #e2e8f0; box-shadow: 0 20px 50px rgba(0,0,0,0.05); transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); position: relative; height: 100%; display: flex; flex-direction: column; min-height: 600px;">
                    <div class="plan-icon" style="width: 80px; height: 80px; background: #eff6ff; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px; color: #2563eb; font-size: 32px;">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <h3 style="font-weight: 800; color: #0f172a; font-size: 26px; margin-bottom: 10px;">حساب تاجر</h3>
                    <div class="price" style="margin-bottom: 30px;">
                        <span style="font-size: 52px; font-weight: 900; color: #1e293b;">$29</span>
                        <span style="color: #94a3b8; font-size: 16px;">/ شهرياً</span>
                    </div>
                    
                    <ul style="list-style: none; padding: 0; margin-bottom: 40px; text-align: right; flex-grow: 1;">
                        <li style="margin-bottom: 15px; display: flex; align-items: center; gap: 12px; color: #475569;">
                            <i class="fa fa-check-circle" style="color: #22c55e;"></i>
                            <span>أدوات حساب CBM متقدمة</span>
                        </li>
                        <li style="margin-bottom: 15px; display: flex; align-items: center; gap: 12px; color: #475569;">
                            <i class="fa fa-check-circle" style="color: #22c55e;"></i>
                            <span>تقارير لوجستية مفصلة</span>
                        </li>
                        <li style="margin-bottom: 15px; display: flex; align-items: center; gap: 12px; color: #475569;">
                            <i class="fa fa-check-circle" style="color: #22c55e;"></i>
                            <span>تخزين سلة الشحن في المتصفح</span>
                        </li>
                        <li style="margin-bottom: 15px; display: flex; align-items: center; gap: 12px; color: #475569;">
                            <i class="fa fa-check-circle" style="color: #22c55e;"></i>
                            <span>دعم فني عبر الدردشة</span>
                        </li>
                    </ul>

                    <button class="btn-subscribe" style="background: #1e293b; color: #fff; border: none; border-radius: 16px; padding: 18px; font-weight: 700; font-size: 18px; cursor: pointer; transition: all 0.3s; width: 100%;">اشترك الآن</button>
                    <div style="margin-top: 15px; font-size: 12px; color: #94a3b8;">تطبق الشروط والأحكام</div>
                </div>
            </div>

            <!-- Company Owner Plan Card (Most Popular) -->
            <div class="col-md-5 col-lg-4" data-aos="fade-left" data-aos-delay="200">
                <div class="plan-card premium-shadow" style="background: linear-gradient(135deg, #1e3a8a 0%, #1e1b4b 100%); border-radius: 32px; padding: 50px 40px; border: none; position: relative; height: 100%; display: flex; flex-direction: column; overflow: hidden; transform: scale(1.05); min-height: 600px;">
                    <!-- Glowing Effect -->
                    <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: rgba(212, 175, 55, 0.2); filter: blur(60px); border-radius: 50%;"></div>
                    
                    <div class="popular-badge" style="position: absolute; top: 25px; left: 0; right: 0; display: flex; justify-content: center;">
                        <span style="background: #d4af37; color: #1e1b4b; padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 900; letter-spacing: 1px; text-transform: uppercase;">الباقة الأكثر طلباً</span>
                    </div>

                    <div class="plan-icon" style="width: 80px; height: 80px; background: rgba(255,255,255,0.1); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 15px auto 30px; color: #d4af37; font-size: 32px; border: 1px solid rgba(255,255,255,0.1);">
                        <i class="fa fa-building"></i>
                    </div>
                    <h3 style="font-weight: 800; color: #fff; font-size: 26px; margin-bottom: 10px;">حساب صاحب شركة</h3>
                    <div class="price" style="margin-bottom: 30px;">
                        <span style="font-size: 52px; font-weight: 900; color: #fff;">$99</span>
                        <span style="color: rgba(255,255,255,0.6); font-size: 16px;">/ شهرياً</span>
                    </div>
                    
                    <ul style="list-style: none; padding: 0; margin-bottom: 40px; text-align: right; flex-grow: 1;">
                        <li style="margin-bottom: 15px; display: flex; align-items: center; gap: 12px; color: rgba(255,255,255,0.8);">
                            <i class="fa fa-star" style="color: #d4af37;"></i>
                            <span>كافة مزايا حساب التاجر</span>
                        </li>
                        <li style="margin-bottom: 15px; display: flex; align-items: center; gap: 12px; color: rgba(255,255,255,0.8);">
                            <i class="fa fa-star" style="color: #d4af37;"></i>
                            <span>إحصائيات تحميل حاويات حقيقية</span>
                        </li>
                        <li style="margin-bottom: 15px; display: flex; align-items: center; gap: 12px; color: rgba(255,255,255,0.8);">
                            <i class="fa fa-star" style="color: #d4af37;"></i>
                            <span>إدارة مخزون متقدمة</span>
                        </li>
                        <li style="margin-bottom: 15px; display: flex; align-items: center; gap: 12px; color: rgba(255,255,255,0.8);">
                            <i class="fa fa-star" style="color: #d4af37;"></i>
                            <span>مدير حساب مخصص</span>
                        </li>
                        <li style="margin-bottom: 15px; display: flex; align-items: center; gap: 12px; color: rgba(255,255,255,0.8);">
                            <i class="fa fa-star" style="color: #d4af37;"></i>
                            <span>أولوية في معالجة طلبات التصنيع</span>
                        </li>
                    </ul>

                    <button class="btn-subscribe-gold" style="background: #d4af37; color: #1e1b4b; border: none; border-radius: 16px; padding: 18px; font-weight: 900; font-size: 18px; cursor: pointer; transition: all 0.3s; width: 100%; box-shadow: 0 10px 25px rgba(212, 175, 55, 0.4);">اشترك الآن</button>
                    <div style="margin-top: 15px; font-size: 12px; color: rgba(255,255,255,0.4);">دعم لا محدود على مدار الساعة</div>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="mt-5 pt-5" data-aos="fade-up" style="margin-top: 80px;">
            <div style="background: #fff; border-radius: 20px; padding: 25px; display: inline-flex; align-items: center; gap: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #f1f5f9;">
                <i class="fa fa-shield text-primary" style="font-size: 24px;"></i>
                <span style="color: #475569; font-weight: 600;">ضمان استرداد الأموال خلال 14 يوم إذا لم تكن راضياً عن الخدمة</span>
            </div>
        </div>
    </div>
</div>

<style>
    .plan-card:hover {
        transform: translateY(-15px) !important;
        box-shadow: 0 30px 70px rgba(0,0,0,0.1) !important;
    }
    .btn-subscribe:hover {
        background: #000 !important;
        transform: scale(1.02);
    }
    .btn-subscribe-gold:hover {
        background: #fff !important;
        color: #d4af37 !important;
        transform: scale(1.02);
    }
    .premium-shadow {
        box-shadow: 0 30px 60px rgba(30, 58, 138, 0.3) !important;
    }
</style>
@endsection
