@extends('Panel::layouts.master')

@section('title', 'Edit slider')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <x-panel-content-header title="Edit slider">
                <li class="breadcrumb-item active">
                    Edit slider
                </li>
            </x-panel-content-header>
            <div class="content-body">
                <section id="basic-input">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('sliders.update', $slider->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        <div class="row">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="id" value="{{ $slider->id }}">
                                            <div class="col-xl-6 col-md-6 col-12">
                                                <div class="mb-1">
                                                    <x-panel-label for="link" title="link" />
                                                    <x-panel-input name="link" id="link" value="{{ $slider->link }}"
                                                    placeholder="Enter link" />
                                                    <x-share-error name="link" />
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-6 col-12">
                                                <div class="mb-1">
                                                    <x-panel-label for="status" title="Statys" />
                                                    <x-panel-select name="status" id="status" selectedText="Select status slider">
                                                        @foreach (Modules\Category\Enums\CategoryStatusEnum::cases() as $status)
                                                            <option @if ($slider->status === $status->value) selected @endif
                                                                value="{{ $status->value }}">{{ $status->value }}
                                                            </option>
                                                        @endforeach
                                                    </x-panel-select>
                                                    <x-share-error name="status" />
                                                </div>
                                            </div>
                                            <div class="row mb-5">
                                                <div class="col-xl-12 col-md-6 col-12">
                                                    <x-panel-label for="image" title="Image" />
                                                    <x-panel-input name="image" id="image" type="file" />
                                                    @if ($errors->has('image'))
                                                        <span class="text-danger" role="alert">
                                                            <strong>{{ $errors->first('image') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <x-panel-button />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
