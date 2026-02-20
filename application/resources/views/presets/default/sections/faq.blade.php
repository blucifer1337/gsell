@php
    $content = getContent('faq.content', true);
    $faqs = getContent('faq.element', false, 8);

@endphp

<section class="faq-section py-80 bg--img"
    style="background-image: url({{ getImage(getFilePath('frontend') . '/faq/' . $content->data_values->background_image) }});">
    <div class="container">
        <div class="row">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-content-4">
                        <h6 class="title"> {{ $content->data_values->heading }}</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4 justify-content-center">
            <div class="col-md-6">
                <div class="accordion custom--accordion accordion-flush" id="accordionFlushExample">
                    @foreach ($faqs as $faq)
                        @if ($loop->iteration % 2 != 0)
                            <div class="accordion-item wow animate__ animate__fadeInUp animated" data-wow-delay="0.2s">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapse{{ $loop->index }}" aria-expanded="false"
                                        aria-controls="flush-collapse{{ $loop->index }}">

                                        <span class="number">{{ 1 + $loop->index }}</span>
                                        {{ __($faq->data_values->question) }}
                                    </button>
                                </h2>
                                <div id="flush-collapse{{ $loop->index }}" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionFlushExample" style="">
                                    <div class="accordion-body">
                                        @php echo $faq->data_values->answer; @endphp
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                <div class="accordion custom--accordion accordion-flush" id="accordionFlushExample2">
                    @foreach ($faqs as $faq)
                        @if ($loop->iteration % 2 == 0)
                            <div class="accordion-item wow animate__ animate__fadeInUp animated" data-wow-delay="0.2s">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapse{{ $loop->index }}" aria-expanded="false"
                                        aria-controls="flush-collapse{{ $loop->index }}">

                                        <span class="number">{{ 1 + $loop->index }}</span>
                                        {{ __($faq->data_values->question) }}
                                    </button>
                                </h2>
                                <div id="flush-collapse{{ $loop->index }}" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionFlushExample2" style="">
                                    <div class="accordion-body">
                                        @php echo $faq->data_values->answer; @endphp
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
