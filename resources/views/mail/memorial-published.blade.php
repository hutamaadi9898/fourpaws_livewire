<x-mail::message>
# {{ $memorial->title }}

Hi {{ $memorial->owner?->name ?? 'there' }},

Your memorial for {{ $memorial->pet_name }} is ready. We've saved your story, theme, and any media you shared so you can keep refining it whenever inspiration strikes.

<x-mail::button :url="route('memorials.show', $memorial)">
View memorial
</x-mail::button>

### Next steps
- Share the memorial link with friends and family so they can leave tributes.
- Add more photos or polish the story from your dashboard when you're ready.
- Adjust privacy or theme settings anytime from the builder.

If you need a hand, just reply to this email and our team will help.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
