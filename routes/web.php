<?php

use App\Http\Controllers\Auth\LoginController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('login', [LoginController::class, 'create'])->name('login');
Route::post('login', [LoginController::class, 'store']);
Route::post('logout', [LoginController::class, 'destroy'])->middleware('Auth');

Route::middleware('Auth')->group(function () {
    //Route::get('/', function () {
    //    return view('welcome');
    //});

    //Route::get('/', function () {
    //    return inertia('Welcome');
    //});

    Route::get('/', function () {
        return Inertia::render('Home', [
            'name' => 'Hendy Saputra',
            'frameworks' => [
                'Laravel', 'Vue', 'Inertia',
            ],
        ]);
    });

    Route::get('/users', function () {
    //    sleep(2);

    //   return Inertia::render('Users', [
    //       'users' => User::all()->map(fn($user) => [
    //           'id' => $user->id,
    //           'name' => $user->name,
    //       ])
    ////       'time' => now()->toTimeString(),
    //   ]);
        return Inertia::render('Users/Index', [
           'users' => User::query()
               ->when(Request::input('search'), function ($query, $search) {
                   $query->where('name', 'like', "%{$search}%");
               })
               ->paginate(10)
               ->withQueryString()
               ->through(fn($user) => [
               'id' => $user->id,
               'name' => $user->name,
               'can' => [
                   'edit' => Auth::user()->can('edit', $user),
               ]
           ]),
            'filters' => Request::only(['search']),
            'can' => [
                'createUser' => Auth::user()->can('create', User::class),
            ]
        ]);
    });

    Route::get('/users/create', function () {
        return Inertia::render('Users/Create');
    })->can('create, App\Model\User');

    Route::post('/users', function () {
        sleep(3);
        $attributes = Request::validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        User::create($attributes);

        return redirect('/users');
    });

    Route::get('/settings', function () {
        return Inertia::render('Settings');
    });

//    Route::post('/logout', function () {
//        dd(request('foo'));
//    });
});

