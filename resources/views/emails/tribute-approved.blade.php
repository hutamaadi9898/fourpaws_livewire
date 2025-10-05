<x-mail::message>
# Your Tribute Has Been Approved

Hello {{ $tribute->submitter_name }},

Thank you for sharing your heartfelt tribute to **{{ $memorial->pet_name }}**.

We're pleased to let you know that your tribute has been approved and is now visible on {{ $memorial->pet_name }}'s memorial page.

@if($tribute->headline)
**Your Tribute:** {{ $tribute->headline }}
@endif

<x-mail::button :url="$memorialUrl">
View Memorial
</x-mail::button>

Thank you for helping celebrate {{ $memorial->pet_name }}'s memory.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
