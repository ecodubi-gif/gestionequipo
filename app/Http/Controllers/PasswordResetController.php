<?php

namespace App\Http\Controllers;

use App\Http\Requests\OlvidePasswordRequest;
use App\Http\Requests\RestablecerPasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    public function enviarCodigo(OlvidePasswordRequest $request)
    {
        $email = $request->validated('email');
        $user = User::where('email', $email)->first();

        if ($user) {
            $codigo = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            DB::table('password_reset_codes')->where('email', $email)->delete();
            DB::table('password_reset_codes')->insert([
                'email' => $email,
                'codigo' => $codigo,
                'expira_en' => now()->addMinutes(15),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Mail::raw(
                "Tu código para restablecer la contraseña es: {$codigo}\n\nCaduca en 15 minutos. Si no lo has pedido tú, ignora este correo.",
                function ($message) use ($email) {
                    $message->to($email)->subject('Código para restablecer tu contraseña');
                }
            );
        }

        return response()->json(['message' => 'Si ese email está registrado, te hemos enviado un código']);
    }

    public function restablecer(RestablecerPasswordRequest $request)
    {
        $datos = $request->validated();

        $registro = DB::table('password_reset_codes')
            ->where('email', $datos['email'])
            ->where('codigo', $datos['codigo'])
            ->where('expira_en', '>', now())
            ->first();

        if (! $registro) {
            return response()->json(['message' => 'Código incorrecto o caducado'], 422);
        }

        $user = User::where('email', $datos['email'])->firstOrFail();
        $user->update([
            'password' => bcrypt($datos['password_nueva']),
            'password_actualizada' => true,
        ]);

        DB::table('password_reset_codes')->where('email', $datos['email'])->delete();

        return response()->json(['message' => 'Contraseña restablecida correctamente']);
    }
}
