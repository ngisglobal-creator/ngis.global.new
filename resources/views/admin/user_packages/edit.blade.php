@extends('layouts.master')

@section('title', 'تعديل باقة المستخدم: ' . $user->name)

@section('content')
<style>
  .package-card {
    border: 2px solid #ddd;
    border-radius: 8px;
    padding: 10px;
    cursor: pointer;
    transition: all 0.3s;
    height: 100%;
    position: relative;
    background: #fff;
  }
  .package-card:hover {
    border-color: #3c8dbc;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }
  .package-card.selected {
    border-color: #00a65a;
    background-color: #f0fff4;
  }
  .package-card.selected::after {
    content: '\f058';
    font-family: 'FontAwesome';
    position: absolute;
    top: 5px;
    right: 5px;
    color: #00a65a;
    font-size: 20px;
  }
  .package-card img {
    width: 100%;
    height: 120px;
    object-fit: contain;
    margin-bottom: 10px;
  }
  .package-card .title {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
    text-align: center;
  }
  .package-card .desc {
    font-size: 12px;
    color: #666;
    text-align: center;
  }
  
  /* Star Rating */
  .star-rating {
    direction: rtl;
    display: inline-block;
    padding: 20px;
  }
  .star-rating input {
    display: none;
  }
  .star-rating label {
    color: #bbb;
    font-size: 30px;
    padding: 0;
    cursor: pointer;
    -webkit-transition: all .3s ease-in-out;
    transition: all .3s ease-in-out;
  }
  .star-rating label:hover,
  .star-rating label:hover ~ label,
  .star-rating input:checked ~ label {
    color: #f2b600;
  }
</style>

<section class="content-header">
  <h1>
    تعديل باقة المستخدم: {{ $user->name }}
    <small>نوع الحساب: 
      @php
        $types = ['client'=>'عميل','company'=>'شركة','factory'=>'مصنع'];
      @endphp
      {{ $types[$user->type] ?? $user->type }}
    </small>
  </h1>
</section>

<section class="content">
  <div class="box box-primary">
    <form action="{{ route('admin.user-packages.update', $user->id) }}" method="POST">
      @csrf
      @method('PUT')
      
      <div class="box-body">
        <h4 class="page-header"><i class="fa fa-cubes"></i> اختر الباقة المناسبة</h4>
        
        <input type="hidden" name="package_id" id="selected_package_id" value="{{ $user->package_id }}">
        
        <div class="row">
          @foreach($packages as $package)
          <div class="col-md-3 col-sm-6" style="margin-bottom: 20px;">
            <div class="package-card {{ $user->package_id == $package->id ? 'selected' : '' }}" 
                 onclick="selectPackage({{ $package->id }}, this)">
              <img src="{{ $package->image_url }}" alt="{{ $package->title_ar }}">
              <span class="title">{{ $package->title_ar }}</span>
              <p class="desc">{{ Str::limit($package->description_ar, 80) }}</p>
            </div>
          </div>
          @endforeach
        </div>

        <h4 class="page-header" style="margin-top: 30px;"><i class="fa fa-star"></i> حدد عدد النجوم (التقييم)</h4>
        
        <div class="text-center">
          <div class="star-rating">
            <input type="radio" id="star5" name="stars" value="5" {{ $user->stars == 5 ? 'checked' : '' }} />
            <label for="star5" title="5 stars"><i class="fa fa-star"></i></label>
            <input type="radio" id="star4" name="stars" value="4" {{ $user->stars == 4 ? 'checked' : '' }} />
            <label for="star4" title="4 stars"><i class="fa fa-star"></i></label>
            <input type="radio" id="star3" name="stars" value="3" {{ $user->stars == 3 ? 'checked' : '' }} />
            <label for="star3" title="3 stars"><i class="fa fa-star"></i></label>
            <input type="radio" id="star2" name="stars" value="2" {{ $user->stars == 2 ? 'checked' : '' }} />
            <label for="star2" title="2 stars"><i class="fa fa-star"></i></label>
            <input type="radio" id="star1" name="stars" value="1" {{ $user->stars == 1 ? 'checked' : '' }} />
            <label for="star1" title="1 star"><i class="fa fa-star"></i></label>
          </div>
          <p class="help-block">اختر عدد النجوم التي ستظهر بجانب اسم الباقة في ملف المستخدم.</p>
        </div>

      </div>
      
      <div class="box-footer">
        <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> حفظ التعديلات</button>
        <a href="{{ route('admin.user-packages.index') }}" class="btn btn-default btn-lg">إلغاء</a>
      </div>
    </form>
  </div>
</section>

<script>
  function selectPackage(id, element) {
    // إزالة الصف الدراسي المختار من جميع البطاقات الأخرى
    document.querySelectorAll('.package-card').forEach(card => card.classList.remove('selected'));
    
    // إضافة الصف الدراسي للبطاقة المختارة
    element.classList.add('selected');
    
    // تحديث قيمة الحقل المخفي
    document.getElementById('selected_package_id').value = id;
  }
</script>
@endsection
