@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body">
                    <form action="{{ route('admin.topup.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>@lang('Game Top Up Title')</label>
                            <input type="text" class="form-control bmd-input" name="name" required>
                        </div>

                        <div class="card-body">
                            <div class="row mb-2 border p-4 rounded-3">
                                <div class="col-lg-6">
                                    <div class="image-upload">
                                        <label for="" class="required">@lang('Top Up Image')</label>
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview"
                                                    style="background-image: url({{ getImage(getFilePath('topup') . '/' . @$topup->image, getFileSize('topup')) }})">
                                                    <button type=" button" class="remove-image">
                                                        <i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" name="image"
                                                    id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                <label for="profilePicUpload1" class="bg--primary">@lang('Upload Image')</label>
                                                <small class="mt-2">@lang('Recomended size:')
                                                    {{ getFileSize('topup') }}@lang('px'). </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="image-upload">
                                        <label for="">@lang('Instruction Image')</label>
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview thumbnail"
                                                    style="background-image: url({{ getImage(getFilePath('topup_instruct') . '/' . @$topUp->instruction_image, getFileSize('topup_instruct')) }})">
                                                    <button type=" button" class="remove-image">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" name="instruction_image"
                                                    id="profilePicUpload2" accept=".png, .jpg, .jpeg">
                                                <label for="profilePicUpload2" class="bg--primary">@lang('Upload Image')</label>
                                                <small class="mt-2">@lang('Recomended size:')
                                                    {{ getFileSize('topup_instruct') }}@lang('px'). </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row my-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Apple Store Link')</label>
                                    <input class="form-control bmd-input" name="apple_store_link" type="text"
                                        step="any">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Play Store Link')</label>
                                    <input class="form-control bmd-input" name="play_store_link" type="text"
                                        step="any">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>@lang('Description')</label>
                            <textarea class="trumEdit" name="description" cols="30" rows="10"></textarea>
                        </div>

                        <div class="row gy-3 mb-3">
                            <div class="col-lg-12 com-md-12">
                                <div class="price-input-section">
                                    <div class="row mb-2">
                                        <div class="col-lg-10 col-md-10">
                                            <p>@lang('Add Fields')</p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 text-end">
                                            <button type="button" class="btn btn--primary addMoreItemField ms-0 mt-2">
                                                <i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <div class="row gy-3">
                                        <div class="col-lg-12">
                                            <div class="addMoreFieldContainer">
                                                <div class="row my-3 delete_field_wrapper">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>@lang('Service Quantity')</label>
                                                            <input class="form-control bmd-input" name="quantities[]"
                                                                placeholder="120 Diamonds" type="text" step="any"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>@lang('Price')</label>
                                                            <input class="form-control bmd-input" name="prices[]"
                                                                type="number" step="any" required>
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
                            <label>@lang('Instruction')</label>
                            <textarea class="trumEdit" placeholder="Max 300 Character" name="instruction" cols="30" rows="10"></textarea>
                        </div>
                        <div class="row my-3">
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
    <a type="button" class="btn btn-sm btn--primary" href="{{ route('admin.topup.index') }}">@lang('Back')</a>
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

            $('.addMoreItemField').on('click', function() {
                var newItemHTML =
                    `<div class="row my-3 delete_field_wrapper">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('Service Quantity')</label>
                                <input class="form-control bmd-input" name="quantities[]" type="text" step="any" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>@lang('Price')</label>
                                <input class="form-control bmd-input" name="prices[]" type="number" step="any" required>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button type=" button" class="remove_field"><i class="fa fa-times"></i></button>
                        </div>
                    </div>`;

                $('.addMoreFieldContainer').append(newItemHTML);
            });

            $(document).on('click', ".remove_field", function() {
                $(this).closest('.delete_field_wrapper').remove();
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
