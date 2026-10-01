<section class="section-padding bg-light" id="testimonials-section">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <span class="text-uppercase text-primary fw-bold small tracking-wider">Traveler Stories</span>
                <h2 class="section-title">What Visitors Say</h2>
                <p class="text-muted">Real experiences shared by local and international travelers who visited Gubat's surfing camps and resorts.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Bootstrap Carousel -->
                <div id="testimonialsCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators mb-0" style="bottom: -40px;">
                        @foreach($testimonials as $index => $testimonial)
                            <button type="button" data-bs-target="#testimonialsCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }} bg-primary" aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>

                    <div class="carousel-inner">
                        @foreach($testimonials as $index => $testimonial)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="card card-tourism border-0 p-4 p-md-5 text-center bg-white">
                                    <div class="text-warning mb-3">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $testimonial->rating)
                                                <i class="bi bi-star-fill fs-4"></i>
                                            @else
                                                <i class="bi bi-star fs-4"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <blockquote class="blockquote mb-4">
                                        <p class="fs-5 text-dark italic">"{{ $testimonial->content }}"</p>
                                    </blockquote>
                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        @php
                                            $words = explode(' ', $testimonial->visitor_name);
                                            $initials = '';
                                            foreach($words as $w) {
                                                $initials .= strtoupper(substr($w, 0, 1));
                                            }
                                            $initials = substr($initials, 0, 2);
                                        @endphp
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 50px; height: 50px;">
                                            {{ $initials }}
                                        </div>
                                        <div class="text-start">
                                            <h6 class="mb-0 fw-bold text-dark">{{ $testimonial->visitor_name }}</h6>
                                            <small class="text-muted">{{ $testimonial->visitor_role }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div style="height: 40px;"></div>
    </div>
</section>
