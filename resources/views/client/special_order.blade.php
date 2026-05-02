@extends('client.layouts.master')

@section('title', 'تقديم طلب خاص - Sourcing')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0 text-dark">تقديم طلب استيراد مخصص <span class="text-muted fs-6 fw-normal ms-2">Global Procurement Hub</span></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('client.dashboard') }}" class="text-decoration-none"><i class="fa-solid fa-house me-1"></i>الرئيسية</a></li>
            <li class="breadcrumb-item active" aria-current="page">طلب خاص</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-10 mx-auto">
        <form action="{{ route('client.special_order.store') }}" method="POST" enctype="multipart/form-data" id="specialOrderForm">
            @csrf

            <!-- 1. البيانات التعريفية للمنتج (Product Identification) -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title fw-bold m-0 text-primary">
                        <i class="fa-solid fa-tag me-2"></i> 1. البيانات التعريفية للمنتج (Product Identification)
                    </h5>
                </div>
                <div class="card-body p-4 bg-light">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">اسم المنتج <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" placeholder="مثال: محرك هيدروليكي، قماش حرير طبيعي" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">تصنيف السلعة <span class="text-danger">*</span></label>
                            <select name="category_type" class="form-select select2" required>
                                <option value="">اختر التصنيف...</option>
                                <option value="industrial">صناعي (Industrial)</option>
                                <option value="commercial">تجاري (Commercial)</option>
                                <option value="raw_materials">مواد خام (Raw Materials)</option>
                                <option value="electronics">إلكترونيات (Electronics)</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">المواصفات الفنية <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="4" placeholder="المقاسات، الأوزان، المواد المصنعة، القدرة التشغيلية..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">رابط مشابه للاسترشاد (Reference Link)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fa-solid fa-link text-muted"></i></span>
                            <input type="url" name="reference_link" class="form-control" placeholder="رابط من Alibaba, Amazon, أو غيرها">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. الملحقات المرئية (Visual Documentation) -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title fw-bold m-0 text-info">
                        <i class="fa-solid fa-camera me-2"></i> 2. الملحقات المرئية (Visual Documentation)
                    </h5>
                </div>
                <div class="card-body p-4 bg-light">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">صور المنتج (حتى 5 صور)</label>
                            <label for="imageInput" class="upload-zone w-100 p-4 text-center rounded-3 border border-2 border-dashed bg-white cursor-pointer" style="border-style: dashed !important; border-color: #cbd5e1 !important; cursor: pointer;">
                                <i class="fa-solid fa-cloud-arrow-up fs-1 text-muted mb-2"></i>
                                <p class="mb-0 text-muted">اضغط لرفع الصور</p>
                            </label>
                            <input type="file" name="images[]" id="imageInput" multiple accept="image/*" class="d-none">
                            <div id="imagePreviewContainer" class="d-flex flex-wrap gap-2 mt-3"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">ملفات فنية (PDF / CAD)</label>
                            <label for="pdfInput" class="upload-zone w-100 p-4 text-center rounded-3 border border-2 border-dashed bg-white cursor-pointer" style="border-style: dashed !important; border-color: #cbd5e1 !important; cursor: pointer;">
                                <i class="fa-regular fa-file-pdf fs-1 text-muted mb-2"></i>
                                <p class="mb-0 text-muted">اضغط لرفع الملفات</p>
                            </label>
                            <input type="file" name="spec_file" id="pdfInput" accept=".pdf,.dwg,.dxf" class="d-none">
                            <div id="pdfPreviewContainer" class="mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. المعايير الكمية واللوجستية (Logistical Requirements) -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title fw-bold m-0 text-success">
                        <i class="fa-solid fa-truck me-2"></i> 3. المعايير الكمية واللوجستية (Logistical Requirements)
                    </h5>
                </div>
                <div class="card-body p-4 bg-light">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">الكمية المطلوبة</label>
                            <div class="input-group">
                                <input type="number" name="quantity" class="form-control" placeholder="العدد" min="1">
                                <select name="unit" class="form-select text-center" style="max-width: 100px;">
                                    <option value="piece">قطعة</option>
                                    <option value="ton">طن</option>
                                    <option value="container">حاوية</option>
                                    <option value="kg">كيلو</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">سعر الشراء المستهدف</label>
                            <div class="input-group">
                                <input type="number" name="target_price" class="form-control" placeholder="السعر المتوقع">
                                <span class="input-group-text bg-white">$ USD</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">التغليف الخاص</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="packaging[]" value="moisture_proof" id="pack1">
                                <label class="form-check-label text-dark" for="pack1">حماية ضد الرطوبة</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="packaging[]" value="fragile" id="pack2">
                                <label class="form-check-label text-dark" for="pack2">حماية ضد الكسر</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. اشتراطات الجودة والمنشأ (Compliance & Origin) -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title fw-bold m-0 text-warning text-darken">
                        <i class="fa-solid fa-certificate me-2"></i> 4. اشتراطات الجودة والمنشأ (Compliance & Origin)
                    </h5>
                </div>
                <div class="card-body p-4 bg-light">
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">بلد المنشأ المفضل</label>
                            <select name="origin" class="form-select select2">
                                <option value="any">أفضل مصدر متاح (Recommended)</option>
                                <option value="china">الصين (China)</option>
                                <option value="turkey">تركيا (Turkey)</option>
                                <option value="europe">أوروبا (Europe)</option>
                                <option value="india">الهند (India)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="border-bottom pb-2 mb-3">
                        <h6 class="fw-bold text-dark m-0"><i class="fa-solid fa-file-contract text-warning me-2"></i> المتطلبات القانونية والشهادات العالمية (Global Compliance & Certifications)</h6>
                    </div>
                    
                    <div class="row g-4">
                        <!-- 1. شهادات عامة وجودة -->
                        <div class="col-md-3 border-end">
                            <h6 class="fw-bold text-primary mb-3">الجودة والسلامة العامة</h6>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="ISO_9001" id="c1"><label class="form-check-label" for="c1">ISO 9001 / 14001</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="CE_Mark" id="c2"><label class="form-check-label" for="c2">CE Mark (Europe)</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="CB_Scheme" id="c3"><label class="form-check-label" for="c3">CB Scheme (Global)</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="RoHS_REACH" id="c4"><label class="form-check-label" for="c4">RoHS / REACH</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="GS_Mark" id="c5"><label class="form-check-label" for="c5">GS Mark (Germany)</label></div>
                        </div>

                        <!-- 2. الشهادات الكهربائية والإلكترونية -->
                        <div class="col-md-3 border-end">
                            <h6 class="fw-bold text-info mb-3">الكهرباء والإلكترونيات</h6>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="UL_ETL" id="c6"><label class="form-check-label" for="c6">UL / ETL (USA)</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="FCC_IC" id="c7"><label class="form-check-label" for="c7">FCC (USA) / IC</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="PSE_VCCI" id="c8"><label class="form-check-label" for="c8">PSE / VCCI (Japan)</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="SAA_RCM" id="c9"><label class="form-check-label" for="c9">SAA / RCM (Australia)</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="KC_Mark" id="c10"><label class="form-check-label" for="c10">KC Mark (South Korea)</label></div>
                        </div>

                        <!-- 3. الماكينات والمعدات الثقيلة -->
                        <div class="col-md-3 border-end">
                            <h6 class="fw-bold text-success mb-3">الماكينات والمعدات</h6>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="Machinery_Directive" id="c11"><label class="form-check-label" for="c11">Machinery Directive</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="EMC_LVD" id="c12"><label class="form-check-label" for="c12">EMC / LVD Directive</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="ASME_Standards" id="c13"><label class="form-check-label" for="c13">ASME (USA Industry)</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="ATEX_Ex" id="c14"><label class="form-check-label" for="c14">ATEX (Explosion Proof)</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="TUV_SUD" id="c15"><label class="form-check-label" for="c15">TÜV SÜD / NORD</label></div>
                        </div>

                        <!-- 4. الشهادات الطبية والصحية -->
                        <div class="col-md-3">
                            <h6 class="fw-bold text-danger mb-3">الطبية والصحية</h6>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="FDA_USA" id="c16"><label class="form-check-label" for="c16">FDA (USA Medical)</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="CE_MDR" id="c17"><label class="form-check-label" for="c17">CE MDR (EU Medical)</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="ISO_13485" id="c18"><label class="form-check-label" for="c18">ISO 13485 (Devices)</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="NMPA_CFDA" id="c19"><label class="form-check-label" for="c19">NMPA / CFDA (China)</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="GMP_Cert" id="c20"><label class="form-check-label" for="c20">GMP Certificate</label></div>
                        </div>
                    </div>

                    <div class="row g-4 mt-1 border-top pt-3">
                        <!-- 5. الشهادات الصينية الوطنية -->
                        <div class="col-md-3 border-end">
                            <h6 class="fw-bold text-danger mb-3">الشهادات الصينية</h6>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="CCC_China" id="c21"><label class="form-check-label" for="c21">CCC (Compulsory)</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="CQC_China" id="c22"><label class="form-check-label" for="c22">CQC (Quality)</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="CNAS_Lab" id="c23"><label class="form-check-label" for="c23">CNAS (Laboratory)</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="GB_Standards" id="c24"><label class="form-check-label" for="c24">GB National Standards</label></div>
                        </div>

                        <!-- 6. الشرق الأوسط وأفريقيا -->
                        <div class="col-md-3 border-end">
                            <h6 class="fw-bold text-warning text-darken mb-3">الشرق الأوسط وأفريقيا</h6>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="SASO_SABER" id="c25"><label class="form-check-label" for="c25">SASO / SABER (Saudi)</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="G_Mark" id="c26"><label class="form-check-label" for="c26">G-Mark (Gulf Countries)</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="SONCAP" id="c27"><label class="form-check-label" for="c27">SONCAP (Nigeria)</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="certs[]" value="EAC_Union" id="c28"><label class="form-check-label" for="c28">EAC (Eurasian Union)</label></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">أخرى (اذكرها هنا)</label>
                            <input type="text" name="other_certs" class="form-control" placeholder="أدخل أي شهادات أخرى مطلوبة غير موجودة في القائمة">
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center my-5">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow fw-bold">
                    <i class="fa-solid fa-paper-plane me-2"></i> إرسال الطلب للمراجعة الدولية
                </button>
                <p class="text-muted mt-3 small">بمجرد الإرسال، سيبدأ فريقنا الميداني في البحث عن أفضل الموردين لك.</p>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Preview Images
    $('#imageInput').on('change', function() {
        $('#imagePreviewContainer').empty();
        let files = this.files;
        if (files.length > 5) {
            Swal.fire({icon: 'warning', title: 'تنبيه', text: 'عذراً، يمكنك رفع 5 صور كحد أقصى'});
            this.value = '';
            return;
        }
        for (let i = 0; i < files.length; i++) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreviewContainer').append(`
                    <div class="border rounded overflow-hidden shadow-sm" style="width: 80px; height: 80px;">
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
                <div class="p-2 bg-white border rounded shadow-sm d-flex align-items-center justify-content-between">
                    <span class="text-dark fw-bold"><i class="fa-regular fa-file-pdf text-danger me-2"></i> ${file.name}</span>
                    <a href="${URL.createObjectURL(file)}" target="_blank" class="btn btn-sm btn-outline-secondary">معاينة</a>
                </div>
            `);
        }
    });
});
</script>
<style>
    .upload-zone:hover { border-color: #0d6efd !important; background: #f8f9fa !important; }
    .text-darken { color: #d39e00 !important; }
</style>
@endpush
@endsection
