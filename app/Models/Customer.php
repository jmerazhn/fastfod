<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'street', 'number', 'colony', 'city', 'state', 'zipcode', 'country', 'notes'];

    // relationships

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // validations
    public static function rules($id)
    {
        if ($id <= 0) {
            return [
                'name' => 'required|min:3|max:50|string|unique:users',
                'phone' => 'nullable|max:10',
                'street' => 'nullable|max:100',
                'number' => 'nullable|max:20',
                'colony' => 'nullable|max:60',
                'city' => 'nullable|max:65',
                'state' => 'nullable|max:70',
                'zipcode' => 'nullable|max:5|min:5',
                'country' => 'nullable|max:50',
                'notes' => 'nullable|max:1000'
            ];
        } else {
            return [
                'name' => "required|min:3|max:50|string|unique:users,name,{$id}",
                'phone' => 'nullable|max:10',
                'street' => 'nullable|max:100',
                'number' => 'nullable|max:20',
                'colony' => 'nullable|max:60',
                'city' => 'nullable|max:65',
                'state' => 'nullable|max:70',
                'zipcode' => 'nullable|max:5|min:5',
                'country' => 'nullable|max:50',
                'notes' => 'nullable|max:1000'
            ];
        }
    }

    public static $messages = [
        'name.required' => 'Nombre de usuario requerido',
        'name.min' => 'El nombre debe tener al menos 3 caracteres',
        'name.max' => 'El nombre debe tener máximo 255 caracteres',
        'name.unique' => 'El nombre ya existe en sistema',
        'phone.max' => 'El teléfono debe tener máximo 10 dígitos',
        'street.required' => 'La calle es requerida',
        'street.max' => 'La calle debe tener máximo 100 caracteres',
        'number.required' => 'El número de casa es requerido',
        'number.max' => 'El número debe tener máximo 20 caracteres',
        'colony.required' => 'La colonia es un campo requerido',
        'colony.max' => 'La colonia debe tener máximo 60 caracteres',
        'city.required' => 'La ciudad es requerida',
        'city.max' => 'La ciudad debe tener máximo 65 caracteres',
        'state.required' => 'El estado es requerido',
        'state.max' => 'El estado debe tener máximo 70 caracteres',
        'zipcode.required' => 'El código postal es requerido',
        'zipcode.min' => 'El código postal debe tener mínimo 5 caracteres',
        'zipcode.max' => 'El código postal debe tener máximo 5 caracteres',
        'notes.max' => 'Las observaciones deben ser máximo 1000 caracteres'
    ];



    protected $appends = ['check_address'];

    public function getCheckAddressAttribute()
    {
        $cont = 0;
        if (!isset($this->phone) || trim($this->phone) === '') $cont++;
        if (!isset($this->street) || trim($this->street) === '') $cont++;
        if (!isset($this->number) || trim($this->number) === '') $cont++;
        if (!isset($this->colony) || trim($this->colony) === '') $cont++;
        if (!isset($this->city) || trim($this->city) === '') $cont++;
        if (!isset($this->state) || trim($this->state) === '') $cont++;
        if (!isset($this->zipcode) || trim($this->zipcode) === '') $cont++;
        if (!isset($this->country) || trim($this->country) === '') $cont++;

        return $cont;
    }
}
