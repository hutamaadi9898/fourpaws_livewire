<x-mail::message>
# New tribute awaiting approval

Hi {{ $memorial->owner?->name ?? 'there' }},

{{ $tribute->submitter_name }} shared a new tribute for {{ $memorial->pet_name }}. It's waiting for your approval so it can appear on the memorial timeline.

<x-mail::panel>
"{{ $tribute->message }}"
</x-mail::panel>

<x-mail::button :url="route('filament.admin.resources.tributes.edit', $tribute)">
Review tribute
</x-mail::button>

Need to make changes before approving? You can edit the message, capture their relationship, or decline it entirely.

Thanks for keeping {{ $memorial->pet_name }}'s story full of love.

With care,<br>
{{ config('app.name') }} Team
</x-mail::message>
