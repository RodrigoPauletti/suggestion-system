<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use DB;

use App\Http\Requests\SuggestionRequest;
use App\Models\Suggestion;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SuggestionController extends Controller
{
    const RECORDS_PER_PAGE = 25;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the requested page (if doesn't exists, set to the first page)
        $page = $request->input('page') ?? 1;

        // Return suggestions and their votes
        return Suggestion::select([
                'id',
                'title',
                'description',
                'created_at',
            ])
            ->orderByDesc('created_at') // order the suggestions based on this creation date (newest first)
            ->take(Self::RECORDS_PER_PAGE)
            ->skip(($page - 1) * Self::RECORDS_PER_PAGE) // skip results (based on the actual page)
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SuggestionRequest $request)
    {
        // Start the database transaction
        DB::beginTransaction();
        try {
            // Create the suggestion, based on the request fields
            Suggestion::create([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            // Commit the database's changes
            DB::commit();

            // Returns that the suggestion was created
            return response()->json([
                'message' => __('Suggestion successfully created!')
            ], 201);
        } catch (Exception $exception) {
            // Rollback the database's changes
            DB::rollBack();

            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Get the requested suggestion (based on the logged user)
            $suggestion = Suggestion::whereId($id)
                ->whereAuthorId(auth()->user()->id)
                ->firstOrFail();

            return response()->json([
                'id' => $suggestion->id,
                'title' => $suggestion->title,
                'description' => $suggestion->description,
            ]);
        } catch (Exception $exception) {
            return $this->returnResponseException($exception);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SuggestionRequest $request, string $id)
    {
        // Start the database transaction
        DB::beginTransaction();
        try {
            // Get the requested suggestion (based on the logged user)
            $suggestion = Suggestion::whereId($id)
                ->whereAuthorId(auth()->user()->id)
                ->firstOrFail();

            // Update the suggestion, based on the request fields
            $suggestion->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            // Commit the database's changes
            DB::commit();

            // Returns that the suggestion was updated
            return response()->json([
                'message' => __('Suggestion successfully updated!')
            ], 200);
        } catch (Exception $exception) {
            // Rollback the database's changes
            DB::rollBack();

            return $this->returnResponseException($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Get the requested suggestion (based on the logged user)
            $suggestion = Suggestion::whereId($id)
                ->whereAuthorId(auth()->user()->id)
                ->firstOrFail();

            // Delete the requested suggestion
            $suggestion->delete();

            // Returns empty response with status code 204 (no content)
            return response()->noContent();
        } catch (Exception $exception) {
            // Rollback the database's changes
            DB::rollBack();

            return $this->returnResponseException($exception);
        }
    }

    /**
     * Return the response with the specified exception.
     */
    private function returnResponseException(Exception $exception) {
        if($exception instanceof ModelNotFoundException){
            // Returns that suggestion wasn't found (with status code 404)
            return response()->json([
                'message' => __('Suggestion not found!')
            ], 404);
        }

        // Returns the generic exception message (with status code 500)
        return response()->json([
            'message' => $exception->getMessage()
        ], 500);
    }

}
