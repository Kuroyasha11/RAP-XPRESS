<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
    @if ($slide)
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active"></button>
            @foreach ($slide->skip(1) as $item)
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="{{ $loop->iteration }}"></button>
            @endforeach
        </div>
    @else
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active"></button>
    @endif
    <div class="carousel-inner">
        @if ($slide)
            <div class="carousel-item active">
                @if ($slide[0]->image)
                    <img src="{{ asset('storage/' . $slide[0]->image) }}" alt="Slide-1" class="bd-placeholder-img"
                        width="100%" height="100%">
                @else
                    <img src="https://source.unsplash.com/RCAhiGJsUUE/1920x1080" alt=". . ." class="bd-placeholder-img"
                        width="100%" height="100%">
                @endif
                @if ($slide[0]->keterangan)
                    <div class="container">
                        <div class="carousel-caption bg-dark bg-opacity-50">
                            <h1><strong class="text-light">{{ $slide[0]->keterangan }}</strong></h1>
                            {{-- <p>Some representative placeholder content for the first slide of the carousel.</p>
                    <p><a class="btn btn-lg btn-primary" href="#">Sign up today</a></p> --}}
                        </div>
                    </div>
                @endif
            </div>
            @foreach ($slide->skip(1) as $item)
                <div class="carousel-item">
                    @if ($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="Slide {{ $loop->iteration }}"
                            class="bd-placeholder-img" width="100%" height="100%">
                    @else
                        <img src="https://source.unsplash.com/RCAhiGJsUUE/1920x1080" alt=". . ."
                            class="bd-placeholder-img" width="100%" height="100%">
                    @endif
                    @if ($item->keterangan)
                        <div class="container">
                            <div class="carousel-caption bg-dark bg-opacity-50">
                                <h1><strong class="text-light">{{ $item->keterangan }}</strong></h1>
                                {{-- <p>Some representative placeholder content for the third slide of this carousel.</p> --}}
                                {{-- <p><a class="btn btn-lg btn-primary" href="#">Browse gallery</a></p> --}}
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <div class="carousel-item active">
                <img src="https://source.unsplash.com/RCAhiGJsUUE/1920x1080" alt=". . ." class="bd-placeholder-img"
                    width="100%" height="100%">
            </div>
        @endif
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
