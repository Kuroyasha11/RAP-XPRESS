@extends('frontend.layouts.main')

@section('container')
    <div class="row featurette">
        <div class="col-md-7">
            <h2 class="featurette-heading">RAP-XPRESS <span class="text-muted">- Kurir lokal Palembang.</span></h2>
            <p class="lead">RAP-XPRESS adalah perusahaan kurir Palembang yang siap sedia mengantar paket kustomer
                di wilayah Palembang.</p>
        </div>
        <div class="col-md-5">
            {{-- <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500"
                    xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500"
                    preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#eee" /><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text>
                </svg> --}}

            <img src="assets/image/Logo/RAP.jpg" alt="RAP-XPRESS"
                class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500">

        </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
        <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">Lokasi Kurir</h2>
            <p class="lead">Kami melayanin jangkauan pengiriman barang, sesuai dengan map disamping.</p>
        </div>
        <div class="col-md-5 order-md-1">
            {{-- <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500"
                    height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500"
                    preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#eee" /><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text>
                </svg> --}}

            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127504.4454426171!2d104.69292327797413!3d-2.9547949044718456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3b75e8fc27a3e3%3A0x3039d80b220d0c0!2sPalembang%2C%20Kota%20Palembang%2C%20Sumatera%20Selatan!5e0!3m2!1sid!2sid!4v1642032311191!5m2!1sid!2sid"
                width="350px" height="350px" style="border:0;" allowfullscreen="" loading="lazy"
                style="margin: auto;"></iframe>

        </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
        <div class="col-md-7">
            <h2 class="featurette-heading">Motto dan Visi
                {{-- <span class="text-muted">Checkmate.</span> --}}
            </h2>
            <p class="lead">"Solution Your Bussines Online"</p>
        </div>
        <div class="col-md-5">
            {{-- <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500"
                height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500"
                preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Placeholder</title>
                <rect width="100%" height="100%" fill="#eee" /><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text>
            </svg> --}}
            <img src="assets/image/paket.jpg" alt="RAP-XPRESS"
                class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500"
                height="500">


        </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
        <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">Lokasi Kantor</h2>
            <p class="lead">Jl. Raya Perum PNS Pemkot No.3, RT.36, RW.07, Kel. Gandus, Kec. Gandus, Palembang,
                30149.</p>
        </div>
        <div class="col-md-5 order-md-1">
            {{-- <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500"
                    height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500"
                    preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#eee" /><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text>
                </svg> --}}

            {{-- <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127504.4454426171!2d104.69292327797413!3d-2.9547949044718456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3b75e8fc27a3e3%3A0x3039d80b220d0c0!2sPalembang%2C%20Kota%20Palembang%2C%20Sumatera%20Selatan!5e0!3m2!1sid!2sid!4v1642032311191!5m2!1sid!2sid"
                width="350px" height="350px" style="border:0;" allowfullscreen="" loading="lazy"
                style="margin: auto;"></iframe> --}}

        </div>
    </div>
@endsection
