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
                return '<img src="/uploads/'.$row->img.'" width="50">';
            })
            ->addColumn('action', function($row){
                return '<button class="btn btn-sm btn-danger">Delete</button>';
            })
            ->rawColumns(['img', 'action'])
            ->make(true);
    }
    return view('category');
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
          $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
        ]);

        // File Upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
        }

        // Save to DB
        food::create([
            'img' => $filename ?? null,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return redirect()->back()->with('success', 'Food added successfully!');
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
    public function edit(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
