<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\BreederProfileController;
use App\Http\Controllers\DogShelterController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\BreederCategoryController;
use App\Http\Controllers\PuppyController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\PuppyParentController;
use App\Http\Controllers\Auth\LoginController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('loggedin');     
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset Routes (if needed)
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Route::put('/profile/update', [UserController::class, 'update'])->name('profile.update');
Route::put('/profile/update/{id}', [UserController::class, 'breederupdate'])->name('profile.update');
Route::post('/profile/store', [UserController::class, 'breederstore'])->name('profile.store');
Route::post('/user/store', [UserController::class, 'store'])->name('register');


Route::get('/', function () {
    return view('welcome');
});
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'role:breeder'])->name('dashboard');

// Parent CRUD Routes
Route::get('/parents', [ParentController::class, 'index'])->middleware(['auth', 'role:breeder'])->name('parents.index');
Route::get('/parents/create', [ParentController::class, 'create'])->name('parents.create');
Route::post('/parents', [ParentController::class, 'store'])->name('parents.store');
Route::get('/parents/{parent}', [ParentController::class, 'show'])->name('parents.show');
Route::get('/parents/{parent}/edit', [ParentController::class, 'edit'])->name('parents.edit');
Route::put('/parents/{parent}', [ParentController::class, 'update'])->name('parents.update');
Route::delete('/parents/{parent}', [ParentController::class, 'destroy'])->name('parents.destroy');
Route::get('/parents/{parent}/puppies', [ParentController::class, 'showPuppies'])->name('parents.puppies');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::put('/users', [UserController::class, 'update'])->name('users.update');

// Breeder Routes
Route::get('/breeders', [BreederProfileController::class, 'index'])->middleware(['auth', 'role:breeder'])->name('breeders.index');
Route::get('/breeders/{id}', [BreederProfileController::class, 'show'])->name('breeders.profile');
Route::get('/breeders/{id}/edit', [BreederProfileController::class, 'edit'])->name('breeders.edit');
Route::put('/breeders/{id}', [BreederProfileController::class, 'update'])->name('breeders.update');
Route::get('/breeders/{id}/reviews', [BreederProfileController::class, 'reviews'])->name('breeders.reviews');
Route::get('/breeders/{id}/puppies', [BreederProfileController::class, 'puppies'])->name('breeders.puppies');

Route::get('/breeder-categories', [BreederCategoryController::class, 'index'])->middleware(['auth', 'role:breeder'])->name('breeder-categories.index');

// Store a newly created breeder category in storage
Route::post('/breeder-categories', [BreederCategoryController::class, 'store'])->middleware(['auth', 'role:breeder'])->name('breeder-categories.store');

// Display the specified breeder category
Route::get('/breeder-categories/{breederCategory}', [BreederCategoryController::class, 'show'])->name('breeder-categories.show');

// Update the specified breeder category in storage
Route::put('/breeder-updates/{breeder_category}', [BreederCategoryController::class, 'update'])->name('breeder-categories.update');

// Remove the specified breeder category from storage
Route::delete('/breeder-categories/{breederCategory}', [BreederCategoryController::class, 'destroy'])->name('breeder-categories.destroy');
// Puppy Routes
// Route::resource('puppies', PuppyController::class);
// Route::prefix('puppies/{puppy}')->group(function () {
//     Route::resource('parents', PuppyParentController::class)->except(['index', 'show']);
// });
// Puppy Routes
Route::get('/puppies', [PuppyController::class, 'index'])->middleware(['auth', 'role:breeder'])->name('puppies.index');
Route::get('/search-puppies', [PuppyController::class, 'search']);
Route::get('/puppies/create', [PuppyController::class, 'create'])->name('puppies.create');
Route::post('/puppies', [PuppyController::class, 'store'])->name('puppies.store');
Route::post('/puppiessibling', [PuppyController::class, 'storeSibling'])->name('puppies.store-sibling');
Route::post('/puppies/store-sibling', [PuppyController::class, 'storeSibling'])->name('puppies.store-sibling');
Route::get('/puppies/{puppy}', [PuppyController::class, 'show'])->name('puppies.show');
Route::get('/puppie/{puppy}', [PuppyController::class, 'profileshow'])->name('puppiesprofile.show');
Route::get('/breederprofile/{id}', [PuppyController::class, 'breederprofile'])->name('breederprofile');
Route::get('/puppies/{puppy}/edit', [PuppyController::class, 'edit'])->name('puppies.edit');
Route::put('/puppies/{puppy}', [PuppyController::class, 'update'])->name('puppies.update');
Route::delete('/puppies/{puppy}', [PuppyController::class, 'destroy'])->name('puppies.destroy');
Route::post('/puppies/{puppy}/remove-gallery-image', [PuppyController::class, 'removeGalleryImage'])
    ->name('puppies.removeGalleryImage');
Route::get('/puppies/{puppy}/siblings', [PuppyController::class, 'siblingsIndex'])->name('puppies.siblings.index');
Route::post('/puppies/{puppy}/siblings', [PuppyController::class, 'storeSibling'])->name('siblings.store');
Route::get('/puppies/{puppy}/siblings/{sibling}', [PuppyController::class, 'showSibling'])->name('siblings.show');
Route::get('/puppies/{puppy}/siblings/{sibling}/edit', [PuppyController::class, 'editSibling'])->name('siblings.edit');
Route::put('/puppies/{puppy}/siblings/{sibling}', [PuppyController::class, 'updateSibling'])->name('siblings.update');
Route::delete('/puppies/{puppy}/siblings/{sibling}', [PuppyController::class, 'destroySibling'])->name('siblings.destroy');

// Puppy Parents Routes
Route::get('/puppies/{puppy}/parents', [PuppyParentController::class, 'index'])->name('puppy-parents.index');
Route::get('/puppies/{puppy}/parents/create', [PuppyParentController::class, 'create'])->name('puppy-parents.create');
Route::post('/puppies/{puppy}/parents', [PuppyParentController::class, 'store'])->name('puppy-parents.store');
Route::get('/puppies/{puppy}/parents/{parent}/edit', [PuppyParentController::class, 'edit'])->name('puppy-parents.edit');
Route::put('/puppies/{puppy}/parents/{parent}', [PuppyParentController::class, 'update'])->name('puppy-parents.update');
Route::delete('/puppies/{puppy}/parents/{parent}', [PuppyParentController::class, 'destroy'])->name('puppy-parents.destroy');

// Simple Dog Shelter Routes
Route::get('/dog-shelters', [DogShelterController::class, 'index'])->name('dog-shelters.index');
Route::get('/dog-shelters/create', [DogShelterController::class, 'create'])->name('dog-shelters.create');
Route::post('/dog-shelters', [DogShelterController::class, 'store'])->name('dog-shelters.store');
Route::get('/dog-shelters/{dogShelter}', [DogShelterController::class, 'show'])->name('dog-shelters.show');
Route::get('/dog-shelters/{dogShelter}/edit', [DogShelterController::class, 'edit'])->name('dog-shelters.edit');
Route::put('/dog-shelters/{dogShelter}', [DogShelterController::class, 'update'])->name('dog-shelters.update');
Route::delete('/dog-shelters/{dogShelter}', [DogShelterController::class, 'destroy'])->name('dog-shelters.destroy');


// Adoption Routes
    // General adoption routes
    // Adoption routes
Route::get('/adoptions/create', [AdoptionController::class, 'create'])->name('adoptions.create');
Route::get('/puppies/{puppy}/adopt', [AdoptionController::class, 'store'])
    ->name('adoptions.store');
    Route::get('adoptions/{adoption}', [AdoptionController::class, 'show'])->middleware(['auth', 'role:breeder'])
->name('adoptions.show');
Route::get('/users/{user}/details', [AdoptionController::class, 'showUserDetails'])->name('users.details');
// Edit adoption request (for user)
Route::get('adoptions/{adoption}/edit', [AdoptionController::class, 'edit'])
->name('adoptions.edit');
// Update adoption request
Route::put('adoptions/{adoption}', [AdoptionController::class, 'update'])
->name('adoptions.update');

// Delete adoption request
Route::delete('adoptions/{adoption}', [AdoptionController::class, 'destroy'])
->name('adoptions.destroy');
    
    // Breeder-specific adoption routes
    Route::prefix('breeder')->group(function () {
        Route::get('/adoptions', [AdoptionController::class, 'breederIndex'])
            ->name('adoptions.index');
        
        Route::post('/adoptions/{adoption}/approve', [AdoptionController::class, 'approve'])
            ->name('adoptions.approve');
        
        Route::post('/adoptions/{adoption}/reject', [AdoptionController::class, 'reject'])
            ->name('adoptions.reject');
    });
;


Route::resource('questions', QuestionController::class)->middleware('auth');
Route::get('adopt/{puppy}/questions', [AdoptionController::class, 'questions'])->name('adoptions.questions');
Route::post('adopt/{puppy}/questions', [AdoptionController::class, 'storeAnswers'])->name('adoptions.storeAnswers');
Route::post('questions/reorder', [QuestionController::class, 'reorder'])->name('questions.reorder');


Route::prefix('chat')->middleware(['auth'])->group(function() {
    Route::get('/', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/conversations', [ChatController::class, 'chatindex'])->name('chat.chatindex');
    Route::get('/conversations/{conversation}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
    // Route::post('/send', [ChatController::class, 'send'])->name('chat.store');
    Route::get('messages/{id}', [ChatController::class, 'getMessages'])->name('users.message');
    Route::post('/conversations', [ChatController::class, 'storeconversations'])->name('conversation.store');
});
// In web.php
Route::post('/mark-messages-as-read', [ChatController::class, 'markMessagesAsRead'])->name('mark-messages-as-read');
Route::post('/mark-read', [ChatController::class, 'markMessagesRead'])->name('mark.messages.read');

