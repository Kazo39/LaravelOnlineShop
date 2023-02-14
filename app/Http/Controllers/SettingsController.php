<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class SettingsController extends Controller
{
    public function edit(Request $request){
        return view('settings.edit', ['message' => $request->message]);
    }

    public function update(UpdatePasswordRequest $request){
        $user = auth()->user();

        if(User::query()->where('id', $user->id)->update([
            'password' => Hash::make($request->password)
        ])) {
            return redirect()->route('settings.edit', ['message' => 'correct']);
        }else{
            return redirect()->route('settings.edit', ['message' => 'error']);
        }
    }
}
