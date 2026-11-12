<?php

declare(strict_types=1);

namespace App\Http;

use Crab\Validation\Length;

/**
 * The form that adds a note.
 */
final readonly class NoteInput
{
    public function __construct(
        #[Length(min: 1, max: 200)]
        public string $text,
    ) {}
}
