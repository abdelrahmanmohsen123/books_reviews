@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .checked {
        color: orange;
    }
</style>
@section('content')
    <div class="container">
        <div class="row my-3">
            <h3>View {{ $book->name }}</h3>
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
        <div class="row">
            <div class="col-xl-4">
                <div class="product-detail">
                    <div class="row">
                        <div class="col-md-8 col-9">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="product-1" role="tabpanel">
                                    <div class="product-img">
                                        <img src="{{ asset('storage/' . $book->image) }}" alt="img-1"
                                            class="img-fluid mx-auto d-block"
                                            data-zoom="{{ asset('storage/' . $book->image) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="my-4">
                                <div class="text-muted"> You Can Download the Book By click Here</div>
                                <a href="{{ asset('storage/' . $book->book) }}" class="btn btn-success dropdown-toggle"
                                    download="{{ $book->name }}">
                                    Download The Book
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end product img -->
            </div>
            <div class="col-xl-8">
                <div class="mt-4 mt-xl-3">
                    <h5 class="mt-1 mb-3">{{ $book->name }}</h5>
                    <div class="text-muted">Created By {{ $book->user->name }}</div>
                    <hr class="my-4">
                    <div class="row">
                        <div class="col-12">
                            <div>
                                <h5 class="font-size-14">Description :</h5>
                                <p >{{ $book->description }}</p>
                            </div>
                        </div>

                        <div class="col-12 my-3 " style="display:block">
                            <h5 class="font-size-14">Reviews :</h5>
                            <div class="d-inline-flex mb-3">
                                <div class="">
                                    <div class="rate1">
                                        @for ($i = 0; $i < 5; $i++)
                                            <span
                                                class="fa fa-star  @if ($avg_rate_book > $i) {{ 'checked' }} @endif "></span>
                                        @endfor
                                    </div>
                                </div>
                                <div class="text-muted"> ({{ $user_reviewers }} Reviewrs)</div>
                            </div>
                        </div>
                    </div>
                    @if ($book->user_id !=auth()->id())
                    <hr>
                    <div class="">
                        <div class="container">
                            <div class="row">
                                <h5>Add your Rate To Book</h5>
                            </div>
                            <div class="row">
                                {{-- @if ($user_rate == null) --}}
                                <div class="col mt-4">
                                    @if (session()->has('success'))
                                        <div class="alert alert-success">
                                            {{ session()->get('success') }}
                                        </div>
                                    @endif
                                    <form class="py-2 px-4" action="{{ route('books.rate.store', $book->id) }}"
                                        style="box-shadow: 0 0 10px 0 #ddd;" method="POST" autocomplete="off">
                                        @csrf
                                        <p class="font-weight-bold ">Review</p>
                                        <div class="form-group row">
                                            {{-- <input type="hidden" name="book_id" value="{{ $book->id }}"> --}}
                                            <div class="col">
                                                <div class="rate">
                                                    @for ($i = 5; $i >= 1; $i--)
                                                        @if ($user_rate == 0)
                                                            <input type="radio" id="star{{ $i }}" class="rate"
                                                                name="star_rating" value="{{ $i }}" />
                                                        @else
                                                            <input type="radio" id="star{{ $i }}" class="rate"
                                                                name="star_rating" value="{{ $i }}"
                                                                @if ($user_rate == $i) {{ 'checked' }} @endif />
                                                        @endif
                                                        <label for="star{{ $i }}" title="text">{{ $i }}
                                                            stars</label>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3 text-right">
                                            <button class="btn btn-sm py-2 px-3 btn-info" type="submit">Submit
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
@endsection
