<?php

declare(strict_types=1);

namespace App;

use Crab\Tide\Model;

/**
 * A row of the notes table, read and saved by Tide.
 */
final class Note extends Model
{
    public int $id;
    public ?\DateTimeImmutable $created_at = null;
    public ?\DateTimeImmutable $updated_at = null;

    public function __construct(
        public string $text,
    ) {}
}
