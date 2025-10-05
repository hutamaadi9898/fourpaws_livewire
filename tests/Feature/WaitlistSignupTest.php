<?php

use App\Models\WaitlistSignup;
use Livewire\Volt\Volt;

use function Pest\Laravel\assertDatabaseHas;

it('displays landing page with waitlist form', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('Celebrate your pet\'s life')
        ->assertSee('Request early access');
});

it('validates required fields for waitlist signup', function () {
    Volt::test('pages.landing')
        ->set('name', '')
        ->set('email', '')
        ->call('joinWaitlist')
        ->assertHasErrors([
            'name',
            'email',
        ]);
});

it('validates email format for waitlist', function () {
    Volt::test('pages.landing')
        ->set('name', 'John Doe')
        ->set('email', 'invalid-email')
        ->call('joinWaitlist')
        ->assertHasErrors(['email']);
});

it('submits waitlist signup successfully', function () {
    Volt::test('pages.landing')
        ->set('name', 'Jane Smith')
        ->set('email', 'jane@example.com')
        ->set('message', 'I would love to create a memorial for my dog.')
        ->call('joinWaitlist')
        ->assertHasNoErrors()
        ->assertSet('waitlistSubmitted', true);

    assertDatabaseHas(WaitlistSignup::class, [
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
        'message' => 'I would love to create a memorial for my dog.',
    ]);
});

it('allows waitlist signup without message', function () {
    Volt::test('pages.landing')
        ->set('name', 'Bob Johnson')
        ->set('email', 'bob@example.com')
        ->set('message', '')
        ->call('joinWaitlist')
        ->assertHasNoErrors();

    assertDatabaseHas(WaitlistSignup::class, [
        'name' => 'Bob Johnson',
        'email' => 'bob@example.com',
        'message' => null,
    ]);
});

it('clears form after successful waitlist signup', function () {
    Volt::test('pages.landing')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('message', 'Looking forward to trying this!')
        ->call('joinWaitlist')
        ->assertSet('name', '')
        ->assertSet('email', '')
        ->assertSet('message', '');
});

it('prevents duplicate waitlist signups with same email', function () {
    WaitlistSignup::factory()->create(['email' => 'duplicate@example.com']);

    Volt::test('pages.landing')
        ->set('name', 'Duplicate User')
        ->set('email', 'duplicate@example.com')
        ->set('message', 'Test message')
        ->call('joinWaitlist')
        ->assertHasErrors(['email']);
});

it('sets source to landing by default', function () {
    Volt::test('pages.landing')
        ->set('name', 'Source Test')
        ->set('email', 'source@example.com')
        ->call('joinWaitlist');

    $signup = WaitlistSignup::where('email', 'source@example.com')->first();
    expect($signup->source)->toBe('landing');
});
