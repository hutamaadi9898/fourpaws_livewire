<?php

use App\Models\Memorial;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Volt;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    Storage::fake('public');
});

it('displays the memorial creation form', function () {
    $this->get(route('memorials.create'))
        ->assertOk()
        ->assertSee('Craft a space for')
        ->assertSee('Pet name')
        ->assertSee('Memorial title');
});

it('validates required fields on step 1', function () {
    Volt::test('memorials.create')
        ->set('form.owner_email', '')
        ->set('form.pet_name', '')
        ->set('form.title', '')
        ->call('next')
        ->assertHasErrors([
            'form.owner_email',
            'form.pet_name',
            'form.title',
        ]);
});

it('validates email format', function () {
    Volt::test('memorials.create')
        ->set('form.owner_email', 'invalid-email')
        ->call('next')
        ->assertHasErrors(['form.owner_email']);
});

it('progresses through wizard steps', function () {
    Volt::test('memorials.create')
        ->assertSet('step', 1)
        ->set('form.owner_name', 'Alex Rivera')
        ->set('form.owner_email', 'alex@example.com')
        ->set('form.pet_name', 'Pepper')
        ->set('form.title', 'Pepper\'s Adventure')
        ->call('next')
        ->assertSet('step', 2)
        ->set('form.story', 'Pepper was an amazing companion who brought joy to everyone she met. We will never forget her.')
        ->call('next')
        ->assertSet('step', 3);
});

it('can go back to previous steps', function () {
    Volt::test('memorials.create')
        ->set('step', 3)
        ->call('back')
        ->assertSet('step', 2)
        ->call('back')
        ->assertSet('step', 1);
});

it('validates story minimum length on step 2', function () {
    Volt::test('memorials.create')
        ->set('step', 2)
        ->set('form.story', 'Too short')
        ->call('next')
        ->assertHasErrors(['form.story']);
});

it('creates memorial with all data', function () {
    $heroFile = UploadedFile::fake()->image('hero.jpg');
    $galleryFile1 = UploadedFile::fake()->image('gallery1.jpg');
    $galleryFile2 = UploadedFile::fake()->image('gallery2.jpg');

    Volt::test('memorials.create')
        ->set('form.owner_name', 'Alex Rivera')
        ->set('form.owner_email', 'alex@example.com')
        ->set('form.pet_name', 'Pepper')
        ->set('form.title', 'Pepper\'s Adventure')
        ->set('form.headline', 'A gentle soul')
        ->set('form.summary', 'Pepper was wonderful.')
        ->set('form.story', 'Pepper was an amazing companion who brought joy to everyone she met. We will never forget her wonderful spirit and loving heart.')
        ->set('form.visibility', 'private')
        ->set('form.theme.primary', '#4f46e5')
        ->set('form.theme.accent', '#f97316')
        ->set('heroUpload', $heroFile)
        ->set('galleryUploads', [$galleryFile1, $galleryFile2])
        ->call('submit')
        ->assertHasNoErrors();

    assertDatabaseHas(Memorial::class, [
        'pet_name' => 'Pepper',
        'title' => 'Pepper\'s Adventure',
        'headline' => 'A gentle soul',
        'visibility' => 'private',
    ]);

    $memorial = Memorial::where('pet_name', 'Pepper')->first();
    expect($memorial)->not->toBeNull();
    expect($memorial->owner)->not->toBeNull();
    expect($memorial->owner->email)->toBe('alex@example.com');
    expect($memorial->slug)->not->toBeEmpty();

    Storage::disk('public')->assertExists($memorial->hero_image_path);
    expect($memorial->mediaAssets)->toHaveCount(3); // 1 hero + 2 gallery
});

it('creates user if email does not exist', function () {
    Volt::test('memorials.create')
        ->set('form.owner_name', 'New User')
        ->set('form.owner_email', 'newuser@example.com')
        ->set('form.pet_name', 'Buddy')
        ->set('form.title', 'Buddy\'s Story')
        ->set('form.story', 'Buddy was an amazing companion who brought joy to everyone he met. We will never forget his wonderful spirit.')
        ->call('submit');

    assertDatabaseHas(User::class, [
        'email' => 'newuser@example.com',
        'name' => 'New User',
    ]);
});

it('uses existing user if email already exists', function () {
    $existingUser = User::factory()->create(['email' => 'existing@example.com']);

    Volt::test('memorials.create')
        ->set('form.owner_email', 'existing@example.com')
        ->set('form.pet_name', 'Max')
        ->set('form.title', 'Max\'s Journey')
        ->set('form.story', 'Max was an amazing companion who brought joy to everyone he met. We will never forget his wonderful spirit.')
        ->call('submit');

    $memorial = Memorial::where('pet_name', 'Max')->first();
    expect($memorial->owner_id)->toBe($existingUser->id);
    expect(User::where('email', 'existing@example.com')->count())->toBe(1);
});

it('generates unique slugs for memorials', function () {
    Memorial::factory()->create(['pet_name' => 'Shadow', 'slug' => 'shadow']);

    Volt::test('memorials.create')
        ->set('form.owner_email', 'test@example.com')
        ->set('form.pet_name', 'Shadow')
        ->set('form.title', 'Shadow\'s Tale')
        ->set('form.story', 'Shadow was an amazing companion who brought joy to everyone he met. We will never forget his wonderful spirit.')
        ->call('submit');

    $memorial = Memorial::where('pet_name', 'Shadow')->latest()->first();
    expect($memorial->slug)->not->toBe('shadow');
    expect($memorial->slug)->toContain('shadow');
});

it('validates image file types and sizes', function () {
    $invalidFile = UploadedFile::fake()->create('document.pdf', 1000);

    Volt::test('memorials.create')
        ->set('step', 3)
        ->set('heroUpload', $invalidFile)
        ->call('next')
        ->assertHasErrors(['heroUpload']);
});

it('limits gallery to maximum 6 images', function () {
    $images = collect()->times(7, fn () => UploadedFile::fake()->image('gallery.jpg'));

    Volt::test('memorials.create')
        ->set('step', 3)
        ->set('galleryUploads', $images->toArray())
        ->call('next')
        ->assertHasErrors(['galleryUploads']);
});

it('sets status to draft for private and unlisted memorials', function () {
    Volt::test('memorials.create')
        ->set('form.owner_email', 'test@example.com')
        ->set('form.pet_name', 'Luna')
        ->set('form.title', 'Luna\'s Legacy')
        ->set('form.story', 'Luna was an amazing companion who brought joy to everyone she met. We will never forget her wonderful spirit.')
        ->set('form.visibility', 'private')
        ->call('submit');

    $memorial = Memorial::where('pet_name', 'Luna')->first();
    expect($memorial->status)->toBe('draft');
    expect($memorial->published_at)->toBeNull();
});

it('sets status to published for public memorials', function () {
    Volt::test('memorials.create')
        ->set('form.owner_email', 'test@example.com')
        ->set('form.pet_name', 'Rocky')
        ->set('form.title', 'Rocky\'s Journey')
        ->set('form.story', 'Rocky was an amazing companion who brought joy to everyone he met. We will never forget his wonderful spirit.')
        ->set('form.visibility', 'public')
        ->call('submit');

    $memorial = Memorial::where('pet_name', 'Rocky')->first();
    expect($memorial->status)->toBe('published');
    expect($memorial->published_at)->not->toBeNull();
});
