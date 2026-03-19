<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ ($meta['app_name'] ?? config('app.name')) . ' Low Stock Alert' }}</title>
</head>
<body style="margin:0;padding:0;background-color:#f4efe8;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:linear-gradient(180deg,#f4efe8 0%,#fffaf3 100%);margin:0;padding:24px 0;width:100%;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:680px;background-color:#ffffff;border-radius:24px;overflow:hidden;box-shadow:0 12px 32px rgba(120,53,15,0.10);">
                    <tr>
                        <td style="background:linear-gradient(135deg,#1f4b3f 0%,#355f52 55%,#d97706 100%);padding:36px 32px 28px;">
                            <div style="font-size:12px;letter-spacing:1.6px;text-transform:uppercase;color:#fef3c7;font-weight:700;">
                                Inventory Monitor
                            </div>
                            <h1 style="margin:12px 0 10px;font-size:30px;line-height:1.2;color:#ffffff;font-weight:700;">
                                Low stock needs attention
                            </h1>
                            <p style="margin:0;font-size:15px;line-height:1.7;color:#ecfdf5;">
                                {{ $meta['app_name'] ?? config('app.name') }} found {{ $materials->count() }} item(s) at or below minimum stock level.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:28px 32px 8px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td style="padding:0 0 16px;">
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td style="width:50%;padding:0 8px 12px 0;vertical-align:top;">
                                                    <div style="background:#f8fafc;border:1px solid #e5e7eb;border-radius:18px;padding:18px;">
                                                        <div style="font-size:12px;color:#6b7280;text-transform:uppercase;letter-spacing:1.2px;">Generated</div>
                                                        <div style="margin-top:8px;font-size:18px;font-weight:700;color:#111827;">{{ $meta['generated_at'] ?? now()->format('d M Y, h:i A') }}</div>
                                                    </div>
                                                </td>
                                                <td style="width:50%;padding:0 0 12px 8px;vertical-align:top;">
                                                    <div style="background:#fff7ed;border:1px solid #fdba74;border-radius:18px;padding:18px;">
                                                        <div style="font-size:12px;color:#9a3412;text-transform:uppercase;letter-spacing:1.2px;">Alert Email</div>
                                                        <div style="margin-top:8px;font-size:18px;font-weight:700;color:#7c2d12;">{{ $meta['recipient_email'] ?? config('mail.from.address') }}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 32px 8px;">
                            <p style="margin:0 0 18px;font-size:15px;line-height:1.7;color:#4b5563;">
                                Review the following materials and replenish them before they impact kitchen operations.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 20px 16px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:separate;border-spacing:0 12px;">
                                <thead>
                                    <tr>
                                        <th align="left" style="padding:0 12px 6px;font-size:12px;color:#6b7280;text-transform:uppercase;letter-spacing:1px;">Material</th>
                                        <th align="left" style="padding:0 12px 6px;font-size:12px;color:#6b7280;text-transform:uppercase;letter-spacing:1px;">Current</th>
                                        <th align="left" style="padding:0 12px 6px;font-size:12px;color:#6b7280;text-transform:uppercase;letter-spacing:1px;">Minimum</th>
                                        <th align="left" style="padding:0 12px 6px;font-size:12px;color:#6b7280;text-transform:uppercase;letter-spacing:1px;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($materials as $material)
                                    <tr>
                                        <td colspan="4" style="padding:0;">
                                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#fffdfa;border:1px solid #fde68a;border-radius:18px;">
                                                <tr>
                                                    <td style="padding:18px 12px;font-size:15px;font-weight:700;color:#111827;">
                                                        {{ $material->name }}
                                                    </td>
                                                    <td style="padding:18px 12px;font-size:15px;color:#374151;">
                                                        {{ number_format((float) $material->qty, 3) }} {{ $material->unit_symbol ?? $material->unit_name ?? '' }}
                                                    </td>
                                                    <td style="padding:18px 12px;font-size:15px;color:#374151;">
                                                        {{ number_format((float) $material->min_qty, 3) }} {{ $material->unit_symbol ?? $material->unit_name ?? '' }}
                                                    </td>
                                                    <td style="padding:18px 12px;">
                                                        @php
                                                        $isCritical = (float) $material->min_qty > 0 && (float) $material->qty <= ((float) $material->min_qty / 2);
                                                            @endphp
                                                            <span style="display:inline-block;padding:8px 12px;border-radius:999px;font-size:12px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;{{ $isCritical ? 'background:#fee2e2;color:#b91c1c;' : 'background:#ffedd5;color:#c2410c;' }}">
                                                                {{ $isCritical ? 'Critical' : 'Low' }}
                                                            </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:8px 32px 32px;">
                            <div style="background:#f8fafc;border:1px solid #e5e7eb;border-radius:18px;padding:18px 20px;">
                                <p style="margin:0;font-size:14px;line-height:1.7;color:#475569;">
                                    This alert was generated automatically by {{ $meta['app_name'] ?? config('app.name') }}.
                                    @if (!empty($meta['company_email']))
                                    For coordination, contact {{ $meta['company_email'] }}.
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
