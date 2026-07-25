<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $notification->title }}</title>
</head>
<body style="margin:0;background:#f5f7fb;font-family:Arial,sans-serif;color:#172033;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f5f7fb;padding:28px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:620px;background:#ffffff;border-radius:14px;overflow:hidden;border:1px solid #e3e8f2;">
                    <tr>
                        <td style="padding:28px 30px 12px;">
                            <p style="margin:0 0 8px;color:#65718a;font-size:14px;">Hi {{ $recruiter->name }},</p>
                            <h1 style="margin:0;color:#111827;font-size:24px;line-height:1.25;">{{ $notification->title }}</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 30px 24px;">
                            <p style="margin:0;color:#344054;font-size:16px;line-height:1.6;">{{ $notification->message }}</p>

                            @if (! empty($notification->data['report']))
                                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-top:24px;border-collapse:collapse;">
                                    @foreach ($notification->data['report'] as $label => $value)
                                        <tr>
                                            <td style="padding:10px 0;border-bottom:1px solid #edf1f7;color:#65718a;font-size:14px;">{{ str_replace('_', ' ', ucfirst($label)) }}</td>
                                            <td align="right" style="padding:10px 0;border-bottom:1px solid #edf1f7;color:#111827;font-size:16px;font-weight:700;">{{ $value }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif

                            @if ($notification->action_url)
                                <p style="margin:26px 0 0;">
                                    <a href="{{ url($notification->action_url) }}" style="display:inline-block;background:#172033;color:#ffffff;text-decoration:none;padding:12px 18px;border-radius:10px;font-weight:700;">
                                        View in dashboard
                                    </a>
                                </p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:18px 30px;background:#f8fafc;color:#8a94a6;font-size:12px;line-height:1.5;">
                            You are receiving this because email notifications are enabled in your recruiter settings.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
