<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Vé xem phim {{ $booking->booking_code }}</title>

    <style>
        @page {
            margin: 24px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f3f4f6;
            color: #111827;
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
        }

        .ticket {
            width: 100%;
            border: 1.5px solid #111827;
            border-radius: 10px;
            background: #ffffff;
            overflow: hidden;
        }

        .header {
            padding: 18px 22px;
            background: #111827;
            color: #ffffff;
        }

        .brand {
            font-size: 15px;
            font-weight: bold;
            letter-spacing: .8px;
            text-transform: uppercase;
        }

        .title {
            margin-top: 8px;
            font-size: 28px;
            font-weight: bold;
            line-height: 1.1;
        }

        .code {
            margin-top: 8px;
            color: #facc15;
            font-size: 15px;
            font-weight: bold;
        }

        .content {
            width: 100%;
            border-collapse: collapse;
        }

        .left {
            width: 68%;
            padding: 20px 22px;
            vertical-align: top;
        }

        .right {
            width: 32%;
            padding: 20px;
            vertical-align: top;
            border-left: 1.5px dashed #9ca3af;
            text-align: center;
            background: #f9fafb;
        }

        .movie-label {
            color: #6b7280;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        .movie-title {
            margin-top: 4px;
            margin-bottom: 18px;
            font-size: 24px;
            font-weight: bold;
            line-height: 1.2;
            color: #111827;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 9px 0;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }

        .label {
            width: 35%;
            color: #6b7280;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .value {
            color: #111827;
            font-weight: bold;
        }

        .seat-box {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 6px;
            background: #fee2e2;
            color: #991b1b;
            font-weight: bold;
        }

        .total {
            margin-top: 18px;
            padding: 12px 14px;
            border-radius: 8px;
            background: #111827;
            color: #ffffff;
        }

        .total span {
            color: #d1d5db;
            font-size: 12px;
            text-transform: uppercase;
        }

        .total strong {
            display: block;
            margin-top: 4px;
            color: #facc15;
            font-size: 22px;
        }

        .qr-title {
            color: #111827;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .qr-box {
            display: inline-block;
            margin: 14px auto 10px;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
        }

        .qr-note {
            color: #4b5563;
            font-size: 11px;
            line-height: 1.45;
        }

        .status-box {
            margin: 24px auto;
            padding: 14px;
            border: 2px solid #9ca3af;
            border-radius: 8px;
            color: #374151;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-box.red {
            border-color: #dc2626;
            color: #b91c1c;
        }

        .footer {
            padding: 14px 22px;
            border-top: 1px solid #e5e7eb;
            background: #f9fafb;
            color: #4b5563;
            font-size: 11px;
            line-height: 1.45;
            text-align: center;
        }

        .tear {
            margin: 14px 0 0;
            color: #9ca3af;
            font-size: 10px;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>
@php
    $showtimeStart = \Carbon\Carbon::parse($booking->showtime->start_time);
    $paymentLabel = match($booking->payment_method) {
        'cash' => 'Tiền mặt',
        'transfer' => 'Chuyển khoản',
        'online' => 'Online',
        default => 'N/A',
    };
@endphp

<div class="ticket">
    <div class="header">
        <div class="brand">Q&HCINEMA</div>
        <div class="title">Vé xem phim</div>
        <div class="code">{{ $booking->booking_code }}</div>
    </div>

    <table class="content">
        <tr>
            <td class="left">
                <div class="movie-label">Phim</div>
                <div class="movie-title">{{ $booking->showtime->movie->title }}</div>

                <table class="info-table">
                    <tr>
                        <td class="label">Khách hàng</td>
                        <td class="value">{{ $booking->user->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Suất chiếu</td>
                        <td class="value">{{ $showtimeStart->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Phòng</td>
                        <td class="value">{{ $booking->room_code ?: ($booking->showtime->room->name ?? 'N/A') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Ghế</td>
                        <td class="value"><span class="seat-box">{{ $booking->seats }}</span></td>
                    </tr>
                    <tr>
                        <td class="label">Thanh toán</td>
                        <td class="value">{{ $paymentLabel }}</td>
                    </tr>
                    <tr>
                        <td class="label">Trạng thái</td>
                        <td class="value">
                            @if($booking->checked_in_at)
                                Đã sử dụng
                            @elseif($booking->status === 'confirmed')
                                Đã xác nhận
                            @else
                                Chưa xác nhận
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="total">
                    <span>Tổng tiền</span>
                    <strong>{{ number_format($booking->total_price) }} đ</strong>
                </div>
            </td>

            <td class="right">
                @if($booking->checked_in_at)
                    <div class="status-box red">Đã sử dụng</div>
                    <div class="qr-note">Vé đã check-in lúc {{ $booking->checked_in_at->format('d/m/Y H:i') }}.</div>
                @elseif(now()->gt($showtimeStart))
                    <div class="status-box">Hết hiệu lực</div>
                    <div class="qr-note">Suất chiếu đã bắt đầu, mã QR không còn hiệu lực.</div>
                @elseif($canShowQr)
                    <div class="qr-title">QR Check-in</div>
                    <div class="qr-box">
                        <img src="{{ $qrDataUri }}" width="178" height="178" alt="QR Check-in">
                    </div>
                    <div class="qr-note">
                        Xuất trình mã này cho nhân viên khi vào rạp.<br>
                        Mã chỉ dùng cho đúng vé và suất chiếu đã ghi.
                    </div>
                @else
                    <div class="status-box">Chưa xác nhận</div>
                    <div class="qr-note">Vé chỉ có QR sau khi thanh toán hoặc được nhân viên xác nhận.</div>
                @endif

                <div class="tear">- - - - - - - - - - -</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        Vé chỉ có giá trị cho đúng suất chiếu đã ghi. Vui lòng đến trước giờ chiếu 10 phút.
        Khi cần hỗ trợ, cung cấp mã vé {{ $booking->booking_code }} cho nhân viên rạp.
    </div>
</div>

</body>
</html>
