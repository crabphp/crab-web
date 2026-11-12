<?php

declare(strict_types=1);

use App\Actions\AddNote;
use App\Actions\ShowNotes;
use Crab\Route;

Route::get('/', ShowNotes::class);
Route::post('/notes', AddNote::class);
