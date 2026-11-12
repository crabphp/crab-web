@props(string $name, string $label, array $attributes = [])
<label class="muted" for="{{ $name }}" hidden>{{ $label }}</label>
<input @attributes($attributes, ['id' => $name, 'name' => $name, 'type' => 'text', 'aria-label' => $label])>
