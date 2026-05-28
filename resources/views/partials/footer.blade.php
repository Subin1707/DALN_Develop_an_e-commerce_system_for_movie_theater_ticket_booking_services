<footer class="cinema-footer">
    <div class="container">
        <div class="footer-main">
            <div class="footer-brand">
                <a class="footer-logo" href="{{ route('home') }}">
                    <span><i class="fa fa-video-camera"></i></span>
                    <strong>Q&HCinema</strong>
                </a>

                <p>
                    Hệ thống đặt vé xem phim trực tuyến, hỗ trợ chọn ghế,
                    thanh toán demo và xuất vé QR check-in nhanh tại rạp.
                </p>

                <div class="footer-socials">
                    <a href="#" aria-label="Facebook"><i class="fa fa-facebook"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fa fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fa fa-twitter"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fa fa-youtube-play"></i></a>
                </div>
            </div>

            <div class="footer-block">
                <h5>Liên hệ</h5>
                <ul class="footer-contact">
                    <li>
                        <span><i class="fa fa-map-marker"></i></span>
                        <div>Đại học Phenikaa, Yên Nghĩa, Hà Đông</div>
                    </li>
                    <li>
                        <span><i class="fa fa-envelope"></i></span>
                        <div>23010245@st.phenikaa-uni.edu.vn</div>
                    </li>
                    <li>
                        <span><i class="fa fa-phone"></i></span>
                        <div>+84 9856 193 47</div>
                    </li>
                </ul>
            </div>

            <div class="footer-block">
                <h5>Điều hướng</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li><a href="{{ route('movies.index') }}">Phim đang chiếu</a></li>
                    <li><a href="{{ route('showtimes.index') }}">Lịch chiếu</a></li>
                    <li><a href="{{ route('theaters.index') }}">Rạp chiếu</a></li>
                    @auth
                        @if(auth()->user()->role === 'user')
                            <li><a href="{{ route('bookings.history') }}">Vé của tôi</a></li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div>
                © {{ date('Y') }} Q&HCinema. Phát triển bởi
                <strong>Lê Thái Sơn</strong> & <strong>Nguyễn Thế Trường An</strong>.
            </div>
            <div class="footer-note">
                Made with <span>♥</span> by Q&HCinema Team
            </div>
        </div>
    </div>
</footer>

<style>
    .cinema-footer {
        margin-top: 48px;
        padding: 42px 0 18px;
        background:
            linear-gradient(135deg, rgba(15,23,42,.98), rgba(17,24,39,.98) 55%, rgba(78,22,42,.96));
        border-top: 1px solid rgba(255,255,255,.08);
        color: #e5e7eb;
        box-shadow: 0 -18px 50px rgba(0,0,0,.28);
    }

    .footer-main {
        display: grid;
        grid-template-columns: minmax(0, 1.25fr) minmax(240px, .9fr) minmax(190px, .65fr);
        gap: 34px;
        align-items: start;
    }

    .footer-logo {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        color: #fff;
        text-decoration: none;
        font-size: 1.55rem;
    }

    .footer-logo:hover {
        color: #fff;
    }

    .footer-logo span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 8px;
        background: #e94560;
        box-shadow: 0 10px 24px rgba(233,69,96,.34);
    }

    .footer-brand p {
        max-width: 430px;
        margin: 18px 0;
        color: #cbd5e1;
        font-size: .98rem;
        line-height: 1.65;
    }

    .footer-socials {
        display: flex;
        gap: 10px;
    }

    .footer-socials a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 8px;
        background: rgba(255,255,255,.04);
        color: #fff;
        transition: background .18s ease, border-color .18s ease, transform .18s ease;
    }

    .footer-socials a:hover {
        background: #e94560;
        border-color: #e94560;
        color: #fff;
        transform: translateY(-2px);
    }

    .footer-block h5 {
        margin-bottom: 16px;
        color: #fff;
        font-weight: 900;
    }

    .footer-contact,
    .footer-links {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .footer-contact {
        display: grid;
        gap: 13px;
    }

    .footer-contact li {
        display: flex;
        gap: 11px;
        color: #cbd5e1;
        line-height: 1.45;
    }

    .footer-contact span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        flex: 0 0 30px;
        border-radius: 7px;
        background: rgba(233,69,96,.16);
        color: #fb7185;
    }

    .footer-links {
        display: grid;
        gap: 10px;
    }

    .footer-links a {
        color: #cbd5e1;
        text-decoration: none;
        font-weight: 700;
    }

    .footer-links a:hover {
        color: #facc15;
    }

    .footer-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-top: 34px;
        padding-top: 18px;
        border-top: 1px solid rgba(255,255,255,.08);
        color: #94a3b8;
        font-size: .88rem;
    }

    .footer-bottom strong {
        color: #e5e7eb;
    }

    .footer-note span {
        color: #e94560;
    }

    @media (max-width: 991.98px) {
        .footer-main {
            grid-template-columns: 1fr 1fr;
        }

        .footer-brand {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 767.98px) {
        .cinema-footer {
            padding-top: 32px;
        }

        .footer-main {
            grid-template-columns: 1fr;
        }

        .footer-bottom {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
