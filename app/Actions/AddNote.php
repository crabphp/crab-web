<?php

declare(strict_types=1);

namespace App\Actions;

use App\Http\NoteInput;
use App\Note;
use Crab\Contracts\Session\Session;
use Crab\Http\Response;

/**
 * Saves a note from the form, then goes back to the page, which says so once.
 */
final readonly class AddNote
{
    public function handle(NoteInput $input, Session $session): Response
    {
        new Note(trim($input->text))->save();
        $session->flash('status', 'Note saved.');

        return Response::redirect('/', 303);
    }
}
