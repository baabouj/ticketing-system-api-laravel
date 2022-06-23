<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Ticket $ticket
     * @return Response
     */
    public function index(Ticket $ticket): Response
    {
        $comments = Comment::whereBelongsTo($ticket)->get();
        return response($comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Ticket $ticket
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Ticket $ticket, Request $request): Response
    {
        validator(request()->all(), [
            'content' => "required",
        ])->validate();

        $comment = Comment::create([
            "content" => request("content"),
            "user_id" => $request->user()->id,
            "ticket_id" => $ticket->id,
        ]);

        return response($comment, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Ticket $ticket
     * @param Comment $comment
     * @return Response
     */
    public function show(Ticket $ticket, Comment $comment): Response
    {
        return response($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Ticket $ticket
     * @param Comment $comment
     * @return Response
     * @throws ValidationException
     */
    public function update(Ticket $ticket, Comment $comment): Response
    {
        Gate::authorize('author', $comment);

        validator(request()->all(), [
            'content' => "required",
        ])->validate();

        $comment->update([
            "content" => request("content"),
        ]);
        return response($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Ticket $ticket
     * @param Comment $comment
     * @return Response
     */
    public function destroy(Ticket $ticket, Comment $comment): Response
    {
        Gate::authorize('author', $comment);

        $comment->delete();
        return response('', 204);
    }
}
