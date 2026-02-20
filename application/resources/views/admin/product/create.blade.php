@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body">
                    <form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>@lang('Product Title')</label>
                            <input type="text" class="form-control bmd-input" name="title" required>
                        </div>
                        <div class="form-group">
                            <label class="required">@lang('Select Category')</label>
                            <select name="category_id" class="form-control " required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('Select Device')</label>
                            <select name="device_id" class="form-control" required>
                                <option value="">@lang('Selcet')</option>

                                @foreach ($devices as $device)
                                    <option value="{{ $device->id }}">{{ $device->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('Select Platform')</label>
                            <select name="platform_id" class="form-control" required>
                                <option value="">@lang('Selcet')</option>
                                @foreach ($platforms as $platform)
                                    <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('Select Genre')</label>
                            <select name="genre_id" class="form-control">
                                <option value="">@lang('Selcet')</option>
                                @foreach ($genres as $genre)
                                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2 border p-4 rounded-3">
                                <div class="col-lg-6">
                                    <div class="image-upload">
                                        <label for="" class="required">@lang('Product Image')</label>
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview"
                                                    style="background-image: url({{ getImage(getFilePath('product') . '/' . @$product->image, getFileSize('product')) }})">
                                                    <button type=" button" class="remove-image"><i
                                                            class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" name="image"
                                                    id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                <label for="profilePicUpload1"
                                                    class="bg--primary">@lang('Upload Image')</label>
                                                <small class="mt-2">@lang('Recomended size:')
                                                    {{ getFileSize('product') }}@lang('px'). </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="image-upload">
                                        <label for="">@lang('Poster')</label>
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview thumbnail"
                                                    style="background-image: url({{ getImage(getFilePath('product') . '/' . @$product->poster, getFileSize('product_poster')) }})">
                                                    <button type=" button" class="remove-image">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" name="poster"
                                                    id="profilePicUpload2" accept=".png, .jpg, .jpeg">
                                                <label for="profilePicUpload2"
                                                    class="bg--primary">@lang('Upload Image')</label>
                                                <small class="mt-2">@lang('Recomended size:')
                                                    {{ getFileSize('product_poster') }}@lang('px'). </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row gy-3 mb-3">
                            <div class="col-lg-12 com-md-12">
                                <div class="price-input-section">
                                    <div class="row mb-3">
                                        <div class="col-lg-10 col-md-10">
                                            <p>@lang('Upload Product Images')</p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 text-end">
                                            <button type="button" class="btn btn--base addmoreImageNew ms-0 mt-2">
                                                <i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <div class="row mb-3 gy-3">
                                        <div class="col-lg-12">
                                            <div class="addmoreImageContainer">
                                                <div class="row">
                                                    <div class="col-md-3 col-lg-3 col-sm-6 image-upload-wrapper-delete">
                                                        <div class="form-group">
                                                            <div class="image-upload">
                                                                <div class="thumb newthumb">
                                                                    <div class="avatar-preview">
                                                                        <div class="profilePicPreview newprofilePicPreview"
                                                                            style="background-image: url({{ getImage(getFilePath('product'), getFileSize('product')) }})">
                                                                            <button type="button" class="remove-image">
                                                                                <i class="fa fa-times"></i></button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="avatar-edit">
                                                                        <input type="file" class="profilePicUpload"
                                                                            name="images[]" id="100"
                                                                            accept=".png, .jpg, .jpeg">
                                                                        <label for="100"
                                                                            class="bg--primary">@lang('Upload Images')</label>
                                                                        <small class="my-2">@lang('Recomended size'):
                                                                            {{ getFileSize('product') }}. </small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>@lang('Description')</label>
                            <textarea class="trumEdit" name="description" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <label>@lang('Short Description')</label>
                            <textarea class="trumEdit" placeholder="Max 130 Character" name="short_description" cols="30" rows="10"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label>@lang('Minimum System Requirements')</label>
                                <textarea class="trumEdit" name="minimum" cols="30" rows="10"></textarea>
                            </div>
                            <div class="col-lg-6">
                                <label>@lang('Recommended System Requirements')</label>
                                <textarea class="trumEdit" name="recommended" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>@lang('Price')</label>
                                    <input class="form-control bmd-input" name="price" type="number" step="any"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>@lang('Discount') %</label>
                                    <input class="form-control bmd-input" name="discount" type="number" step="any">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>@lang('Version') </label>
                                    <input class="form-control bmd-input" name="version" type="number" step="any">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required">@lang('Trending')</label>
                                    <select name="is_trending" class="form-control" required>
                                        <option value="0">@lang('No')</option>
                                        <option value="1">@lang('Yes')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required">@lang('Status')</label>
                                    <select name="status" class="form-control" required>
                                        <option value="1">@lang('Active')</option>
                                        <option value="0">@lang('Inactive')</option>
                                        <option value="2">@lang('Pre Order')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-end">
                            <button class="btn-global btn--primary" type="submit">@lang('Save')</button>
                        </div>
                    </form>
                </div>
            </div><!-- card end -->
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <a type="button" class="btn btn-sm btn--primary" href="{{ route('admin.product.index') }}">@lang('Back')</a>
@endpush



@push('style')
    <style>
        .image-upload .thumb .profilePicPreview {
            width: 100%;
            height: 400px;
            display: block;
            border-radius: 10px;
            background-size: cover !important;
            background-position: top;
            background-repeat: no-repeat;
            position: relative;
            overflow: hidden;
        }

        .image-upload .thumb .profilePicUpload {
            font-size: 0;
            display: none;
        }

        .image-upload .thumb .avatar-edit label {
            text-align: center;
            line-height: 32px;
            font-size: 18px;
            cursor: pointer;
            padding: 2px 25px;
            width: 100%;
            border-radius: 5px;
            box-shadow: 0 5px 10px 0 rgb(0 0 0 / 16%);
            transition: all 0.3s;
            margin-top: 6px;
        }

        .image-upload .thumb .profilePicPreview.has-image .remove-image {
            display: block;
        }

        .image-upload .thumb .profilePicPreview .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            text-align: center;
            width: 34px;
            height: 34px;
            font-size: 23px;
            border-radius: 50%;
            background-color: hsl(var(--base));
            color: #dddd;
            display: none;
            opacity: 1;
        }
    </style>
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            "use strict";
            var imageCounter = 1;
            $('.addmoreImageNew').on('click', function() {
                var fileAdded = $('.image-upload-wrapper-delete').length;
                var inputId = 'image' + imageCounter;
                if (fileAdded >= 4) {
                    Toast.fire({
                        icon: 'error',
                        title: 'You\'ve added maximum number of images'
                    });
                    return false;
                }
                fileAdded++;
                var newImageHTML =
                    ` <div class="col-md-3 col-lg-3 col-sm-6 image-upload-wrapper-delete">
                        <div class="form-group">
                            <div class="image-upload">
                                <div class="thumb newthumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview newprofilePicPreview" style="background-image: url({{ getImage(getFilePath('product'), getFileSize('product')) }})">
                                            <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" class="profilePicUpload" name="images[]" id="${inputId}" accept=".png, .jpg, .jpeg">
                                        <label for="${inputId}" class="bg--primary">@lang('Upload Image')</label>
                                        <small class="my-2">@lang('Recomended size'): {{ getFileSize('product') }}. </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

                $('.addmoreImageContainer .row ').append(newImageHTML);

                imageCounter++;
            });

            $(document).on('click', ".remove-image", function() {
                $(this).closest('.image-upload-wrapper-delete').remove();
            });
        });

        (function($) {
            "use strict";

            function proPicURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var preview = $(input).parents('.thumb').find('.profilePicPreview');
                        $(preview).css('background-image', 'url(' + e.target.result + ')');
                        $(preview).addClass('has-image');
                        $(preview).hide();
                        $(preview).fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(document).on('change', ".profilePicUpload", function() {
                proPicURL(this);
            });


            $(document).on('click', ".remove-image", function() {
                $(this).parents(".newprofilePicPreview").css('background-image', 'none');
                $(this).parents(".newprofilePicPreview").removeClass('has-image');
                $(this).parents(".newthumb").find('input[type=file]').val('');
            });
        })(jQuery);
    </script>
@endpush
