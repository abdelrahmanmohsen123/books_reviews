<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\StoreRateRequest;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $books = Book::where('user_id',auth()->id())->paginate(4);
        return view('home',compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('books.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        //
        // dd($request->all());
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['book'] = $this->uploadBook($request->file('book'),'books');
        $data['image'] = $this->uploadBook($request->file('image'),'images');
        $new_book = Book::create($data);
        if($new_book){
            return to_route('home')->with('success','Your Book added Successfully');;
        }else{
            abort(404);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
        $stars=  DB::table('book_reviews')
                ->select(DB::raw('avg(book_reviews.star_rating) as rating_average'))
                ->join('users','users.id','=','book_reviews.user_id')
                ->join('books','books.id','=','book_reviews.book_id')
                ->where('book_reviews.book_id',$book->id)
                ->get();
        $reviewers =   DB::table('book_reviews')
                ->select(DB::raw('count(book_reviews.user_id) as user_count'))
                ->join('users','users.id','=','book_reviews.user_id')
                ->join('books','books.id','=','book_reviews.book_id')
                ->where('book_reviews.book_id',$book->id)
                ->get();
        // dd($reviewers[0]->user_count);
        $user_reviewers =  $reviewers[0]->user_count;
        // dd($stars[0]->rating_average);
        $avg_rate_book = $stars[0]->rating_average;
        // dd($avg_rate_book);
        $avg_rate_book = round($avg_rate_book);
        $user_rate_book=  DB::table('book_reviews')
                            ->select('book_reviews.star_rating')
                            ->join('users','users.id','=','book_reviews.user_id')
                            ->join('books','books.id','=','book_reviews.book_id')
                            ->where('book_reviews.book_id',$book->id)
                            ->where('book_reviews.user_id',auth()->id())
                            ->orderBy('book_reviews.id','desc')
                            ->first();
        if($user_rate_book){
            $user_rate = $user_rate_book->star_rating;
        }else{
            $user_rate=0;
        }
        return view('books.show',compact('book','avg_rate_book','user_rate','user_reviewers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
    public function store_rate_book(StoreRateRequest $request,$id ){
        // dd($request->all());
        $find_rate = BookReview::where('book_id',$id)->where('user_id',auth()->id())->first();
        if($find_rate ==null){
            $new_rate = new BookReview();
            $new_rate->user_id = auth()->id();
            $new_rate->book_id = $id;
            $new_rate->star_rating = $request->star_rating;
            $new_rate->save();
            return redirect()->back()->with('success','Your Rated Book added ');
        }else{
            $find_rate->star_rating =$request->star_rating;
            $find_rate->save();
            return redirect()->back()->with('success','Your Rated Book Updated ');
        }
    }

    public function uploadBook($book,$folder){
        $bookName = $folder .'/'. time().'.'.$book->extension();

        $book->move(storage_path('app/public/'.$folder), $bookName);
        return $bookName;
    }
}