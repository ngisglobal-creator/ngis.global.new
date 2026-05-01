@extends('client.layouts.master')

@section('title', 'تقديم طلب خاص - Sourcing')

@section('content')
<section class="content-header">
    <h1 style="font-weight: 900; color: #1a202c;">
        تقديم طلب استيراد مخصص <small>Global Procurement Hub</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('client.dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li class="active">طلب خاص</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <form action="{{ route('client.special_order.store') }}" method="POST" enctype="multipart/form-data" id="specialOrderForm">
                @csrf

                <!-- 1. البيانات التعريفية للمنتج (Product Identification) -->
                <div class="box box-primary" style="border-radius: 15px; border-top: 5px solid #3c8dbc; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                    <div class="box-header with-border" style="padding: 15px 20px;">
                        <h3 class="box-title" style="font-weight: 700; color: #2d3748;">
                            <i class="fa fa-tag text-primary" style="margin-left: 10px;"></i> 1. البيانات التعريفية للمنتج (Product Identification)
                        </h3>
                    </div>
                    <div class="box-body" style="padding: 25px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>اسم المنتج <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" placeholder="مثال: محرك هيدروليكي، قماش حرير طبيعي" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>تصنيف السلعة <span class="text-danger">*</span></label>
                                    <select name="category_type" class="form-control select2" style="width: 100%;" required>
                                        <option value="">اختر التصنيف...</option>
                                        <option value="industrial">صناعي (Industrial)</option>
                                        <option value="commercial">تجاري (Commercial)</option>
                                        <option value="raw_materials">مواد خام (Raw Materials)</option>
                                        <option value="electronics">إلكترونيات (Electronics)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>المواصفات الفنية <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control" rows="4" placeholder="المقاسات، الأوزان، المواد المصنعة، القدرة التشغيلية..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label>رابط مشابه للاسترشاد (Reference Link)</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-link"></i></span>
                                <input type="url" name="reference_link" class="form-control" placeholder="رابط من Alibaba, Amazon, أو غيرها">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. الملحقات المرئية (Visual Documentation) -->
                <div class="box box-info" style="border-radius: 15px; border-top: 5px solid #00c0ef; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                    <div class="box-header with-border" style="padding: 15px 20px;">
                        <h3 class="box-title" style="font-weight: 700; color: #2d3748;">
                            <i class="fa fa-camera text-info" style="margin-left: 10px;"></i> 2. الملحقات المرئية (Visual Documentation)
                        </h3>
                    </div>
                    <div class="box-body" style="padding: 25px;">
                        <div class="row">
                            <div class="col-md-6">
                                <label>صور المنتج (حتى 5 صور)</label>
                                <label for="imageInput" class="upload-zone" style="display: block; border: 2px dashed #cbd5e0; border-radius: 12px; padding: 20px; text-align: center; background: #f8fafc; cursor: pointer;">
                                    <i class="fa fa-cloud-upload" style="font-size: 2em; color: #a0aec0;"></i>
                                    <p style="margin: 5px 0 0;">اضغط لرفع الصور</p>
                                </label>
                                <input type="file" name="images[]" id="imageInput" multiple accept="image/*" style="display: none;">
                                <div id="imagePreviewContainer" style="display: flex; flex-wrap: wrap; gap: 5px; margin-top: 10px;"></div>
                            </div>
                            <div class="col-md-6">
                                <label>ملفات فنية (PDF / CAD)</label>
                                <label for="pdfInput" class="upload-zone" style="display: block; border: 2px dashed #cbd5e0; border-radius: 12px; padding: 20px; text-align: center; background: #f8fafc; cursor: pointer;">
                                    <i class="fa fa-file-pdf-o" style="font-size: 2em; color: #a0aec0;"></i>
                                    <p style="margin: 5px 0 0;">اضغط لرفع الملفات</p>
                                </label>
                                <input type="file" name="spec_file" id="pdfInput" accept=".pdf,.dwg,.dxf" style="display: none;">
                                <div id="pdfPreviewContainer" style="margin-top: 10px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. المعايير الكمية واللوجستية (Logistical Requirements) -->
                <div class="box box-success" style="border-radius: 15px; border-top: 5px solid #00a65a; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                    <div class="box-header with-border" style="padding: 15px 20px;">
                        <h3 class="box-title" style="font-weight: 700; color: #2d3748;">
                            <i class="fa fa-truck text-success" style="margin-left: 10px;"></i> 3. المعايير الكمية واللوجستية (Logistical Requirements)
                        </h3>
                    </div>
                    <div class="box-body" style="padding: 25px;">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>الكمية المطلوبة</label>
                                    <div class="input-group">
                                        <input type="number" name="quantity" class="form-control" placeholder="العدد" min="1">
                                        <div class="input-group-btn" style="width: 100px;">
                                            <select name="unit" class="form-control" style="border-right: 0;">
                                                <option value="piece">قطعة</option>
                                                <option value="ton">طن</option>
                                                <option value="container">حاوية</option>
                                                <option value="kg">كيلو</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>سعر الشراء المستهدف</label>
                                    <div class="input-group">
                                        <input type="number" name="target_price" class="form-control" placeholder="السعر المتوقع">
                                        <span class="input-group-addon">$ USD</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>التغليف الخاص</label>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="packaging[]" value="moisture_proof"> حماية ضد الرطوبة</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="packaging[]" value="fragile"> حماية ضد الكسر</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. اشتراطات الجودة والمنشأ (Compliance & Origin) -->
                <div class="box box-warning" style="border-radius: 15px; border-top: 5px solid #f39c12; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                    <div class="box-header with-border" style="padding: 15px 20px;">
                        <h3 class="box-title" style="font-weight: 700; color: #2d3748;">
                            <i class="fa fa-certificate text-warning" style="margin-left: 10px;"></i> 4. اشتراطات الجودة والمنشأ (Compliance & Origin)
                        </h3>
                    </div>
                    <div class="box-body" style="padding: 25px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>بلد المنشأ المفضل</label>
                                    <select name="origin" class="form-control select2" style="width: 100%;">
                                        <option value="any">أفضل مصدر متاح (Recommended)</option>
                                        <option value="china">الصين (China)</option>
                                        <option value="turkey">تركيا (Turkey)</option>
                                        <option value="europe">أوروبا (Europe)</option>
                                        <option value="india">الهند (India)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label style="display: block; margin-bottom: 20px; font-size: 1.2em; border-bottom: 2px solid #edf2f7; padding-bottom: 10px; color: #1a202c;">
                                        <i class="fa fa-certificate text-yellow"></i> المتطلبات القانونية والشهادات العالمية (Global Compliance & Certifications)
                                    </label>
                                    
                                    <div class="row">
                                        <!-- 1. شهادات عامة وجودة -->
                                        <div class="col-md-3">
                                            <p style="font-weight: 700; color: #3c8dbc; border-right: 3px solid #3c8dbc; padding-right: 10px;">الجودة والسلامة العامة</p>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="ISO_9001"> ISO 9001 / 14001</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="CE_Mark"> CE Mark (Europe)</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="CB_Scheme"> CB Scheme (Global)</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="RoHS_REACH"> RoHS / REACH</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="GS_Mark"> GS Mark (Germany)</label></div>
                                        </div>

                                        <!-- 2. الشهادات الكهربائية والإلكترونية -->
                                        <div class="col-md-3">
                                            <p style="font-weight: 700; color: #00c0ef; border-right: 3px solid #00c0ef; padding-right: 10px;">الكهرباء والإلكترونيات</p>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="UL_ETL"> UL / ETL (USA)</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="FCC_IC"> FCC (USA) / IC (Canada)</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="PSE_VCCI"> PSE / VCCI (Japan)</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="SAA_RCM"> SAA / RCM (Australia)</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="KC_Mark"> KC Mark (South Korea)</label></div>
                                        </div>

                                        <!-- 3. الماكينات والمعدات الثقيلة -->
                                        <div class="col-md-3">
                                            <p style="font-weight: 700; color: #00a65a; border-right: 3px solid #00a65a; padding-right: 10px;">الماكينات والمعدات</p>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="Machinery_Directive"> Machinery Directive (MD)</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="EMC_LVD"> EMC / LVD Directive</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="ASME_Standards"> ASME (USA Industry)</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="ATEX_Ex"> ATEX (Explosion Proof)</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="TUV_SUD"> TÜV SÜD / NORD</label></div>
                                        </div>

                                        <!-- 4. الشهادات الطبية والصحية -->
                                        <div class="col-md-3">
                                            <p style="font-weight: 700; color: #e53e3e; border-right: 3px solid #e53e3e; padding-right: 10px;">الطبية والصحية</p>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="FDA_USA"> FDA (USA Medical)</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="CE_MDR"> CE MDR (EU Medical)</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="ISO_13485"> ISO 13485 (Devices)</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="NMPA_CFDA"> NMPA / CFDA (China)</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="GMP_Cert"> GMP Certificate</label></div>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 20px;">
                                        <!-- 5. الشهادات الصينية الوطنية -->
                                        <div class="col-md-3">
                                            <p style="font-weight: 700; color: #d81b60; border-right: 3px solid #d81b60; padding-right: 10px;">الشهادات الصينية</p>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="CCC_China"> CCC (Compulsory)</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="CQC_China"> CQC (Quality)</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="CNAS_Lab"> CNAS (Laboratory)</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="GB_Standards"> GB National Standards</label></div>
                                        </div>

                                        <!-- 6. الشرق الأوسط وأفريقيا -->
                                        <div class="col-md-3">
                                            <p style="font-weight: 700; color: #f39c12; border-right: 3px solid #f39c12; padding-right: 10px;">الشرق الأوسط وأفريقيا</p>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="SASO_SABER"> SASO / SABER (Saudi)</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="G_Mark"> G-Mark (Gulf Countries)</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="SONCAP"> SONCAP (Nigeria)</label></div>
                                            <div class="checkbox"><label><input type="checkbox" name="certs[]" value="EAC_Union"> EAC (Eurasian Union)</label></div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>أخرى (اذكرها هنا)</label>
                                                <input type="text" name="other_certs" class="form-control" placeholder="أدخل أي شهادات أخرى مطلوبة غير موجودة في القائمة">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center" style="margin-top: 40px; margin-bottom: 60px;">
                    <button type="submit" class="btn btn-primary btn-lg" style="padding: 15px 60px; border-radius: 50px; font-weight: 900; font-size: 1.4em; box-shadow: 0 10px 25px rgba(60, 141, 188, 0.4);">
                        <i class="fa fa-paper-plane" style="margin-left: 10px;"></i> إرسال الطلب للمراجعة الدولية
                    </button>
                    <p class="text-muted" style="margin-top: 15px;">بمجرد الإرسال، سيبدأ فريقنا الميداني في البحث عن أفضل الموردين لك.</p>
                </div>

            </form>
        </div>
    </div>
</section>

@push('scripts')
<script>
$(document).ready(function() {
    // Preview Images
    $('#imageInput').on('change', function() {
        $('#imagePreviewContainer').empty();
        let files = this.files;
        if (files.length > 5) {
            alert('عذراً، يمكنك رفع 5 صور كحد أقصى');
            this.value = '';
            return;
        }
        for (let i = 0; i < files.length; i++) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreviewContainer').append(`
                    <div style="width: 80px; height: 80px; border-radius: 8px; overflow: hidden; border: 1px solid #ddd;">
                        <img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                `);
            }
            reader.readAsDataURL(files[i]);
        }
    });

    // Preview PDF
    $('#pdfInput').on('change', function() {
        let file = this.files[0];
        if (file) {
            $('#pdfPreviewContainer').html(`
                <div style="padding: 10px; background: #fff; border: 1px solid #ddd; border-radius: 8px; display: flex; align-items: center; justify-content: space-between;">
                    <span><i class="fa fa-file-pdf-o text-red"></i> ${file.name}</span>
                    <a href="${URL.createObjectURL(file)}" target="_blank" class="btn btn-xs btn-default">معاينة</a>
                </div>
            `);
        }
    });
});
</script>
<style>
    .upload-zone:hover { border-color: #3c8dbc !important; background: #f0f7ff !important; }
    .form-group label { font-weight: 700; color: #4a5568; margin-bottom: 8px; }
    .form-control { border-radius: 8px; border: 1.5px solid #e2e8f0; height: auto; padding: 10px 15px; }
    .form-control:focus { border-color: #3c8dbc; box-shadow: none; }
</style>
@endpush
@endsection
