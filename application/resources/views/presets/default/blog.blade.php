@extends($activeTemplate.'layouts.frontend')
@section('content')
<!-- ==================== Blog Start Here ==================== -->
<section class="blog-section pb-115">
    <div class="container">
        <div class="row gy-4 justify-content-center py-60">
            @foreach ($blogs as $item)
                <div class="col-lg-4">
                    <a href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}">
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
         <!-- pagination -->
         <div class="row  py-3 mt-4">
            <div class="col-lg-12 justify-content-end d-flex">
                <nav aria-label="Page navigation example">
                    @if ($blogs->hasPages())
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">
                                        <i class="fas fa-angle-double-left"></i>
                                    </span>
                                </a>
                            </li>
                            {{ paginateLinks($products) }}
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">
                                        <i class="fas fa-angle-double-right"></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    @endif
                </nav>
            </div>
        </div>
        <!-- / pagination -->
    </div>
</section>

@endsection
