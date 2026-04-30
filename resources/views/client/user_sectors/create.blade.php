@extends('client.layouts.master')

@section('title', 'تعديل القطاعات الممارسة')

@section('content')
<section class="content-header">
    <h1>
        اختيار القطاعات
        <small>اختر القطاعات التي ينتمي لها نشاطك</small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">قائمة القطاعات المتاحة</h3>
                </div>
                
                <form action="{{ route('user-sectors.store') }}" method="POST">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label>اختر القطاعات (يمكنك اختيار أكثر من قطاع):</label>
                            <div class="row">
                                @foreach($allSectors as $sector)
                                    <div class="col-md-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="sector_ids[]" value="{{ $sector->id }}" 
                                                       {{ in_array($sector->id, $userSectorsIds) ? 'checked' : '' }}>
                                                {{ $sector->name_ar }} ({{ $sector->name_en }})
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-lg">حفظ التغييرات</button>
                        <a href="{{ route('user-sectors.index') }}" class="btn btn-default btn-lg">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
