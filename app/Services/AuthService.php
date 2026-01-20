<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Traits\HelperTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AuthService
{
    use HelperTrait;

    public function index(Request $request): Collection|LengthAwarePaginator|array
    {
        $query = User::query();

        //condition data 
        $this->applyActive($query, $request);

        // Select specific columns
        $query->select(['*']);

        // Sorting
        $this->applySorting($query, $request);

        // Searching
        $searchKeys = ['name']; // Define the fields you want to search by
        $this->applySearch($query, $request->input('search'), $searchKeys);

        // Pagination
        return $this->paginateOrGet($query, $request);
    }

    public function store(Request $request)
    {
        $data = $this->prepareAuthData($request);

        return User::create($data);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if (!Auth::user()->is_active) {
            throw ValidationException::withMessages([
                'email' => ['Your account is not active. Please contact support.'],
            ]);
        }

        $user = $request->user();

        return [
            'token' => $user->createLongToken('api-token')->plainTextToken,
            'user' => $user,
        ];
    }

    public function register(Request $request)
    {
        // Check if user already exists
        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            throw new \Exception('This email is already registered');
        }

        $data = $this->prepareAuthData($request);
        $user = User::create($data);
        return $user;
    }

    private function prepareAuthData(Request $request, bool $isNew = true): array
    {
        // Get the fillable fields from the model
        $fillable = (new User())->getFillable();

        // Extract relevant fields from the request dynamically
        $data = $request->only($fillable);

        // Handle file uploads
        //$data['thumbnail'] = $this->ftpFileUpload($request, 'thumbnail', 'auth');
        $data['profile_picture'] = $this->ftpFileUpload($request, 'profile_picture', 'profile');

        // Add created_by and created_at fields for new records
        if ($isNew) {
            $data['created_by'] = Auth::id();
            $data['created_at'] = now();
        }

        return $data;
    }

    public function show(int $id): User
    {
        return User::where('id', $id)->with('department', 'designation')->first();
    }

    public function update(Request $request, int $id)
    {
        $auth = User::findOrFail($id);
        $updateData = $this->prepareAuthData($request, false);
        
         $updateData = array_filter($updateData, function ($value) {
            return !is_null($value);
        });
        $auth->update($updateData);

        return $auth;
    }

    public function destroy(int $id): bool
    {
        $auth = User::findOrFail($id);
        $auth->name .= '_' . Str::random(8);
        $auth->deleted_at = now();

        return $auth->save();
    }
}
