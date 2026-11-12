<?php

declare(strict_types=1);

namespace App\Actions;

use App\Note;
use Crab\Contracts\Session\Session;
use Crab\Http\Response;

/**
 * The home page: the latest notes, and the form that adds one.
 */
final readonly class ShowNotes
{
    public function handle(Session $session): Response
    {
        return view('notes', [
            'notes' => Note::query()->orderBy('id', 'desc')->limit(50)->get(),
            // Set by AddNote before it redirected here; shown on this request only.
            'status' => $session->get('status'),
        ]);
    }
}
