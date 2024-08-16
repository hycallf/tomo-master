<header id="header" class="d-flex align-items-center">
    <div class="container d-flex flex-column align-items-center">

        <div class="text-center mb-5" style="margin-top: -50px;">
            @auth()
                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary text-white">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary text-white">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                </a>
            @endauth
        </div>


        <h1 class="text-center" data-aos="fade-down">
            <a href="{{ route('home') }}" style="color: white;">
                <span style="color: white;">{{ $settings->master_nama ?? '-' }}</span>
            </a>
        </h1>

        <h2 class="text-center">Menghadirkan Kualitas, Menjaga Kendaraan Anda Seperti Baru</h2>

        <div class="social-links text-center mb-5">
            <a href="{{ $settings->facebook ?? '#' }}" target="_blank" class="facebook"><i
                    class="bi bi-facebook"></i></a>
            <a href="{{ $settings->instagram ?? '#' }}" target="_blank" class="instagram"><i
                    class="bi bi-instagram"></i></a>
            <a href="{{ $settings->whatsapp ?? '#' }}" target="_blank" class="whatsapp"><i
                    class="bi bi-whatsapp"></i></a>
        </div>

        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="container-search">
                    <form action="{{ route('home') }}" method="GET">
                        <input id="inputSearch" name="kode_unik" type="text" placeholder="Kode Perbaikan"
                            value="{{ request('kode_unik') }}" autocomplete="off">
                        <div class="search"></div>
                    </form>
                </div>
                </form>
            </div>
        </div>
    </div>

</header>
