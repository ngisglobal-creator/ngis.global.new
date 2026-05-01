<style>
    .user-status-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        align-items: center;
        padding: 10px;
    }

    .verification-header img {
        max-width: 90px; /* Increased slightly for better visibility */
        height: auto;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        border: 1px solid #eee;
    }

    .status-content-wrapper {
        display: flex;
        flex-direction: column; /* Stack vertically to fit standard sidebar width */
        gap: 15px;
        width: 100%;
        align-items: center;
    }

    .side-column-sidebar {
        background: #fff;
        border-radius: 20px;
        padding: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.04);
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 100%; /* Fluid width */
        max-width: 280px;
        position: relative;
    }

    .side-column-sidebar::before {
        content: '';
        position: absolute;
        top: 30px;
        bottom: 30px;
        right: 41px; /* Precision adjustment for RTL line */
        width: 2px;
        background: #f1f4f8;
        z-index: 1;
    }

    .sidebar-item-row {
        display: flex;
        align-items: center;
        gap: 15px;
        position: relative;
        z-index: 2;
        transition: all 0.3s;
        text-align: right;
        flex-direction: row; /* Standard RTL flex flow */
    }

    .sidebar-icon-wrapper {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #eee;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    }

    .sidebar-icon-wrapper img {
        width: 80%;
        height: 80%;
        object-fit: contain;
    }

    .sidebar-text-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .sidebar-text-info h4 {
        margin: 0;
        font-size: 13px;
        font-weight: 800;
        color: #555;
    }

    /* Active State */
    .sidebar-item-row.active h4 {
        color: #1e3a5f;
    }

    .sidebar-item-row.active .sidebar-icon-wrapper {
        background: #fff;
        border-color: #3c8dbc;
        box-shadow: 0 5px 15px rgba(60, 141, 188, 0.15);
        transform: scale(1.05);
    }

    .current-badge {
        font-size: 10px;
        color: #3c8dbc;
        font-weight: 800;
        display: block;
        margin-top: 2px;
    }

    .star-rating-sidebar {
        margin-top: 4px;
        display: flex;
        gap: 2px;
        justify-content: flex-start;
    }

    .star-rating-sidebar i {
        font-size: 10px;
    }

    /* Grayscale for non-active */
    .sidebar-item-row:not(.active) {
        opacity: 0.6;
        filter: grayscale(0.8);
    }
</style>

<div class="user-status-container">
    
    <!-- Top Verification Image -->
    @if($user->verifications->count() > 0)
        <div class="verification-header">
            <img src="{{ $user->verifications->first()->image_url }}" alt="Verification Status">
        </div>
    @endif

    <div class="status-content-wrapper">
        
        <!-- Packages Column -->
        <div class="side-column-sidebar">
            @foreach($packages as $package)
                @php $isActive = ($user->package_id == $package->id); @endphp
                <div class="sidebar-item-row {{ $isActive ? 'active' : '' }}">
                    <div class="sidebar-icon-wrapper">
                        <img src="{{ $package->image_url }}" alt="{{ $package->getTitleAttribute() }}">
                    </div>
                    <div class="sidebar-text-info">
                        <h4>{{ $package->getTitleAttribute() }}</h4>
                        @if($isActive)
                            <span class="current-badge">الباقة الحالية</span>
                            <div class="star-rating-sidebar">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa {{ $i <= $user->stars ? 'fa-star text-yellow' : 'fa-star-o text-gray' }}"></i>
                                @endfor
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Certificates Column (Matched Design) -->
        <div class="side-column-sidebar">
            @if(is_array($user->certificates) && count($user->certificates) > 0)
                @foreach($user->certificates as $cert)
                    <div class="sidebar-item-row active"> <!-- Always active style for uploaded certificates -->
                        <div class="sidebar-icon-wrapper" style="width: 68px; height: 68px;"> <!-- Increased slightly 68px -->
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($cert) }}" alt="Certificate">
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-muted text-center" style="font-size: 10px; padding: 20px 0;">لا توجد شهادات</div>
            @endif
        </div>

    </div>
</div>
