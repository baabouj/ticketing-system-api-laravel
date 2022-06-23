<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        Gate::authorize("admin", $request->user());

        return response(User::all());
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return User
     */
    public function show(User $user): User
    {
        Gate::authorize("admin", $user);

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user): Response
    {
        Gate::authorize("admin", $user);

        $user->delete();

        return response([], 204);
    }

    /**
     * Display a listing.
     *
     * @param User $user
     * @return Response
     */
    public function tickets(User $user): Response
    {
        Gate::authorize("tickets", $user);

        $tickets = Ticket::whereBelongsTo($user)->get();
        return response($tickets);
    }
}
