<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Laravel\Socialite\Facades\Socialite;

class MicrosoftAuthController extends Controller
{
    public function redirectToMicrosoft(){

        return Socialite::driver('microsoft')->scopes(['Files.read','Files.Read.All','Files.ReadWrite','Files.ReadWrite.All','openid','profile','Sites.Read.All','Sites.ReadWrite.All','User.Read','email','offline_access'])->redirect();
    }

    public function handleMicrosoftCallback(){
        $user = Socialite::driver('microsoft')->user();
        $usuario = User::where('email', $user->getEmail())->first();
        
        if(!$usuario){
            return redirect()->route('home')->with('error','El correo no existe, comuniquese con el administrador');
        }

        if(session('access_token')){
            return redirect()->route('logout.microsoft');
        }

        
        if($usuario->getRoleNames()->first() == 'admin' || $usuario->getRoleNames()->first() == 'adminmanto' || $usuario->getRoleNames()->first() == 'adminagricola'){
            if($usuario->status == 1){
                $expiresAt = now()->addSeconds($user->tokenExpiresIn);
                session(['access_token' => $user->token]);
                session(['refresh_token' => $user->refreshToken]);
                session(['token_expires_at' => $expiresAt]);
                auth()->login($usuario);
                return redirect()->route('dashboard');
            }else{
                return redirect()->route('home')->with('error','El usuario no existe, por favor comuniques con el desarrollador');
            }
            
        }else{
            if($usuario->status==1){
                session(['access_token' => $user->token]);
                return redirect()->route('login');
            }
        }
        
    }

    public function logout(Request $request)
    {
        // Desautenticar al usuario
        auth()->logout();

        // Invalidar la sesión
        $request->session()->invalidate();

        // Regenerar el token de sesión para prevenir ataques CSRF
        $request->session()->regenerateToken();

        // Redirigir al usuario a la página de cierre de sesión de Microsoft
        return redirect('https://login.microsoftonline.com/common/oauth2/v2.0/logout?post_logout_redirect_uri=' . urlencode(route('post-logout')));
    }


    public  function postLogout()
    {
        return redirect()->route('home')->with('success', 'Has cerrado sesión correctamente');
    }
}
