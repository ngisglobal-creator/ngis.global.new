@extends('layouts.master')

@section('title', 'إعطاء توثيقات لـ ' . $user->name)

@section('content')
<style>
  .verification-card {
    border: 2px solid #ddd;
    border-radius: 8px;
    padding: 10px;
    cursor: pointer;
    transition: all 0.3s;
    height: 100%;
    position: relative;
    background: #fff;
    text-align: center;
  }
  .verification-card:hover {
    border-color: #3c8dbc;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }
  .verification-card.selected {
    border-color: #00a65a;
    background-color: #f0fff4;
  }
  .verification-card.selected::after {
    content: '\f058';
    font-family: 'FontAwesome';
    position: absolute;
    top: 5px;
    right: 5px;
    color: #00a65a;
    font-size: 20px;
  }
  .verification-card img {
    max-width: 100%;
    height: 80px;
    object-fit: contain;
  }
</style>

<section class="content-header">
  <h1>إعطاء توثيقات لـ: <strong>{{ $user->name }}</strong></h1>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-body">
      
      <div class="row" style="margin-bottom: 20px;">
         <div class="col-md-12">
            <div class="well well-sm">
                <strong>نوع المستخدم:</strong> {{ $user->type }} | 
                <strong>التوثيقات المتاحة:</strong> {{ count($availableVerifications) }}
            </div>
         </div>
      </div>

      <form action="{{ route('admin.user-verifications.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
          @forelse($availableVerifications as $v)
            <div class="col-md-2 col-sm-4 col-xs-6" style="margin-bottom: 20px;">
              <div class="verification-card {{ in_array($v->id, $assignedIds) ? 'selected' : '' }}" 
                   onclick="toggleVerification({{ $v->id }}, this)">
                <img src="{{ $v->image_url }}" alt="Verification Image">
                <input type="checkbox" name="verification_ids[]" value="{{ $v->id }}" 
                       class="hidden" id="v_check_{{ $v->id }}" 
                       {{ in_array($v->id, $assignedIds) ? 'checked' : '' }}>
              </div>
            </div>
          @empty
            <div class="col-md-12">
              <div class="alert alert-warning">لا توجد توثيقات متاحة لهذا النوع من المستخدمين. قم بإضافتها أولاً من صفحة "التوثيقات".</div>
            </div>
          @endforelse
        </div>

        <div class="box-footer" style="padding-left: 0; margin-top: 20px;">
          <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-save"></i> حفظ التوثيقات</button>
          <a href="{{ route('admin.user-verifications.index') }}" class="btn btn-default btn-lg">إلغاء</a>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
function toggleVerification(id, element) {
    const checkbox = document.getElementById('v_check_' + id);
    checkbox.checked = !checkbox.checked;
    
    if (checkbox.checked) {
        element.classList.add('selected');
    } else {
        element.classList.remove('selected');
    }
}
</script>
@endpush
