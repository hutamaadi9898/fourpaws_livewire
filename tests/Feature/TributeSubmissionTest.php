<?php

use App\Models\Memorial;
use App\Models\Tribute;
use Livewire\Volt\Volt;

use function Pest\Laravel\assertDatabaseHas;

it('displays memorial page', function () {
    $memorial = Memorial::factory()->create([
        'status' => 'published',
        'visibility' => 'public',
    ]);

    $this->get(route('memorials.show', $memorial))
        ->assertOk()
        ->assertSee($memorial->pet_name)
        ->assertSee($memorial->story);
});

it('displays tribute submission form', function () {
    $memorial = Memorial::factory()->create();

    Volt::test('memorials.show', ['memorial' => $memorial])
        ->assertSee('Share a tribute')
        ->assertSee('Your name')
        ->assertSee('Message');
});

it('validates required fields for tribute', function () {
    $memorial = Memorial::factory()->create();

    Volt::test('memorials.show', ['memorial' => $memorial])
        ->set('tribute_name', '')
        ->set('tribute_message', '')
        ->call('submitTribute')
        ->assertHasErrors([
            'tribute_name',
            'tribute_message',
        ]);
});

it('validates tribute message minimum length', function () {
    $memorial = Memorial::factory()->create();

    Volt::test('memorials.show', ['memorial' => $memorial])
        ->set('tribute_name', 'John Doe')
        ->set('tribute_message', 'Short')
        ->call('submitTribute')
        ->assertHasErrors(['tribute_message']);
});

it('validates tribute message maximum length', function () {
    $memorial = Memorial::factory()->create();

    Volt::test('memorials.show', ['memorial' => $memorial])
        ->set('tribute_name', 'John Doe')
        ->set('tribute_message', str_repeat('a', 1001))
        ->call('submitTribute')
        ->assertHasErrors(['tribute_message']);
});

it('submits tribute successfully', function () {
    $memorial = Memorial::factory()->create();

    Volt::test('memorials.show', ['memorial' => $memorial])
        ->set('tribute_name', 'Jane Smith')
        ->set('tribute_email', 'jane@example.com')
        ->set('tribute_relationship', 'Friend')
        ->set('tribute_message', 'What a wonderful companion. I will miss them dearly.')
        ->call('submitTribute')
        ->assertHasNoErrors()
        ->assertSet('tributeSubmitted', true);

    assertDatabaseHas(Tribute::class, [
        'memorial_id' => $memorial->id,
        'submitter_name' => 'Jane Smith',
        'submitter_email' => 'jane@example.com',
        'relationship' => 'Friend',
        'message' => 'What a wonderful companion. I will miss them dearly.',
        'status' => 'pending',
    ]);
});

it('sets tribute status to pending by default', function () {
    $memorial = Memorial::factory()->create();

    Volt::test('memorials.show', ['memorial' => $memorial])
        ->set('tribute_name', 'Bob Johnson')
        ->set('tribute_message', 'They brought so much joy to our lives.')
        ->call('submitTribute');

    $tribute = Tribute::where('submitter_name', 'Bob Johnson')->first();
    expect($tribute->status)->toBe('pending');
    expect($tribute->approved_at)->toBeNull();
    expect($tribute->published_at)->toBeNull();
});

it('displays only approved tributes', function () {
    $memorial = Memorial::factory()->create();

    $approvedTribute = Tribute::factory()->create([
        'memorial_id' => $memorial->id,
        'status' => 'approved',
        'published_at' => now(),
        'submitter_name' => 'Approved User',
        'message' => 'This tribute is approved',
    ]);

    $pendingTribute = Tribute::factory()->create([
        'memorial_id' => $memorial->id,
        'status' => 'pending',
        'submitter_name' => 'Pending User',
        'message' => 'This tribute is pending',
    ]);

    Volt::test('memorials.show', ['memorial' => $memorial])
        ->assertSee('Approved User')
        ->assertSee('This tribute is approved')
        ->assertDontSee('Pending User')
        ->assertDontSee('This tribute is pending');
});

it('clears form after successful submission', function () {
    $memorial = Memorial::factory()->create();

    Volt::test('memorials.show', ['memorial' => $memorial])
        ->set('tribute_name', 'Test User')
        ->set('tribute_email', 'test@example.com')
        ->set('tribute_relationship', 'Family')
        ->set('tribute_message', 'A heartfelt message about this wonderful pet.')
        ->call('submitTribute')
        ->assertSet('tribute_name', '')
        ->assertSet('tribute_email', '')
        ->assertSet('tribute_relationship', '')
        ->assertSet('tribute_message', '');
});

it('validates email format for tribute', function () {
    $memorial = Memorial::factory()->create();

    Volt::test('memorials.show', ['memorial' => $memorial])
        ->set('tribute_name', 'Test User')
        ->set('tribute_email', 'invalid-email')
        ->set('tribute_message', 'A heartfelt message about this wonderful pet.')
        ->call('submitTribute')
        ->assertHasErrors(['tribute_email']);
});

it('allows tribute submission without email', function () {
    $memorial = Memorial::factory()->create();

    Volt::test('memorials.show', ['memorial' => $memorial])
        ->set('tribute_name', 'Anonymous User')
        ->set('tribute_email', '')
        ->set('tribute_message', 'A heartfelt message about this wonderful pet.')
        ->call('submitTribute')
        ->assertHasNoErrors();

    assertDatabaseHas(Tribute::class, [
        'memorial_id' => $memorial->id,
        'submitter_name' => 'Anonymous User',
        'submitter_email' => null,
    ]);
});
