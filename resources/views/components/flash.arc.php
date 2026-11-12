@props(?string $message = null)
@if($message !== null)
<p class="flash" role="status">{{ $message }}</p>
@endif
