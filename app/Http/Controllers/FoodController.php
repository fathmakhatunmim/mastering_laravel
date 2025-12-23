<?php

namespace App\Http\Controllers;
use App\Models\food;
use App\Models\review;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    if($request->ajax()){
        $data = Food::select('*');
        return DataTables::of($data)
            ->addColumn('img', function($row){
    if ($row->img) {
        return '<img src="'.asset('uploads/'.$row->img).'" width="50">';
    }
    return 'No Image';
})
          ->addColumn('action', function($row){
    return '<div class="d-flex gap-2">
                <a href="javascript:void(0)" class="btn btn-info btn-sm editButton" data-id="'.$row->id.'">Edit</a>
                <a href="javascript:void(0)" class="btn btn-danger btn-sm deleteButton" data-id="'.$row->id.'">Delete</a>
            </div>';
})

            ->rawColumns(['img', 'action'])
            ->make(true);
    }
    // return view('category');

$foods = Food::all();
$orders = Order::all();
$reviews = review::all();
return view('font.style', compact('foods','reviews','orders'));
}

public function reviewIndex(Request $request){

  if($request->ajax()){
         $data= review::select('*');
         return DataTables::of($data)
         ->addColumn('img',function($row){
          if($row->img){
            return '<img src="'.asset('uploads/'.$row->img).'"width="50">';
          }

         })
         ->addColumn('action',function($row){
           return '<div class="d-flex gap-2">
                 <a  href="javascript:void(0)" class="btn btn-info btn-sm editButton" data-id="'.$row->id.'" >Edit</a>
                  <a  href="javascript:void(0)" class="btn btn-danger btn-sm deleteButton" data-id="'.$row->id.'" >Delete</a>          
               </div>';

         })
         ->rawColumns(['img','action'])
         ->make(true);


        }
       $reviews = review::all();
       return view('font.style', compact('reviews'));



}







































    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
  public function reviewStore(Request $request)
    {
          
    if($request->review_id){
    $review = review::find($request->review_id);
    if(!$review){
        abort(404);
    }

    // Image handling
    $imagename = $review->img; // default old image
    if($request->hasFile('img')){
        $file = $request->file('img');
        $imagename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $imagename);
    }

    $review->update([
        'comment' => $request->comment,
        'name' => $request->name,
        'city' => $request->city,
        'img' => $imagename,  // এখানে $imagename ঠিকভাবে থাকবে
    ]);
 
        return redirect()->back()->with('success', 'review updated successfully!');

        }
        else{

           $request->validate([
            'comment'=> 'required',
            'name'=>'required',
            'city'=>'required',
            'img'=>'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);


     $imagename = null;

if ($request->hasFile('img')) {
    $file = $request->file('img');
    $imagename = time() . '.' . $file->getClientOriginalExtension();
    $file->move(public_path('uploads'), $imagename);
}


          review::create([
            'comment'=>$request->comment,
            'name'=>$request->name,
            'city'=>$request->city,
            'img'=>$imagename
          ]); 

        }

        return redirect()->back()->with('suceess','food added succefully');



    }
 
public function store(Request $request)
{

       // UPDATE
    if ($request->food_id) {

        $food = food::find($request->food_id);
        if (!$food) {
            abort(404);
        }

        $food->update([
            'img' => $filename ?? $food->img,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return redirect()->back()->with('success', 'Food updated successfully!');
    }

  else{


    // Common validation
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Image upload (for both create & update)
    $filename = null;
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $filename);
    }


    // CREATE
    food::create([
        'img' => $filename,
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
    ]);

    return redirect()->back()->with('success', 'Food added successfully!');

  }

}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit($id)
{
    $foods = food::find($id);

    if(!$foods){
        abort(404);
    }

    return response()->json($foods); // JSON response
}

public function reviewEdit($id)
{
    $review = review::find($id);
    if(!$review){
        return response()->json(['error'=>'Review not found'], 404);
    }
    return response()->json($review);
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
  public function destroy($id)
{
    $food = Food::find($id);
    if(!$food){
        return response()->json(['error' => 'Food not found!'], 404);
    }

    $food->delete();


     

    return response()->json(['success' => 'Food deleted successfully!']);
}

  public function reviewDestroy($id)
{
    $review = review::find($id);
    if(!$review){
        return response()->json(['error' => 'review not found!'], 404);
    }

    $review->delete();


    return response()->json(['success' => 'review deleted successfully!']);
}

// information 

public function OrderStore(Request $request)
{

    $request->validate([
    'name' => [
    'required',
    'string',
    'min:2',
    'max:100',
    'regex:/^[a-zA-Z\s]+$/'
]
,
    'pNumber' => 'required|string|max:15',

 'email' => [
    'required', 
     'email', 
      'regex:/^[\w\.\-]+@gmail\.com$/'],

    'person'  => 'required|integer|min:1',
    'date'    => 'required|date',

    ]);

    order::create([
      'name'=>$request->name,
      'pNumber'=>$request->pNumber,
      'email'=>$request->email,
      'person'=>$request->person,
      'date'=>$request->date

    ]);

 return redirect()->back()->with('success', 'record added successfully!');
}



public function OrderIndex(Request $request){

  if($request->ajax()){
         $data= Order::select('*');
         return DataTables::of($data)
         ->make(true);
        }
       $orders = order::all();
       return view('font.style', compact('orders'));



}











}
