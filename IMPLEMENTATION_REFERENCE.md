# FourPaws - Quick Implementation Reference

## What Was Fixed

### 1. Tailwind CSS Errors
**Problem**: Conflicting `focus-visible:outline` utility classes  
**Solution**: Removed redundant `focus-visible:outline` declarations, kept only `focus-visible:outline-2`

**Files Fixed**:
- `resources/views/memorials/create.blade.php`
- `resources/views/memorials/show.blade.php`
- `resources/views/pages/landing.blade.php`

### 2. Syntax Errors in Job
**Problem**: Missing variable names in `SyncWaitlistSignup.php`  
**Solution**: Added proper variable declarations throughout the class

**File**: `app/Jobs/SyncWaitlistSignup.php`

### 3. Code Formatting
**Problem**: Inconsistent PSR-12 formatting  
**Solution**: Ran `vendor/bin/pint` - all files now properly formatted

## What Was Implemented

### Phase 0: Platform Setup ✅

#### Database Schema
All migrations successfully run with proper relationships:

```php
// Memorials Table
- id (ULID primary key)
- owner_id (foreign key to users)
- title, slug (unique), pet_name
- headline, summary, story
- theme (JSONB for colors)
- status, visibility
- hero_image_path
- published_at timestamp
- Indexes on owner_id+status and visibility+status

// Tributes Table  
- id (ULID primary key)
- memorial_id (foreign key, cascade delete)
- submitter_name, submitter_email
- relationship, headline, message
- status (pending/approved/rejected)
- approved_at, rejected_at, published_at
- moderated_by
- Indexes on memorial_id+status and status

// Media Assets Table
- id (ULID primary key)
- memorial_id (foreign key, cascade delete)
- collection (hero/gallery)
- disk, path, thumbnail_path
- type, sort_order

// Waitlist Signups Table
- id (ULID primary key)
- name, email (unique)
- message, source
- meta (JSONB)
```

#### Configuration
- ✅ Volt mounted for pages and memorials directories
- ✅ Routes configured with subdomain fallback pattern
- ✅ PostgreSQL database configured
- ✅ File storage configured for public disk

### Phase 1 & 2: MVP Features

#### 1. Memorial Creation Wizard (`resources/views/memorials/create.blade.php`)

**Step 1 - Companion Info**:
- Owner name (optional)
- Owner email (required, validated)
- Pet name (required)
- Memorial title (required)

**Step 2 - Story**:
- Headline (optional, max 180 chars)
- Summary (optional, max 400 chars)  
- Story (required, min 50 chars)

**Step 3 - Design**:
- Visibility (private/unlisted/public)
- Theme colors (primary/accent)
- Hero image upload (max 5MB)
- Gallery images (up to 6, max 5MB each)

**Step 4 - Preview**:
- Review all entered data
- Publish button

**Features**:
- Auto-creates user account from email
- Uses existing user if email exists
- Generates unique slugs (e.g., "pepper", "pepper-1", "pepper-2")
- Stores uploaded images to public disk
- Creates MediaAsset records for each image
- Sets status based on visibility
- Logs user in after creation

#### 2. Memorial Display (`resources/views/memorials/show.blade.php`)

**Displays**:
- Memorial title and pet name
- Hero image
- Story with whitespace preservation
- Gallery images
- Approved tributes (sorted by published_at)

**Tribute Submission Form**:
- Name (required)
- Email (optional, validated if provided)
- Relationship (optional)
- Message (required, 10-1000 chars)
- Auto-clears form after submission
- Sets status to "pending" for moderation

#### 3. Landing Page (`resources/views/pages/landing.blade.php`)

**Sections**:
- Hero with call-to-action
- Feature showcase
- Stats (memorials published, tributes shared, avg setup time)
- Testimonials
- FAQ section with expandable details
- Waitlist signup form

**Waitlist Form**:
- Name (required)
- Email (required, unique)
- Message (optional)
- Sets source to "landing"
- Validates unique email

#### 4. Admin Panel (Filament Resources)

**Memorial Resource** (`app/Filament/Resources/MemorialResource.php`):
- List, create, edit memorials
- Filter by status and visibility
- Search by title, pet_name, owner email
- View relationships (tributes, media assets)

**Tribute Resource** (`app/Filament/Resources/TributeResource.php`):
- List all tributes
- Moderation workflow (approve/reject actions)
- Filter by status
- Search by submitter name, memorial

#### 5. Email Notifications

**Classes Created**:
- `App\Mail\MemorialPublished` - Sent when memorial is published
- `App\Mail\TributeSubmitted` - Sent when new tribute needs moderation

**Note**: Email dispatching not yet wired into the flow, needs queue integration.

#### 6. Background Jobs

**SyncWaitlistSignup** (`app/Jobs/SyncWaitlistSignup.php`):
- Queued job to sync waitlist signups to external service
- Configurable via `config/services.php` (waitlist section)
- Supports authentication token
- Logs success/failure
- Throws exceptions on failure for retry

## Test Suite Created

### `tests/Feature/MemorialCreationTest.php` (14 tests)
- Form display
- Step-by-step validation
- Wizard navigation (next/back)
- User creation logic
- Slug uniqueness
- File upload validation
- Status setting based on visibility
- Image storage verification

### `tests/Feature/TributeSubmissionTest.php` (12 tests)
- Memorial page display
- Form validation
- Message length constraints
- Tribute submission flow
- Status management  
- Approved vs pending display
- Form clearing after submission
- Optional email field

### `tests/Feature/WaitlistSignupTest.php` (9 tests)
- Landing page display
- Form validation
- Email uniqueness
- Optional message field
- Form clearing
- Source tracking

**Current Status**: Tests written but not passing due to Volt component discovery issue.

## Models & Relationships

### Memorial Model
```php
class Memorial extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;
    
    // Relationships
    public function owner(): BelongsTo // -> User
    public function tributes(): HasMany // -> Tribute
    public function approvedTributes(): HasMany
    public function mediaAssets(): HasMany // -> MediaAsset
    
    // Casts
    protected function casts(): array
    {
        'theme' => 'array',
        'published_at' => 'datetime',
    }
}
```

### Tribute Model
```php
class Tribute extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;
    
    // Relationships
    public function memorial(): BelongsTo // -> Memorial
    
    // Casts
    protected function casts(): array
    {
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'published_at' => 'datetime',
    }
}
```

### MediaAsset Model
```php
class MediaAsset extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;
    
    // Relationships
    public function memorial(): BelongsTo // -> Memorial
    
    // Methods
    public function getUrl(): string // Full URL to asset
}
```

### WaitlistSignup Model
```php
class WaitlistSignup extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;
    
    // Casts
    protected function casts(): array
    {
        'meta' => 'array',
    }
}
```

## Factories (for Testing)

All models have factories with realistic fake data:
- `MemorialFactory` - Creates memorials with complete data
- `TributeFactory` - Creates tributes with relationships
- `MediaAssetFactory` - Creates media records
- `WaitlistSignupFactory` - Creates waitlist entries
- `UserFactory` - Laravel default user factory

## Routes

```php
// Public Routes
GET  /                           -> pages.landing
GET  /memorials/create           -> memorials.create
GET  /memorials/{memorial:slug}  -> memorials.show
GET  /{memorial:slug}            -> memorials.show (fallback)

// Static Pages
GET  /privacy                    -> pages.privacy
GET  /terms                      -> pages.terms

// Admin Routes (Filament)
GET  /admin                      -> Dashboard
GET  /admin/login                -> Login
GET  /admin/memorials            -> Memorial Resource
GET  /admin/tributes             -> Tribute Resource

// Livewire Routes (auto-registered)
POST /livewire/update
POST /livewire/upload-file
GET  /livewire/preview-file/{filename}
```

## Key Files Reference

### Views
- `resources/views/layouts/app.blade.php` - Main layout
- `resources/views/pages/landing.blade.php` - Landing page (Volt)
- `resources/views/memorials/create.blade.php` - Creation wizard (Volt)
- `resources/views/memorials/show.blade.php` - Memorial display (Volt)

### Models
- `app/Models/Memorial.php`
- `app/Models/Tribute.php`
- `app/Models/MediaAsset.php`
- `app/Models/WaitlistSignup.php`
- `app/Models/User.php`

### Filament Resources
- `app/Filament/Resources/MemorialResource.php`
- `app/Filament/Resources/TributeResource.php`

### Jobs & Mail
- `app/Jobs/SyncWaitlistSignup.php`
- `app/Mail/MemorialPublished.php`
- `app/Mail/TributeSubmitted.php`

### Configuration
- `app/Providers/AppServiceProvider.php` - Volt mounting
- `routes/web.php` - All application routes
- `config/memorials.php` - Memorial-specific config

## Usage Examples

### Create a Memorial (Programmatically)
```php
use App\Models\Memorial;
use App\Models\User;

$user = User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => Hash::make('password'),
]);

$memorial = Memorial::create([
    'owner_id' => $user->id,
    'title' => 'Bella\'s Journey',
    'slug' => 'bella-journey',
    'pet_name' => 'Bella',
    'story' => 'Bella was an amazing dog...',
    'theme' => [
        'primary' => '#4f46e5',
        'accent' => '#f97316',
    ],
    'status' => 'published',
    'visibility' => 'public',
    'published_at' => now(),
]);
```

### Submit a Tribute
```php
use App\Models\Tribute;

$tribute = Tribute::create([
    'memorial_id' => $memorial->id,
    'submitter_name' => 'Jane Smith',
    'submitter_email' => 'jane@example.com',
    'relationship' => 'Friend',
    'message' => 'Bella was such a wonderful companion...',
    'status' => 'pending',
]);
```

### Join Waitlist
```php
use App\Models\WaitlistSignup;

$signup = WaitlistSignup::create([
    'name' => 'Alex Rivera',
    'email' => 'alex@example.com',
    'message' => 'Looking forward to creating a memorial!',
    'source' => 'landing',
]);
```

## Commands

```bash
# Run migrations
php artisan migrate

# Clear caches
php artisan optimize:clear

# Run tests
php artisan test

# Format code
vendor/bin/pint

# Create admin user (manual)
php artisan tinker
>>> User::create(['name' => 'Admin', 'email' => 'admin@fourpaws.test', 'password' => Hash::make('password')]);

# Run queue worker (for background jobs)
php artisan queue:work

# Generate IDE helper (optional)
php artisan ide-helper:generate
```

## Next Steps for Developer

1. **Fix Volt Component Discovery**:
   - Debug component registration
   - May need to check Volt version compatibility
   - Consider fallback to standard Livewire components

2. **Complete Email Integration**:
   - Dispatch MemorialPublished mail when memorial is created
   - Dispatch TributeSubmitted mail when tribute needs moderation
   - Configure mail driver (log/smtp/ses)

3. **Add Security Features**:
   - Rate limiting on forms
   - hCaptcha integration
   - Input sanitization review

4. **Performance**:
   - Verify database indexes are being used
   - Implement image optimization
   - Add caching for memorial pages

5. **SEO**:
   - Generate XML sitemap
   - Add JSON-LD structured data
   - Create og:image generator

This implementation provides a solid foundation for Phases 0-2 of the plan. The core functionality is in place and properly structured following Laravel and Filament best practices.
