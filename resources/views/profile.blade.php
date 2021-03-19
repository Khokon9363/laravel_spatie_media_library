@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Profile') }}</div>

                <div class="card-body">
                    @if(session('error'))
                    <h3 class="text-center text-danger">{{ session('error') }}</h3>
                    @endif
                    <form action="{{ route('avatar.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="avatar" class="custom-file-input" id="avatar">
                                <label class="custom-file-label" for="avatar">Choose Image</label>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-outline-success" type="submit">Upload</button>
                            </div>
                        </div>
                    </form>
                    <!-- 0 for nothing to pass haha -->
                    <form action="{{ route('avatar.destroy', 0) }}" method="POST" class="mt-1">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger" type="submit">Delete all</button>
                    </form>
                    <div class="row">
                        @foreach($avatars as $avatar)
                        <div class="card-group card mt-3 p-2" style="width: 18.9rem;">
                            <div class="card">
                                <!-- It's for just uploaded image -->
                                <!-- {{ $avatar }} -->

                                <!-- It's for conversed image -->
                                <img src="{{ $avatar->getUrl('card') }}">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                </div>
                                <div class="card-footer">
                                    <div class="float-left">
                                        <form action="{{ route('avatar.update', $avatar->id) }}" method="post" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </form>
                                        <a href="" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="" class="btn btn-sm btn-danger">
                                            <i class="fa fa-minus-circle"></i>
                                        </a>
                                        <a href="" class="btn btn-sm btn-success">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </div>
                                    <div class="float-right">
                                        <small class="text-muted">Uploaded at {{ $avatar->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection