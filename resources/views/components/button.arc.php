@props(array $attributes = [], string $slot = '')
<button @attributes($attributes, ['type' => 'submit'])>{!! $slot !!}</button>
