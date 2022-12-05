<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SegToken;
use App\Models\SegFirma;
use Facades\App\Classes\Crypto;
use Facades\App\Classes\Miscellany;
use Illuminate\Support\Facades\Auth;
use App\Mail\TokenEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class TokenController extends Controller
{
    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 31;
    } 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('crea');//lee, crea, edita, elimina

        //Genera el token privado
        $permitted_chars_public = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ#$*/&#!?';
        $TOKEN_private = substr(str_shuffle($permitted_chars_public), 0, 10);
        //Genera el token Publico
        $permitted_chars_public = '0123456789ABCDEFGHIJKLMNOPQRSTVWXYZ#$*/';
        $TOKEN_public = substr(str_shuffle($permitted_chars_public), 0, 7);

        //Carga datos del usuario
        $usuario = User::find($request->user_id);

        //Guarda token en la tabla
        $token = new SegToken;
            $token->user_id = $request->user_id;
            $token->token_private = Crypto::set_encrypt_64($TOKEN_private); 
            $token->token_public = Crypto::set_encrypt_64($TOKEN_public);
        $token->save();
        
        //Envia email al usuario
        Mail::to($usuario->email)->send(new TokenEmail($TOKEN_public, $usuario));

        return redirect()->route('gestion-usuarios.index')
                        ->with('info', 'TOKEN creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('elimina');//lee, crea, edita, elimina

        //ATENCION, el ID que llega NO es el del registro del token, sino el de ID de Usuario.
        $token = SegToken::where('user_id', $id)->first();
        $token->delete();

        //CARGA dato en la tabla LOGEAR
        $message = 'Usuario='. Auth::id() .' Token ID= '. $token->id;
        Miscellany::store_log("TOKEN", "ELIMINA", $message);

        return redirect()->route('gestion-usuarios.index')
                        ->with('info', 'TOKEN eliminado Correctamente');
    }
}
