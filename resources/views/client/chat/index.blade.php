@extends('layouts.master')

@section('title', 'مراسلة المكتب - المحادثة')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">مكاتب الإقليم ({{ auth()->user()->country->name_ar ?? '' }})</h3>
            </div>
            <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked chat-office-list" style="max-height: 600px; overflow-y: auto;">
                    @forelse($offices as $office)
                        <li class="{{ isset($selectedOffice) && $selectedOffice->id == $office->id ? 'active' : '' }}">
                            <a href="{{ route('client.chat.index', ['office_id' => $office->id]) }}" style="padding: 15px;">
                                <img src="{{ $office->avatar_url }}" class="img-circle" style="width: 30px; height: 30px; margin-left: 10px;">
                                {{ $office->name }}
                                @php
                                    $unread = \App\Models\Message::where('sender_id', $office->id)->where('receiver_id', auth()->id())->where('is_read', false)->count();
                                @endphp
                                @if($unread > 0)
                                    <span class="label label-success pull-left">{{ $unread }}</span>
                                @endif
                            </a>
                        </li>
                    @empty
                        <li class="text-center" style="padding: 20px;">لا يوجد مكاتب إقليمية حالياً في دولتك.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        @if(isset($selectedOffice))
            <div class="box box-primary direct-chat direct-chat-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">المحادثة مع المكتب: {{ $selectedOffice->name }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages" id="chatBox" style="height: 450px;">
                        @foreach($messages as $msg)
                            @if($msg->sender_id == auth()->id())
                                <!-- Message to the right -->
                                <div class="direct-chat-msg right">
                                    <div class="direct-chat-info clearfix">
                                        <span class="direct-chat-name pull-right">{{ auth()->user()->name }}</span>
                                        <span class="direct-chat-timestamp pull-left">{{ $msg->created_at->format('H:i - Y/m/d') }}</span>
                                    </div>
                                    <img class="direct-chat-img" src="{{ auth()->user()->avatar_url }}" alt="Message User Image">
                                    <div class="direct-chat-text">
                                        {{ $msg->message }}
                                    </div>
                                </div>
                            @else
                                <!-- Message. Default to the left -->
                                <div class="direct-chat-msg">
                                    <div class="direct-chat-info clearfix">
                                        <span class="direct-chat-name pull-left">{{ $selectedOffice->name }}</span>
                                        <span class="direct-chat-timestamp pull-right">{{ $msg->created_at->format('H:i - Y/m/d') }}</span>
                                    </div>
                                    <img class="direct-chat-img" src="{{ $selectedOffice->avatar_url }}" alt="Message User Image">
                                    <div class="direct-chat-text">
                                        {{ $msg->message }}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <form id="sendMessageForm">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $selectedOffice->id }}">
                        <div class="input-group">
                            <input type="text" name="message" id="messageInput" placeholder="اكتب رسالتك هنا للمكتب..." class="form-control" autocomplete="off" required>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary btn-flat" id="sendBtn">إرسال</button>
                            </span>
                        </div>
                    </form>
                </div>
                <!-- /.box-footer-->
            </div>
        @else
            <div class="box box-default">
                <div class="box-body text-center" style="padding: 100px 0;">
                    <i class="fa fa-envelope-o" style="font-size: 80px; color: #eee;"></i>
                    <h4 class="text-muted">اختر مكتب الإقليم لبدء المحادثة</h4>
                </div>
            </div>
        @endif
    </div>
</div>

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

        $('#sendBtn').prop('disabled', true);

        $.ajax({
            url: "{{ route('client.chat.send') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    const html = `
                        <div class="direct-chat-msg right">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-right">{{ auth()->user()->name }}</span>
                                <span class="direct-chat-timestamp pull-left">الآن</span>
                            </div>
                            <img class="direct-chat-img" src="{{ auth()->user()->avatar_url }}" alt="Message User Image">
                            <div class="direct-chat-text">
                                ${response.message.message}
                            </div>
                        </div>
                    `;
                    chatBox.append(html);
                    $('#messageInput').val('');
                    chatBox.scrollTop(chatBox[0].scrollHeight);
                }
            },
            complete: function() {
                $('#sendBtn').prop('disabled', false);
            }
        });
    });
});
</script>
<style>
.chat-office-list li.active a {
    background-color: #3c8dbc !important;
    color: #fff !important;
}
.chat-office-list li a:hover {
    background-color: #f4f4f4;
}
.direct-chat-text {
    border-radius: 15px !important;
}
.right .direct-chat-text {
    background-color: #3c8dbc !important;
    border-color: #3c8dbc !important;
    color: #fff !important;
}
</style>
@endpush
@endsection
