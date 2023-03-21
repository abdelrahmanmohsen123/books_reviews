@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row my-3">
        <div class="col-9">
            <h3>All Books</h3>
        </div>
       <div class="col-3">
        <a href="{{route('books.create')}}" class="btn btn-success">Add New Book</a>
       </div>
    </div>
    <div class="row my-3">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @foreach ($books as $book)
            <div class="col-md-3 my-2">
                <div class="card">
                    <img class="card-img-top img-fluid" src="{{asset('storage/'. $book->image)}}" alt="Card image cap" style="height: 20vh;width:20vw">
                    <div class="card-body">
                        <h4 class="card-title">{{$book->name}}</h4>
                        <p class="card-text">{{$book->description}}</p>
                        <div class="text-muted mb-3">{{date('d-m-Y', strtotime($book->created_at))}}</div>
                        <a href="{{route('books.show',$book->id)}}" class="btn btn-primary waves-effect waves-light">Details</a>
                    </div>
                </div>
            </div>
        @endforeach


    </div>
     {{-- paginate --}}
     <div class="container my-5 w-50 m-auto text-center">
        <div class="row" style="float: right">
          {{ $books->links() }}
        </div>
    </div>
</div>
@endsection
