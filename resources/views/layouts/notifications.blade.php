@if (isset($notifications) && $notifications->isEmpty())
<p>No notifications found.</p>

@else

@foreach ($notifications as $item)
<div style="background: var(--card); border: 1px solid var(--line); border-radius: 14px; padding: 14px; overflow: hidden;">
    <div style="display: flex">
        <div style="font-size: 15px;">
            {{ $item->message }}
        </div>
        <div style="font-size: 12px;">
            {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/y') }}
        </div>
    </div>
    <div style="font-size: 11px;">{{ $item->data }},</div>

</div>
@endforeach

@endif
