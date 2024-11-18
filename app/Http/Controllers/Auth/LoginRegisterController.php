<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class LoginRegisterController extends Controller
{
    /**
     * Instantiate a new LoginRegisterController instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'dashboard']);
    }

    /**
     * Display a registration form.
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        return view('auth.register');
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'age' => ['required', 'integer', 'min:1'], 
        ]);
    }

    /**
     * Store a new user.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:250',
        'email' => 'required|email|max:250|unique:users',
        'password' => 'required|min:8|confirmed',
        'age' => 'required|integer|min:1',
        'photo' => 'image|nullable|max:1999',
    ]);

    if ($request->age < 18) {
        return redirect()->route('welcome') 
            ->with('error', 'Anda berusia kurang dari 18 Tahun!');
    }

    $path = null;
    if ($request->hasFile('photo')) {
        $filenameWithExt = $request->file('photo')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('photo')->getClientOriginalExtension();
        $path = $request->file('photo')->storeAs('photos', $filename . '_' . time() . '.' . $extension);
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'age' => $request->age,
        'photo' => $path,
    ]);

    $emailData = [
        'subject' => 'Selamat! Akun Anda Telah Berhasil Didaftarkan',
        'name' => $user->name,
        'email' => $user->email,
        'date' => now()->format('d-m-Y H:i:s'),
    ];

    // Kirim email
    Mail::to($user->email)->send(new SendEmail($emailData));

    // Login otomatis
    Auth::login($user);
    $request->session()->regenerate();

    return redirect()->route('dashboard')
        ->with('success', 'Pendaftaran berhasil! Anda telah login.');
}


    /**
     * Display a login form.
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Authenticate the user.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')
                ->withSuccess('You have successfully logged in!');
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.'
        ])->onlyInput('email');
    }

    /**
     * Display a dashboard to authenticated users.
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if (Auth::check()) {
            return view('auth.dashboard');
        }

        return redirect()->route('login')
            ->withErrors(['email' => 'Please login to access the dashboard.'])
            ->onlyInput('email');
    }

    /**
     * Log out the user from application.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');
    }
}
