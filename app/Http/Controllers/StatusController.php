<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        Gate::authorize('admin', $request->user());

        return response(Status::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request): Response
    {

        Gate::authorize('admin', $request->user());

        validator(request()->all(), [
            'title' => "required",
        ])->validate();

        $status = Status::create([
            "title" => request("title"),
        ]);

        return response($status, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Status $status
     * @param Request $request
     * @return Response
     */
    public function show(Status $status, Request $request): Response
    {
        Gate::authorize('admin', $request->user());

        return response($status);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Status $status
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function update(Status $status, Request $request): Response
    {
        Gate::authorize('admin', $request->user());

        validator(request()->all(), [
            'title' => "required",
        ])->validate();

        $status->update([
            "title" => request("title"),
        ]);
        return response($status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Status $status
     * @param Request $request
     * @return Response
     */
    public function destroy(Status $status, Request $request): Response
    {
        Gate::authorize('admin', $request->user());

        $status->delete();
        return response('', 204);
    }
}
