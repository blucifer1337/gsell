@php
    $content = getContent('blog.content', true);
    $blogs = getContent('blog.element', false, 3);
@endphp

<section class="news-section bg-white py-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-content-5">
                    <h6 class="title">@php echo $content->data_values->heading; @endphp</h6>
                </div>
            </div>
        </div>
        <div class="row gy-4">
            @foreach ($blogs as $item)
                <div class="col-lg-4">
                    <a
                        href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}">
                        <div class="blog-card1">
                            <div class="thumb">
                                <img src="{{ getImage(getFilePath('frontend') . '/blog/thumb_' . $item->data_values->image) }}"
                                    alt="...">
                            </div>
                            <div class="blog-content">
                                <h5 class="title">
                                    {{ __($item->data_values->title) }}
                                </h5>
                                <p class="date-time">{{ $item->data_values->date }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
