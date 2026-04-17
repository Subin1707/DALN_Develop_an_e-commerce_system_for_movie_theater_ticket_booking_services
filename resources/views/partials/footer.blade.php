<section id="footer" class="bg-black text-white pt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h3>
                    <a class="text-white text-decoration-none" href="{{ url('/') }}">
                        <i class="fa fa-video-camera text-danger me-2"></i> Q&HCinema
                    </a>
                </h3>
                <p class="mt-3">
                    © {{ date('Y') }} Rạp Chiếu Phim Q&H | Developed by 
                    <strong>Nguyễn Mạnh Quyền</strong> & <strong>Nguyễn Huy Hiệp</strong> 🎥
                </p>
                <p class="mb-1"><i class="fa fa-map-marker text-danger me-2"></i>Đại học Phenikaa, Yên Nghĩa, Hà Đông</p>
                <p class="mb-1"><i class="fa fa-envelope text-danger me-2"></i>23010245@st.phenikaa-uni.edu.vn</p>
                <p class="mb-0"><i class="fa fa-phone text-danger me-2"></i>+84 9856 193 47</p>
            </div>
        </div>
    </div>
</section>


@push('scripts')
<script>
    window.addEventListener('scroll', function () {
        const navbar = document.getElementById('navbar_sticky');
        if (!navbar) return;
        const sticky = navbar.offsetTop;
        const navbarHeight = navbar.offsetHeight;
        if (window.pageYOffset >= sticky + navbarHeight) {
            navbar.classList.add('sticky');
            document.body.style.paddingTop = navbarHeight + 'px';
        } else {
            navbar.classList.remove('sticky');
            document.body.style.paddingTop = '0';
        }
    });
</script>
@endpush
