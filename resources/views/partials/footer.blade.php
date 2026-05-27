
<section id="footer" class="pt-5 pb-3" style="background: linear-gradient(135deg, #1a1a2e 60%, #16213e 100%); color: #fff; border-radius: 32px 32px 0 0; box-shadow: 0 -2px 24px 0 rgba(0,0,0,0.2);">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h3>
                    <a class="text-white text-decoration-none fw-bold" href="{{ url('/') }}">
                        <i class="fa fa-video-camera text-danger me-2"></i> Q&HCinema
                    </a>
                </h3>
                <p class="mt-3 small">
                    © {{ date('Y') }} Rạp Chiếu Phim Q&H<br>
                    Developed by <strong>Lê Thái Sơn</strong> & <strong>Nguyễn Thế Trường An</strong> 🎥
                </p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-white social-icon" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white social-icon" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white social-icon" title="Twitter"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">Liên hệ</h5>
                <p class="mb-1"><i class="fa fa-map-marker-alt text-danger me-2"></i>Đại học Phenikaa, Yên Nghĩa, Hà Đông</p>
                <p class="mb-1"><i class="fa fa-envelope text-danger me-2"></i>23010245@st.phenikaa-uni.edu.vn</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-danger me-2"></i>+84 9856 193 47</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">Về chúng tôi</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="footer-link">Trang chủ</a></li>
                    <li><a href="#" class="footer-link">Phim đang chiếu</a></li>
                    <li><a href="#" class="footer-link">Lịch chiếu</a></li>
                    <li><a href="#" class="footer-link">Liên hệ</a></li>
                </ul>
            </div>
        </div>
        <div class="text-center mt-4 small" style="opacity:0.7;">
            Made with <span style="color:#e94560;">&#10084;</span> by Q&HCinema Team
        </div>
    </div>
</section>

<style>
    .social-icon {
        font-size: 1.3rem;
        transition: color 0.2s, transform 0.2s;
    }
    .social-icon:hover {
        color: #e94560;
        transform: scale(1.2) rotate(-8deg);
        text-shadow: 0 2px 8px #e9456044;
    }
    .footer-link {
        color: #fff;
        text-decoration: none;
        transition: color 0.2s;
    }
    .footer-link:hover {
        color: #e94560;
        text-decoration: underline;
    }
</style>


@push('scripts')
<!-- FontAwesome CDN for social icons (if not already included) -->
<script src="https://kit.fontawesome.com/4e9c8e6e7b.js" crossorigin="anonymous"></script>
@endpush
