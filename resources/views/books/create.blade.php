
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row my-3">
        <h3>Add New Book</h3>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{route('books.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-center">
            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" value="{{old('name')}}" name="name" placeholder="Enter Book Name" id="example-text-input">
                </div>
            </div>
            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label" placeholder="Enter Book Description">Description</label>
                <div class="col-sm-10">
                    <textarea name="description" id="" cols="5" class="form-control"  rows="3">{{old('description')}}</textarea>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Upload Book Image</h4>
                            <p class="card-title-desc">The file input Jpeg,Png,Jpg</p>
                            <div class="input-group">
                                <input type="file" class="form-control" value="{{old('image')}}" name="image" id="customFile">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Upload Book Pdf/Docs</h4>
                            <p class="card-title-desc">The file input Pdf Or Docs</p>
                            <div class="input-group">
                                <input type="file" class="form-control" value="{{old('book')}}" name="book" id="customFile">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row my-3  w-50 m-auto ">
                <button type="submit" class="btn btn-primary  mx-3" style="width: 40%">Save</button>
                <button type="reset" class="btn btn-secondary mx-3" style="width: 40%">Cancel</button>
            </div>
        </div>
    </form>
</div>
@endsection
