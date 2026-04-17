<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Vé xem phim</title>

    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 14px;
            color: #000;
        }

        .ticket {
            border: 2px dashed #333;
            padding: 20px;
            width: 100%;
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
        }

        .row {
            margin-bottom: 6px;
        }

        .label {
            font-weight: bold;
        }

        .qr {
            text-align: center;
            margin-top: 20px;
        }

        .footer {
            font-size: 12px;
            text-align: center;
            margin-top: 15px;
            color: #555;
        }

        .used {
            text-align: center;
            font-size: 26px;
            font-weight: bold;
            margin-top: 20px;
        }

        .used.used-red {
            color: #c00;
        }

        .used.used-gray {
            color: #777;
        }
    </style>
</head>
<body>

<div class="ticket">

    <h2>🎬 VÉ XEM PHIM</h2>

    <div class="row">
        <span class="label">Mã vé:</span>
        {{ $booking->booking_code }}
    </div>

    <div class="row">
        <span class="label">Phim:</span>
        {{ $booking->showtime->movie->title }}
    </div>

    <div class="row">
        <span class="label">Suất chiếu:</span>
        {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('d/m/Y H:i') }}
    </div>

    <div class="row">
        <span class="label">Phòng:</span>
        {{ $booking->room_code }}
    </div>

    <div class="row">
        <span class="label">Ghế:</span>
        {{ $booking->seats }}
    </div>

    <div class="row">
        <span class="label">Tổng tiền:</span>
        {{ number_format($booking->total_price) }} ₫
    </div>

    <hr>

    {{-- ================= TRẠNG THÁI VÉ ================= --}}
    @php
        $showtimeStart = \Carbon\Carbon::parse($booking->showtime->start_time);
        $now = now();
    @endphp

    {{-- ĐÃ SỬ DỤNG --}}
    @if($booking->checked_in_at)
        <div class="used used-red">
            ĐÃ SỬ DỤNG
        </div>

    {{-- HẾT HIỆU LỰC --}}
    @elseif($now->gt($showtimeStart))
        <div class="used used-gray">
            HẾT HIỆU LỰC
        </div>

    {{-- CÒN HIỆU LỰC → HIỆN QR --}}
    @else
        <div class="qr">
            {!! QrCode::size(150)->generate(
                route('staff.bookings.scan', $booking->booking_code)
            ) !!}
            <p>Quét mã QR khi vào rạp</p>
        </div>
    @endif

    <div class="footer">
        Vé chỉ có giá trị cho đúng suất chiếu đã ghi.<br>
        Vui lòng đến trước giờ chiếu 10 phút.
    </div>

</div>

</body>
</html>
