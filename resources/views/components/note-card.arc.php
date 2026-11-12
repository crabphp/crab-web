<?php
use App\Note;
?>
@props(Note $note)
<div class="note">
    {{ $note->text }}
    <div class="muted">{{ $note->created_at?->format('j M Y, H:i') }}</div>
</div>
