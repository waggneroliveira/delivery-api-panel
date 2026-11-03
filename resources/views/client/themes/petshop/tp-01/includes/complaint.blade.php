@if (!empty($report))
    <section id="complaint" class="complaint my-5">
        <div class="background-red flex-wrap col-12 text-white py-4 px-3 px-lg-5 d-flex justify-content-center align-items-center shadow-sm" style="min-height: 177px;">
            <div class="text-center col-12 col-lg-9">
                <h4 class="poppins-medium font-32">{{$report->title}}</h4> 
            </div>
            @if ($report->description <> null)                        
                <a href="{{$report->description}}" 
                    target="_blank"
                    class="bg-light poppins-bold font-15 d-flex align-items-center rounded-2 py-1 px-4 px-md-5 text-center d-inline-block text-transparent">
                    Quero Anunciar!
                </a>
            @endif
        </div>
    </section>
@endif