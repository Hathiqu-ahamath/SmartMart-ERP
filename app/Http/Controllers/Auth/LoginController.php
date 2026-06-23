<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $defaultRole = Role::where('slug', 'cashier')->first();
        if (!$defaultRole) {
            $defaultRole = Role::first();
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $defaultRole?->id ?? 1,
            'is_active' => true,
        ]);

        Auth::login($user);
        return redirect()->intended(route('dashboard'));
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->role) {
                return redirect()->intended(match($user->role->slug) {
                    'admin' => route('dashboard'),
                    'cashier' => route('sales.pos'),
                    'storekeeper' => route('inventory.index'),
                    'manager' => route('dashboard'),
                    default => route('dashboard'),
                });
            }
            return redirect()->intended(route('dashboard'));
        }
        return back()->withErrors(['email' => 'Invalid credentials.'])->onlyInput('email');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
