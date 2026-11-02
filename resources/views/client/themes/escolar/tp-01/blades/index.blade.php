@extends($theme->core('client'))

@section('content')
    <!-- Hero Start -->
    <section class="container-fluid py-5 hero-header wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-7 col-md-12">
                    <h1 class="mb-3 text-primary">We Care Your Baby</h1>
                    <h1 class="mb-5 display-1 text-white">The Best Play Area For Your Kids</h1>
                    <a href="" class="btn btn-primary px-4 py-3 px-md-5  me-4 btn-border-radius">Get Started</a>
                    <a href="" class="btn btn-primary px-4 py-3 px-md-5 btn-border-radius">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Start -->
    <section class="container-fluid py-5 about bg-light">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5 wow fadeIn" data-wow-delay="0.1s">
                    <div class="video border"></div>
                </div>
                <div class="col-lg-7 wow fadeIn" data-wow-delay="0.3s">
                    <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">About Us</h4>
                    <h1 class="text-dark mb-4 display-5">We Learn Smart Way To Build Bright Futute For Your Children</h1>
                    <p class="text-dark mb-4">Lorem Ipsum is simply dummy text of the printing and typesetting industry. the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                    </p>
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2"></i>Sport Activites</h6>
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2 text-primary"></i>Outdoor Games</h6>
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2 text-secondary"></i>Nutritious Foods</h6>
                        </div>
                        <div class="col-lg-6">
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2"></i>Highly Secured</h6>
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2 text-primary"></i>Friendly Environment</h6>
                            <h6><i class="fas fa-check-circle me-2 text-secondary"></i>Qualified Teacher</h6>
                        </div>
                    </div>
                    <a href="" class="btn btn-primary px-5 py-3 btn-border-radius">More Details</a>
                </div>
            </div>
        </div>
    </section>
    <!-- About End -->

    <!-- Service Start -->
    <section class="container-fluid service py-5">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">What We Do</h4>
                <h1 class="mb-5 display-3">Thanks To Get Started With Our School</h1>
            </div>
            <div class="row g-5">
                <div class="col-md-6 col-lg-6 col-xl-3 wow fadeIn" data-wow-delay="0.1s">
                    <div class="text-center border-primary border bg-white service-item">
                        <div class="service-content d-flex align-items-center justify-content-center p-4">
                            <div class="service-content-inner">
                                <div class="p-4"><i class="fas fa-gamepad fa-6x text-primary"></i></div>
                                <a href="#" class="h4">Study & Game</a>
                                <p class="my-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus, culpa qui officiis animi Lorem ipsum dolor sit amet, 
                                    consectetur adipisicing elit.</p>
                                <a href="#" class="btn btn-primary text-white px-4 py-2 my-2 btn-border-radius">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3 wow fadeIn" data-wow-delay="0.3s">
                    <div class="text-center border-primary border bg-white service-item">
                        <div class="service-content d-flex align-items-center justify-content-center p-4">
                            <div class="service-content-inner">
                                <div class="p-4"><i class="fas fa-sort-alpha-down fa-6x text-primary"></i></div>
                                <a href="#" class="h4">A to Z Programs</a>
                                <p class="my-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus, culpa qui officiis animi Lorem ipsum dolor sit amet, 
                                    consectetur adipisicing elit.</p>
                                <a href="#" class="btn btn-primary text-white px-4 py-2 my-2 btn-border-radius">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3 wow fadeIn" data-wow-delay="0.5s">
                    <div class="text-center border-primary border bg-white service-item">
                        <div class="service-content d-flex align-items-center justify-content-center p-4">
                            <div class="service-content-inner">
                                <div class="p-4"><i class="fas fa-users fa-6x text-primary"></i></div>
                                <a href="#" class="h4">Expert Teacher</a>
                                <p class="my-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus, culpa qui officiis animi Lorem ipsum dolor sit amet, 
                                    consectetur adipisicing elit.</p>
                                <a href="#" class="btn btn-primary text-white px-4 py-2 my-2 btn-border-radius">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3 wow fadeIn" data-wow-delay="0.7s">
                    <div class="text-center border-primary border bg-white service-item">
                        <div class="service-content d-flex align-items-center justify-content-center p-4">
                            <div class="service-content-inner">
                                <div class="p-4"><i class="fas fa-user-nurse fa-6x text-primary"></i></div>
                                <a href="#" class="h4">Mental Health</a>
                                <p class="my-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus, culpa qui officiis animi Lorem ipsum dolor sit amet, 
                                    consectetur adipisicing elit.</p>
                                <a href="#" class="btn btn-primary text-white px-4 py-2 my-2 btn-border-radius">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Service End -->

    <!-- Programs Start -->
    <section class="container-fluid program  py-5">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Our Programs</h4>
                <h1 class="mb-5 display-3">We Offer An Exclusive Program For Kids</h1>
            </div>
            <div class="row g-5 justify-content-center">
                <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="program-item rounded">
                        <div class="program-img position-relative">
                            <div class="overflow-hidden img-border-radius">
                                <img src="{{asset('build/client/themes/escolar/tp-01/images/program-1.jpg')}}" class="img-fluid w-100" alt="Image">
                            </div>
                            <div class="px-4 py-2 bg-primary text-white program-rate">$60.99</div>
                        </div>
                        <div class="program-text bg-white px-4 pb-3">
                            <div class="program-text-inner">
                                <a href="#" class="h4">English For Today</a>
                                <p class="mt-3 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed purus consectetur,</p>
                            </div>
                        </div>
                        <div class="program-teacher d-flex align-items-center border-top border-primary bg-white px-4 py-3">
                            <img src="{{asset('build/client/themes/escolar/tp-01/images/program-teacher.jpg')}}" class="img-fluid rounded-circle p-2 border border-primary bg-white" alt="Image" style="width: 70px; height: 70px;">
                            <div class="ms-3">
                                <h6 class="mb-0 text-primary">Mary Mordern</h6>
                                <small>Arts Designer</small>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between px-4 py-2 bg-primary rounded-bottom">
                            <small class="text-white"><i class="fas fa-wheelchair me-1"></i> 30 Sits</small>
                            <small class="text-white"><i class="fas fa-book me-1"></i> 11 Lessons</small>
                            <small class="text-white"><i class="fas fa-clock me-1"></i> 60 Hours</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.3s">
                    <div class="program-item rounded">
                        <div class="program-img position-relative">
                            <div class="overflow-hidden img-border-radius">
                                <img src="{{asset('build/client/themes/escolar/tp-01/images/program-2.jpg')}}" class="img-fluid w-100" alt="Image">
                            </div>
                            <div class="px-4 py-2 bg-primary text-white program-rate">$60.99</div>
                        </div>
                        <div class="program-text bg-white px-4 pb-3">
                            <div class="program-text-inner">
                                <a href="#" class="h4">Graphics Arts</a>
                                <p class="mt-3 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed purus consectetur,</p>
                            </div>
                        </div>
                        <div class="program-teacher d-flex align-items-center border-top border-primary bg-white px-4 py-3">
                            <img src="{{asset('build/client/themes/escolar/tp-01/images/program-teacher.jpg')}}" class="img-fluid rounded-circle p-2 border border-primary bg-white" alt="" style="width: 70px; height: 70px;">
                            <div class="ms-3">
                                <h6 class="mb-0 text-primary">Mary Mordern</h6>
                                <small>Arts Designer</small>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between px-4 py-2 bg-primary rounded-bottom">
                            <small class="text-white"><i class="fas fa-wheelchair me-1"></i> 30 Sits</small>
                            <small class="text-white"><i class="fas fa-book me-1"></i> 11 Lessons</small>
                            <small class="text-white"><i class="fas fa-clock me-1"></i> 60 Hours</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.5s">
                    <div class="program-item rounded">
                        <div class="program-img position-relative">
                            <div class="overflow-hidden img-border-radius">
                                <img src="{{asset('build/client/themes/escolar/tp-01/images/program-3.jpg')}}" class="img-fluid w-100" alt="Image">
                            </div>
                            <div class="px-4 py-2 bg-primary text-white program-rate">$60.99</div>
                        </div>
                        <div class="program-text bg-white px-4 pb-3">
                            <div class="program-text-inner">
                                <a href="#" class="h4">General Science</a>
                                <p class="mt-3 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed purus consectetur,</p>
                            </div>
                        </div>
                        <div class="program-teacher d-flex align-items-center border-top border-primary bg-white px-4 py-3">
                            <img src="{{asset('build/client/themes/escolar/tp-01/images/program-teacher.jpg')}}" class="img-fluid rounded-circle p-2 border border-primary bg-white" alt="" style="width: 70px; height: 70px;">
                            <div class="ms-3">
                                <h6 class="mb-0 text-primary">Mary Mordern</h6>
                                <small>Arts Designer</small>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between px-4 py-2 bg-primary rounded-bottom">
                            <small class="text-white"><i class="fas fa-wheelchair me-1"></i> 30 Sits</small>
                            <small class="text-white"><i class="fas fa-book me-1"></i> 11 Lessons</small>
                            <small class="text-white"><i class="fas fa-clock me-1"></i> 60 Hours</small>
                        </div>
                    </div>
                </div>
                <div class="d-inline-block text-center wow fadeIn" data-wow-delay="0.1s">
                    <a href="#" class="btn btn-primary px-5 py-3 text-white btn-border-radius">Vew All Programs</a>
                </div>
            </div> 
        </div>
    </section>
    <!-- Program End -->

    <!-- Events Start -->
    <section class="container-fluid events py-5 bg-light">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Our Events</h4>
                <h1 class="mb-5 display-3">Our Upcoming Events</h1>
            </div>
            <div class="row g-5 justify-content-center">
                <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="events-item bg-primary rounded">
                        <div class="events-inner position-relative">
                            <div class="events-img overflow-hidden rounded-circle position-relative">
                                <img src="{{asset('build/client/themes/escolar/tp-01/images/event-1.jpg')}}" class="img-fluid w-100 rounded-circle" alt="Image">
                                <div class="event-overlay">
                                    <a href="{{asset('build/client/themes/escolar/tp-01/images/event-1.jpg')}}" data-lightbox="event-1"><i class="fas fa-search-plus text-white fa-2x"></i></a>
                                </div>
                            </div>
                            <div class="px-4 py-2 bg-secondary text-white text-center events-rate">29 Nov</div>
                            <div class="d-flex justify-content-between px-4 py-2 bg-secondary">
                                <small class="text-white"><i class="fas fa-calendar me-1 text-primary"></i> 10:00am - 12:00pm</small>
                                <small class="text-white"><i class="fas fa-map-marker-alt me-1 text-primary"></i> New York</small>
                            </div>
                        </div>
                        <div class="events-text p-4 border border-primary bg-white border-top-0 rounded-bottom">
                            <a href="#" class="h4">Music & drawing workshop</a>
                            <p class="mb-0 mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed purus consectetur,</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.3s">
                    <div class="events-item bg-primary rounded">
                        <div class="events-inner position-relative">
                            <div class="events-img overflow-hidden rounded-circle position-relative">
                                <img src="{{asset('build/client/themes/escolar/tp-01/images/event-2.jpg')}}" class="img-fluid w-100 rounded-circle" alt="Image">
                                <div class="event-overlay">
                                    <a href="{{asset('build/client/themes/escolar/tp-01/images/event-3.jpg')}}" data-lightbox="event-1"><i class="fas fa-search-plus text-white fa-2x"></i></a>
                                </div>
                            </div>
                            <div class="px-4 py-2 bg-secondary text-white text-center events-rate">29 Nov</div>
                            <div class="d-flex justify-content-between px-4 py-2 bg-secondary">
                                <small class="text-white"><i class="fas fa-calendar me-1 text-primary"></i> 10:00am - 12:00pm</small>
                                <small class="text-white"><i class="fas fa-map-marker-alt me-1 text-primary"></i> New York</small>
                            </div>
                        </div>
                        <div class="events-text p-4 border border-primary bg-white border-top-0 rounded-bottom">
                            <a href="#" class="h4">Why need study</a>
                            <p class="mb-0 mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed purus consectetur,</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.5s">
                    <div class="events-item bg-primary rounded">
                        <div class="events-inner position-relative">
                            <div class="events-img overflow-hidden rounded-circle position-relative">
                                <img src="{{asset('build/client/themes/escolar/tp-01/images/event-3.jpg')}}" class="img-fluid w-100 rounded-circle" alt="Image">
                                <div class="event-overlay">
                                    <a href="{{asset('build/client/themes/escolar/tp-01/images/event-3.jpg')}}" data-lightbox="event-1"><i class="fas fa-search-plus text-white fa-2x"></i></a>
                                </div>
                            </div>
                            <div class="px-4 py-2 bg-secondary text-white text-center events-rate">29 Nov</div>
                            <div class="d-flex justify-content-between px-4 py-2 bg-secondary">
                                <small class="text-white"><i class="fas fa-calendar me-1 text-primary"></i> 10:00am - 12:00pm</small>
                                <small class="text-white"><i class="fas fa-map-marker-alt me-1 text-primary"></i> New York</small>
                            </div>
                        </div>
                        <div class="events-text p-4 border border-primary bg-white border-top-0 rounded-bottom">
                            <a href="#" class="h4">Child health consciousness</a>
                            <p class="mb-0 mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed purus consectetur,</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Events End-->

    <!-- Team Start-->
    <section class="container-fluid team py-5">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Our Team</h4>
                <h1 class="mb-5 display-3">Meet With Our Expert Teacher</h1>
            </div>
            <div class="row g-5 justify-content-center">
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeIn" data-wow-delay="0.1s">
                    <div class="team-item border border-primary img-border-radius overflow-hidden">
                        <img src="{{asset('build/client/themes/escolar/tp-01/images/team-1.jpg')}}" class="img-fluid w-100" alt="">
                        <div class="team-icon d-flex align-items-center justify-content-center">
                            <a class="share btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fas fa-share-alt"></i></a>
                            <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fab fa-twitter"></i></a>
                            <a class="share-link btn btn-primary btn-md-square text-white rounded-circle" href=""><i class="fab fa-instagram"></i></a>
                        </div>
                        <div class="team-content text-center py-3">
                            <h4 class="text-primary">Linda Carlson</h4>
                            <p class="text-muted mb-2">English Teacher</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeIn" data-wow-delay="0.3s">
                    <div class="team-item border border-primary img-border-radius overflow-hidden">
                        <img src="{{asset('build/client/themes/escolar/tp-01/images/team-2.jpg')}}" class="img-fluid w-100" alt="">
                        <div class="team-icon d-flex align-items-center justify-content-center">
                            <a class="share btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fas fa-share-alt"></i></a>
                            <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fab fa-twitter"></i></a>
                            <a class="share-link btn btn-primary btn-md-square text-white rounded-circle" href=""><i class="fab fa-instagram"></i></a>
                        </div>
                        <div class="team-content text-center py-3">
                            <h4 class="text-primary">Linda Carlson</h4>
                            <p class="text-muted mb-2">English Teacher</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeIn" data-wow-delay="0.5s">
                    <div class="team-item border border-primary img-border-radius overflow-hidden">
                        <img src="{{asset('build/client/themes/escolar/tp-01/images/team-3.jpg')}}" class="img-fluid w-100" alt="">
                        <div class="team-icon d-flex align-items-center justify-content-center">
                            <a class="share btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fas fa-share-alt"></i></a>
                            <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fab fa-twitter"></i></a>
                            <a class="share-link btn btn-primary btn-md-square text-white rounded-circle" href=""><i class="fab fa-instagram"></i></a>
                        </div>
                        <div class="team-content text-center py-3">
                            <h4 class="text-primary">Linda Carlson</h4>
                            <p class="text-muted mb-2">English Teacher</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeIn" data-wow-delay="0.7s">
                    <div class="team-item border border-primary img-border-radius overflow-hidden">
                        <img src="{{asset('build/client/themes/escolar/tp-01/images/team-4.jpg')}}" class="img-fluid w-100" alt="">
                        <div class="team-icon d-flex align-items-center justify-content-center">
                            <a class="share btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fas fa-share-alt"></i></a>
                            <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fab fa-twitter"></i></a>
                            <a class="share-link btn btn-primary btn-md-square text-white rounded-circle" href=""><i class="fab fa-instagram"></i></a>
                        </div>
                        <div class="team-content text-center py-3">
                            <h4 class="text-primary">Linda Carlson</h4>
                            <p class="text-muted mb-2">English Teacher</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Team End-->

    <!-- Testimonial Start -->
    <div class="container-fluid testimonial py-5">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Our Testimonials</h4>
                <h1 class="mb-5 display-3">Parents Say About Us</h1>
            </div>
            <div class="owl-carousel testimonial-carousel wow fadeIn" data-wow-delay="0.3s">
                <div class="testimonial-item img-border-radius bg-light border border-primary p-4">
                    <div class="p-4 position-relative">
                        <i class="fa fa-quote-right fa-2x text-primary position-absolute" style="top: 15px; right: 15px;"></i>
                        <div class="d-flex align-items-center">
                            <div class="border border-primary bg-white rounded-circle">
                                <img src="{{asset('build/client/themes/escolar/tp-01/images/testimonial-2.jpg')}}" class="rounded-circle p-2" style="width: 80px; height: 80px; border-style: dotted; border-color: var(--bs-primary);" alt="">
                            </div>
                            <div class="ms-4">
                                <h4 class="text-dark">Client Name</h4>
                                <p class="m-0 pb-3">Profession</p>
                                <div class="d-flex pe-5">
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                </div>
                            </div>
                        </div>
                        <div class="border-top border-primary mt-4 pt-3">
                            <p class="mb-0">Lorem Ipsum is simply dummy text of the printing Ipsum has been the industry's standard dummy text ever since the 1500s,
                            </p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item img-border-radius bg-light border border-primary p-4">
                    <div class="p-4 position-relative">
                        <i class="fa fa-quote-right fa-2x text-primary position-absolute" style="top: 15px; right: 15px;"></i>
                        <div class="d-flex align-items-center">
                            <div class="border border-primary bg-white rounded-circle">
                                <img src="{{asset('build/client/themes/escolar/tp-01/images/testimonial-2.jpg')}}" class="rounded-circle p-2" style="width: 80px; height: 80px; border-style: dotted; border-color: var(--bs-primary);" alt="">
                            </div>
                            <div class="ms-4">
                                <h4 class="text-dark">Client Name</h4>
                                <p class="m-0 pb-3">Profession</p>
                                <div class="d-flex pe-5">
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                </div>
                            </div>
                        </div>
                        <div class="border-top border-primary mt-4 pt-3">
                            <p class="mb-0">Lorem Ipsum is simply dummy text of the printing Ipsum has been the industry's standard dummy text ever since the 1500s,
                            </p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item img-border-radius bg-light border border-primary p-4">
                    <div class="p-4 position-relative">
                        <i class="fa fa-quote-right fa-2x text-primary position-absolute" style="top: 15px; right: 15px;"></i>
                        <div class="d-flex align-items-center">
                            <div class="border border-primary bg-white rounded-circle">
                                <img src="{{asset('build/client/themes/escolar/tp-01/images/testimonial-2.jpg')}}" class="rounded-circle p-2" style="width: 80px; height: 80px; border-style: dotted; border-color: var(--bs-primary);" alt="">
                            </div>
                            <div class="ms-4">
                                <h4 class="text-dark">Client Name</h4>
                                <p class="m-0 pb-3">Profession</p>
                                <div class="d-flex pe-5">
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                </div>
                            </div>
                        </div>
                        <div class="border-top border-primary mt-4 pt-3">
                            <p class="mb-0">Lorem Ipsum is simply dummy text of the printing Ipsum has been the industry's standard dummy text ever since the 1500s,
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

    @if (isset($sessaoFaq) && $sessaoFaq <> null || isset($faqs) && $faqs->count())
        <section id="faq" class="faq-section pt-5 bg-grey-light pb-4 pb-lg-0">
            <div class="container">
                <div class="row align-items-start g-5">
                    @if (isset($sessaoFaq) && $sessaoFaq <> null)
                        <!-- COLUNA ESQUERDA -->
                        <div class="col-lg-5" data-aos="fade-right" data-aos-delay="100">
                            <!-- Header -->
                            <div class="mb-4">
                                <h3 class="faq-title font-changa font-40 font-bold color-grey mb-3 text-start">
                                    {{$sessaoFaq->title}} <span class="primary-color">{{$sessaoFaq->subtitle}}</span>
                                </h3>
                            </div>

                            @if ($sessaoFaq->btn_title <> null && $sessaoFaq->btn_number <> null)                
                                <div class="d-flex justify-content-lg-start align-items-center">
                                    <a href="{{$sessaoFaq->btn_number}}" class="bg-button-two color-button-two btn-product py-1 py-lg-2 px-4 font-15 hover-zoom">
                                        {{$sessaoFaq->btn_title}}
                                        <svg class="ms-2" width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.78794 12.474L8.02494 6.237L1.78794 -1.90735e-06L0.02079 1.76715L4.46985 6.237L0 10.7068L1.78794 12.474Z" fill="var(--color-button-one)"/>
                                        </svg>
                                    </a>
                                </div>
                            @endif

                            <div class="faq-image mt-4">
                                <img loading="lazy" src="{{asset('storage/' . $sessaoFaq->path_file)}}" alt="Entrega" class="img-fluid">
                            </div>
                        </div>
                    @endif

                    @if (isset($faqs) && $faqs->count())
                        <!-- COLUNA DIREITA -->
                        <div class="col-lg-7 mt-0 mt-lg-5" data-aos="fade-left" data-aos-delay="100">
                            <div class="accordion" id="faqAccordion">

                                <!-- ITEM ATIVO -->
                                @foreach ($faqs as $faq)     
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                        <button class="accordion-button collapsed font-changa font-16 font-regular"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#faq-{{$faq->id}}">
                                            {{$faq->question}}
                                        </button>
                                        </h2>
                                        <div id="faq-{{$faq->id}}" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion">
                                            <div class="accordion-body font-changa font-16 font-regular">
                                                {!! $faq->answer !!}
                                            </div>
                                        </div>
                                    </div>    
                                @endforeach

                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </section>
    @endif

        @if (isset($contact) && $contact <> null)
        <section class="contact-section bg-light" data-aos="fade" data-aos-delay="100">
            <!-- Título -->
            <div class="container text-center py-3">
                <span class="rounded-2 px-4 m-auto m-lg-0 py-2 text-dark text-center font-changa font-16 font-bold badge bg-white shadow-sm">
                    Contato
                </span>

                <h2 class="font-changa font-40 font-bold my-3 text-black text-center">
                    {{$contact->name_section}} <span class="primary-color">{{$contact->text}}</span>
                </h2>
            </div>
            <div id="contato"></div>
            <!-- Informações de contato -->
            <div class="container-fluid px-0">
                <div class="bg-secondary-color border-bottom border-3 border-warning">
                    <div class="container">
                        <div class="row align-items-center justify-content-center">

                            <!-- Telefone -->
                            @if ($contact->phone_one)                            
                                <div class="col-md-4 py-3 px-4">
                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        <i class="bi bi-telephone fs-3 text-white"></i>

                                        <span class="text-white fw-semibold small font-changa">
                                            {{$contact->phone_one}}
                                        </span>
                                    </div>
                                </div>
                            @endif

                            <!-- Endereço -->
                            @if ($contact->address_one)                            
                                <div class="col-md-4 py-3 px-4 border-start border-end border-light border-opacity-50">
                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        <i class="bi bi-geo-alt fs-3 text-white"></i>

                                        <span class="text-white fw-semibold small font-changa">
                                            {{$contact->address_one}}
                                        </span>
                                    </div>
                                </div>
                            @endif

                            <!-- E-mail -->
                            @if ($contact->name_one)                            
                                <div class="col-md-4 py-3 px-4">
                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        <i class="bi bi-envelope fs-3 text-white"></i>

                                        <span class="text-white fw-semibold small font-changa">
                                            {{$contact->name_one}}
                                        </span>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection