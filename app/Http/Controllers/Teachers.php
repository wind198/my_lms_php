<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Teachers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve filter parameters from the request
        $filters = $request->input('filters', []); // Filters array

        // Define pagination parameters
        $perPage = $request->input('per_page', 10); // Default to 10 items per page
        $page = $request->input('page', 1); // Current page number

        // Define ordering parameters
        $orderBy = $request->input('order_by', 'created_at'); // Default to ordering by 'created_at'
        $order = $request->input('order', 'desc'); // Default order is descending ('desc')

        // Query the users table for teachers
        $query = User::where('user_type', 'teacher');

        // Apply query string filter
        if (!empty($filters['q'])) {
            $q = $filters['q'];
            $query->where(function ($query) use ($q) {
                $query->where('email', 'like', "%{$q}%")
                    ->orWhere('first_name', 'like', "%{$q}%")
                    ->orWhere('last_name', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%");
            });
        }


        // Apply filters for created_at
        if (!empty($filters['created_at']['gte'])) {
            $query->where('created_at', '>=', $filters['created_at']['gte']);
        }

        if (!empty($filters['created_at']['lte'])) {
            $query->where('created_at', '<=', $filters['created_at']['lte']);
        }

        // Apply ordering
        $query->orderBy($orderBy, $order);

        // Print the query with bindings only in the development environment
        if (App::environment('local')) {
            $sqlQuery = vsprintf(str_replace('?', '"%s"', $query->toSql()), $query->getBindings());
            Log::info($sqlQuery); // Log the query for debugging
        }

        // Paginate the results
        $teachers = $query->paginate($perPage, ['*'], 'page', $page);

        // Return the response
        return Inertia::render('Settings/Teachers', [
            'data' => $teachers->items(),
            'params' => [
                'total' => $teachers->total(),
                'per_page' => $teachers->perPage(),
                'current_page' => $teachers->currentPage(),
                'last_page' => $teachers->lastPage(),
                'next_page_url' => $teachers->nextPageUrl(),
                'prev_page_url' => $teachers->previousPageUrl(),
                'order' => $order,
                'order_by' => $orderBy,
                'filters' => $filters,
            ],
        ]);
    }    /**
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $User)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $User)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $User)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $User)
    {
        //
    }
}
