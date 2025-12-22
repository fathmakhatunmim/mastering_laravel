<?php

namespace App\Http\Controllers;
use App\Models\food;
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

    $foods = Food::all();  // সব foods নিয়ে আসছি
    return view('font.style', compact('foods'));
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
}
