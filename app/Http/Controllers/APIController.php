<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use \App\Models\Sector;
use \App\Models\Budget;
use \App\Models\Entry;
use DB;

class APIController extends Controller
{
    public function checkUser($email, $password)
    {
        $user = User::where('email', $email)->first();
        if(isset($user->id)){
            if(\Hash::check($password, $user->password)){
                return [
                    'success' => true,
                    'user' => $user
                ];
            }

            return [
                'success' => false,
                'message' => "Password is Incorrect!"
            ];
        }

        return [
            'success' => false,
            'message' => "User not Found!"
        ];
    }

    public function registration(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name'           => 'required',
            'email'      => 'required|unique:users',
            'password'      => 'required|min:6',
        ]);

        if($validator->passes()){
            $registration = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return response()->json("Congratualtions! Your Ragistration is successful.");
        }else{
            return response()->json('Code: 400, Errors: '.implode(', ', $validator->errors()->all()));
        }
    }

    public function sectors(Request $request)
    {
        $checkUser = $this->checkUser($request->email, $request->password);
        if(!$checkUser['success']){
            return response()->json($checkUser['message']);
        }

        return response()->json(Sector::where('user_id', $checkUser['user']->id)->get());
    }

    public function createSector(Request $request)
    {
        $checkUser = $this->checkUser($request->email, $request->password);
        if(!$checkUser['success']){
            return response()->json($checkUser['message']);
        }

        $validator = \Validator::make($request->all(), [
            'name'           => 'required',
            'type'           => 'required',
        ]);

        if($validator->passes()){
            Sector::updateOrCreate([
                'user_id' => $checkUser['user']->id,
                'name' => $request->name,
                'type' => $request->type,
            ], []);

            return response()->json("Congratualtions! Sector Saved successfully.");
        }else{
            return response()->json('Code: 400, Errors: '.implode(', ', $validator->errors()->all()));
        }
    }

    public function updateSector(Request $request)
    {
        $checkUser = $this->checkUser($request->email, $request->password);
        if(!$checkUser['success']){
            return response()->json($checkUser['message']);
        }

        $validator = \Validator::make($request->all(), [
            'id'           => 'required',
            'name'           => 'required',
            'type'           => 'required',
        ]);

        if($validator->passes()){
            Sector::updateOrCreate([
                'id' => $request->id,
                'user_id' => $checkUser['user']->id
            ],[
                'name' => $request->name,
                'type' => $request->type,
            ]);

            return response()->json("Congratualtions! Sector Updated successfully.");
        }else{
            return response()->json('Code: 400, Errors: '.implode(', ', $validator->errors()->all()));
        }
    }

    public function deleteSector(Request $request)
    {
        $checkUser = $this->checkUser($request->email, $request->password);
        if(!$checkUser['success']){
            return response()->json($checkUser['message']);
        }

        $validator = \Validator::make($request->all(), [
            'id'           => 'required',
        ]);

        if($validator->passes()){
            Sector::where([
                'id' => $request->id,
                'user_id' => $checkUser['user']->id
            ])->delete();

            return response()->json("Congratualtions! Sector Deleted successfully.");
        }else{
            return response()->json('Code: 400, Errors: '.implode(', ', $validator->errors()->all()));
        }
    }

    public function budgets(Request $request)
    {
        $checkUser = $this->checkUser($request->email, $request->password);
        if(!$checkUser['success']){
            return response()->json($checkUser['message']);
        }

        $budgets = Budget::with(['sector'])
        ->whereHas('sector.user', function($query) use($checkUser){
            return $query->where('user_id', $checkUser['user']->id);
        })
        ->when(isset($request->sector_id), function($query) use($request){
            return $query->where('sector_id', $request->sector_id);
        })
        ->when(isset($request->year), function($query) use($request){
            return $query->where('year', $request->year);
        })
        ->when(isset($request->month), function($query) use($request){
            return $query->where('month', $request->month);
        })
        ->get();

        return response()->json($budgets);
    }

    public function createBudget(Request $request)
    {
        $checkUser = $this->checkUser($request->email, $request->password);
        if(!$checkUser['success']){
            return response()->json($checkUser['message']);
        }

        $validator = \Validator::make($request->all(), [
            'sector_id' => 'required',
            'year' => 'required',
            'month' => 'required',
            'budget' => 'required',
            'remarks' => 'required',
        ]);

        if($validator->passes()){
            Budget::create($request->all());

            return response()->json("Congratualtions! Budget Created successfully.");
        }else{
            return response()->json('Code: 400, Errors: '.implode(', ', $validator->errors()->all()));
        }
    }

    public function updateBudget(Request $request)
    {
        $checkUser = $this->checkUser($request->email, $request->password);
        if(!$checkUser['success']){
            return response()->json($checkUser['message']);
        }

        $validator = \Validator::make($request->all(), [
            'id' => 'required',
            'sector_id' => 'required',
            'year' => 'required',
            'month' => 'required',
            'budget' => 'required',
            'remarks' => 'required',
        ]);

        if($validator->passes()){
            $budget = Budget::where('id', $request->id)->whereHas('sector.user', function($query) use($checkUser){
                return $query->where('user_id', $checkUser['user']->id);
            })->first();

            $budget->fill($request->all())->save();

            return response()->json("Congratualtions! Budget Updated successfully.");
        }else{
            return response()->json('Code: 400, Errors: '.implode(', ', $validator->errors()->all()));
        }
    }

    public function deleteBudget(Request $request)
    {
        $checkUser = $this->checkUser($request->email, $request->password);
        if(!$checkUser['success']){
            return response()->json($checkUser['message']);
        }

        $validator = \Validator::make($request->all(), [
            'id'           => 'required',
        ]);

        if($validator->passes()){
            Budget::where('id', $request->id)->whereHas('sector.user', function($query) use($checkUser){
                return $query->where('user_id', $checkUser['user']->id);
            })->delete();

            return response()->json("Congratualtions! Sector Deleted successfully.");
        }else{
            return response()->json('Code: 400, Errors: '.implode(', ', $validator->errors()->all()));
        }
    }

    public function entries(Request $request)
    {
        $checkUser = $this->checkUser($request->email, $request->password);
        if(!$checkUser['success']){
            return response()->json($checkUser['message']);
        }

        $entries = Entry::with(['sector'])
        ->whereHas('sector.user', function($query) use($checkUser){
            return $query->where('user_id', $checkUser['user']->id);
        })
        ->when(isset($request->sector_id), function($query) use($request){
            return $query->where('sector_id', $request->sector_id);
        })
        ->when(isset($request->from), function($query) use($request){
            return $query->where('date', '>=', $request->from);
        })
        ->when(isset($request->to), function($query) use($request){
            return $query->where('date', '<=', $request->to);
        })
        ->get();

        return response()->json($entries);
    }

    public function createEntry(Request $request)
    {
        $checkUser = $this->checkUser($request->email, $request->password);
        if(!$checkUser['success']){
            return response()->json($checkUser['message']);
        }

        $validator = \Validator::make($request->all(), [
            'sector_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'title' => 'required',
            'description' => 'required',
            'amount' => 'required',
        ]);

        if($validator->passes()){
            Entry::create($request->all());

            return response()->json("Congratualtions! Entry Created successfully.");
        }else{
            return response()->json('Code: 400, Errors: '.implode(', ', $validator->errors()->all()));
        }
    }

    public function updateEntry(Request $request)
    {
        $checkUser = $this->checkUser($request->email, $request->password);
        if(!$checkUser['success']){
            return response()->json($checkUser['message']);
        }

        $validator = \Validator::make($request->all(), [
            'id' => 'required',
            'sector_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'title' => 'required',
            'description' => 'required',
            'amount' => 'required',
        ]);

        if($validator->passes()){
            $entry = Entry::where('id', $request->id)->whereHas('sector.user', function($query) use($checkUser){
                return $query->where('user_id', $checkUser['user']->id);
            })->first();

            $entry->fill($request->all())->save();

            return response()->json("Congratualtions! Entry Updated successfully.");
        }else{
            return response()->json('Code: 400, Errors: '.implode(', ', $validator->errors()->all()));
        }
    }

    public function deleteEntry(Request $request)
    {
        $checkUser = $this->checkUser($request->email, $request->password);
        if(!$checkUser['success']){
            return response()->json($checkUser['message']);
        }

        $validator = \Validator::make($request->all(), [
            'id'           => 'required',
        ]);

        if($validator->passes()){
            Entry::where('id', $request->id)->whereHas('sector.user', function($query) use($checkUser){
                return $query->where('user_id', $checkUser['user']->id);
            })->delete();

            return response()->json("Congratualtions! Entry Deleted successfully.");
        }else{
            return response()->json('Code: 400, Errors: '.implode(', ', $validator->errors()->all()));
        }
    }
}
