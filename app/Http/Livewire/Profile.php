<?php

namespace App\Http\Livewire;

use App\Models\Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class Profile extends Component
{
    use WithFileUploads;

    public $currentpwd, $newpwd, $photo;

    public function render()
    {
        return view('livewire.profile.component')->layout('layouts.theme.app');
    }

    public function saveProfileInfo()
    {


        // limpiar mensajes de validación previos
        $this->resetValidation();


        // validar el password actual ingresado contra el del usuario
        if (!Hash::check($this->currentpwd, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'currentpwd' => ['Password actual incorrecto'],
            ]);
        }

        // validaciones nuev password (puedes adicionar cambiar name, email && profile)
        $rules = [
            'newpwd' => 'required|min:3|max:255'
        ];

        $messages = [
            'newpwd.required' => 'Ingresa el nuevo password',
            'newpwd.min' => 'Debe tener al menos 3 caracteres',
            'newpwd.max' => 'Debe tener máximo 3 caracteres',
        ];

        $this->validate($rules, $messages);


        // guardamos los cambios
        $user = Auth()->user();
        $user->password = bcrypt($this->newpwd);
        $user->save();

        // user photo
        if (!empty($this->photo)) {
            // delete prev image in drive
            $tempImg = $user->image->file;
            if ($tempImg != null && file_exists('storage/avatars/' . $tempImg)) {
                unlink('storage/avatars/' . $tempImg);
            }
            // delete relationship image from db
            $user->image()->delete();

            // generate random file name
            $customFileName = uniqid() . '_.' . $this->photo->extension();
            $this->photo->storeAs('public/avatars', $customFileName);

            // save image record
            $img = Image::create([
                'model_id' => $user->id,
                'model_type' => 'App\Models\User',
                'file' => $customFileName
            ]);

            // save relationship
            $user->image()->save($img);
        }


        // feedback al front
        $this->dispatchBrowserEvent('noty', ['msg' => 'Información actualizada', 'type' => 'success']);

        // reset properties to definition values
        $this->reset('newpwd', 'currentpwd');


        // log out user
        Auth::logout();
        return redirect('/login');
    }
}
