@extends('client.layouts.master')

@section('title', 'مراسلة المكتب - المحادثة')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">مركز المراسلات</h2>
            <p class="text-muted small mb-0">تواصل مباشرة مع مكاتب الإقليم للحصول على الدعم</p>
        </div>
        <div class="bg-white px-3 py-2 rounded-pill shadow-sm border">
            <span class="small fw-bold text-primary"><i class="fa-solid fa-earth-africa me-2"></i>مكاتب الإقليم في: {{ auth()->user()->country->name_ar ?? 'عام' }}</span>
        </div>
    </div>

    <div class="row g-4">
        <!-- Office List Sidebar -->
        <div class="col-lg-4 col-xl-3">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px; height: calc(100vh - 250px);">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-building-user me-2 text-primary"></i> المكاتب المتاحة</h5>
                </div>
                <div class="card-body p-0 overflow-auto">
                    <div class="list-group list-group-flush chat-list-premium">
                        @forelse($offices as $office)
                            <a href="{{ route('client.chat.index', ['office_id' => $office->id]) }}" 
                               class="list-group-item list-group-item-action border-0 px-4 py-3 d-flex align-items-center justify-content-between {{ isset($selectedOffice) && $selectedOffice->id == $office->id ? 'active' : '' }}">
                                <div class="d-flex align-items-center">
                                    <div class="position-relative">
                                        <img src="{{ $office->avatar_url }}" class="rounded-circle shadow-sm" style="width: 45px; height: 45px; object-fit: cover;">
                                        <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-light rounded-circle"></span>
                                    </div>
                                    <div class="ms-3">
                                        <div class="fw-bold mb-0 text-truncate" style="max-width: 140px;">{{ $office->name }}</div>
                                        <div class="x-small text-muted opacity-75">مكتب إقليمي</div>
                                    </div>
                                </div>
                                @php
                                    $unread = \App\Models\Message::where('sender_id', $office->id)->where('receiver_id', auth()->id())->where('is_read', false)->count();
                                @endphp
                                @if($unread > 0)
                                    <span class="badge bg-danger rounded-pill">{{ $unread }}</span>
                                @endif
                            </a>
                        @empty
                            <div class="text-center py-5">
                                <i class="fa-solid fa-building-slash text-light fs-1 mb-3"></i>
                                <p class="text-muted small">لا توجد مكاتب متاحة حالياً</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="col-lg-8 col-xl-9">
            @if(isset($selectedOffice))
                <div class="card border-0 shadow-sm d-flex flex-column" style="border-radius: 20px; height: calc(100vh - 250px);">
                    <!-- Chat Header -->
                    <div class="card-header bg-white border-bottom-0 py-3 px-4 d-flex align-items-center justify-content-between shadow-sm z-index-1">
                        <div class="d-flex align-items-center">
                            <img src="{{ $selectedOffice->avatar_url }}" class="rounded-circle shadow-sm" style="width: 40px; height: 40px; object-fit: cover;">
                            <div class="ms-3">
                                <h6 class="fw-bold mb-0">{{ $selectedOffice->name }}</h6>
                                <span class="x-small text-success fw-bold"><i class="fa-solid fa-circle small me-1"></i> متصل الآن</span>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-light rounded-circle" type="button" data-bs-toggle="dropdown" style="width: 35px; height: 35px; padding: 0;">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-file-invoice-dollar me-2"></i> تفاصيل الفواتير</a></li>
                                <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-circle-info me-2"></i> معلومات المكتب</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Chat Messages -->
                    <div class="card-body p-4 bg-light overflow-auto" id="chatBox">
                        @foreach($messages as $msg)
                            @if($msg->sender_id == auth()->id())
                                <!-- Sent Message -->
                                <div class="d-flex justify-content-end mb-4">
                                    <div class="message-container sent shadow-sm">
                                        <div class="message-text">{{ $msg->message }}</div>
                                        <div class="message-time">{{ $msg->created_at->format('H:i') }}</div>
                                    </div>
                                </div>
                            @else
                                <!-- Received Message -->
                                <div class="d-flex justify-content-start mb-4">
                                    <div class="message-container received shadow-sm">
                                        <div class="message-text">{{ $msg->message }}</div>
                                        <div class="message-time text-muted">{{ $msg->created_at->format('H:i') }}</div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Chat Footer -->
                    <div class="card-footer bg-white border-0 p-3">
                        <form id="sendMessageForm">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $selectedOffice->id }}">
                            <div class="input-group bg-light rounded-pill p-1 shadow-sm border">
                                <input type="text" name="message" id="messageInput" class="form-control border-0 bg-transparent px-3 py-2" placeholder="اكتب رسالتك هنا..." autocomplete="off" required>
                                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm" id="sendBtn">
                                    <i class="fa-solid fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="card border-0 shadow-sm h-100 d-flex align-items-center justify-content-center text-center p-5" style="border-radius: 20px;">
                    <div class="p-5">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow-sm" style="width: 100px; height: 100px;">
                            <i class="fa-solid fa-comments text-primary fs-1"></i>
                        </div>
                        <h4 class="fw-bold text-dark">ابدأ المحادثة الآن</h4>
                        <p class="text-muted mx-auto" style="max-width: 300px;">اختر أحد المكاتب الإقليمية من القائمة الجانبية للتواصل معهم مباشرة</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .chat-list-premium .list-group-item {
        transition: all 0.3s ease;
        border-right: 4px solid transparent !important;
    }
    .chat-list-premium .list-group-item.active {
        background-color: rgba(13, 110, 253, 0.05);
        color: #0d6efd;
        border-right: 4px solid #0d6efd !important;
    }
    .chat-list-premium .list-group-item:hover:not(.active) {
        background-color: #f8f9fa;
        border-right: 4px solid #dee2e6 !important;
    }
    .message-container {
        max-width: 75%;
        padding: 12px 18px;
        position: relative;
    }
    .message-container.sent {
        background: #0d6efd;
        color: #fff;
        border-radius: 20px 20px 0 20px;
    }
    .message-container.received {
        background: #fff;
        color: #333;
        border-radius: 20px 20px 20px 0;
    }
    .message-text {
        font-size: 14px;
        line-height: 1.5;
        margin-bottom: 4px;
    }
    .message-time {
        font-size: 10px;
        opacity: 0.7;
        text-align: left;
    }
    .sent .message-time {
        text-align: right;
    }
    #chatBox::-webkit-scrollbar {
        width: 5px;
    }
    #chatBox::-webkit-scrollbar-track {
        background: transparent;
    }
    #chatBox::-webkit-scrollbar-thumb {
        background: #dee2e6;
        border-radius: 10px;
    }
    .x-small { font-size: 11px; }
</style>

@push('scripts')
<script>
$(document).ready(function() {
    // Scroll to bottom of chat
    const chatBox = $('#chatBox');
    if (chatBox.length) {
        chatBox.scrollTop(chatBox[0].scrollHeight);
    }

    $('#sendMessageForm').on('submit', function(e) {
        e.preventDefault();
        const msg = $('#messageInput').val();
        if (!msg) return;

        $('#sendBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

        $.ajax({
            url: "{{ route('client.chat.send') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    const html = `
                        <div class="d-flex justify-content-end mb-4">
                            <div class="message-container sent shadow-sm">
                                <div class="message-text">${response.message.message}</div>
                                <div class="message-time">الآن</div>
                            </div>
                        </div>
                    `;
                    chatBox.append(html);
                    $('#messageInput').val('');
                    chatBox.scrollTop(chatBox[0].scrollHeight);
                }
            },
            complete: function() {
                $('#sendBtn').prop('disabled', false).html('<i class="fa-solid fa-paper-plane"></i>');
            }
        });
    });
});
</script>
@endpush
@endsection
