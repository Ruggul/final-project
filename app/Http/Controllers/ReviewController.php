<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    //Display a listing of the resource.
    public function index()
    {
        $reviews = Review::with(['product', 'order'])->paginate(10);
        return view('reviews.index', compact('reviews'));
    }

    //Show the form for creating a new resource.
    public function create()
    {
        return view('reviews.create');
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string',
            'purchase_date' => 'required|date'
        ]);

        Review::create($validated);

        return redirect()
            ->route('reviews.index')
            ->with('success', 'Review created successfully');
    }

    //Display the specified resource.
    public function show(string $id)
    {
        $review = Review::findOrFail($id);
        return view('reviews.show', compact('review'));
    }

    //Show the form for editing the specified resource.
    public function edit(string $id)
    {
        $review = Review::findOrFail($id);
        return view('reviews.edit', compact('review'));
    }

    //Update the specified resource in storage.
    public function update(Request $request, string $id)
    {
        $review = Review::findOrFail($id);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string',
            'purchase_date' => 'required|date'
        ]);

        $review->update($validated);

        return redirect()
            ->route('reviews.index')
            ->with('success', 'Review updated successfully');
    }

    //Remove the specified resource from storage.
    public function destroy(string $id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()
            ->route('reviews.index')
            ->with('success', 'Review deleted successfully');
    }
}