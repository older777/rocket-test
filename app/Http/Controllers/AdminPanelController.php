<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use function Illuminate\Database\Eloquent\Casts\get;
use App\Models\Category;

class AdminPanelController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Auth $user)
    {
        if (! $user::check()) {
            return back()->withErrors([
                'msg' => 'Необходима авторизация'
            ]);
        }
        $post = Post::when('name', function ($q) use ($user) {
            if ($user::user()->role != 1) {
                $q->where('user', $user::user()->id);
            }
        })->with('userModel')
            ->with('categoryModel')
            ->get();
        $category = Category::get()->pluck('name', 'id');
        return view('adminpanel', [
            'user' => $user::user(),
            'post' => $post,
            'category' => $category
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addUser(Request $request, Auth $user)
    {
        if (! $user::check() && $user::user()->role != 1) {
            return back()->withErrors([
                'msg' => 'Необходима авторизация, недостаточно прав'
            ]);
        }
        $newUser = $request->validate([
            'name' => [
                'required'
            ],
            'password' => [
                'required'
            ],
            'email' => [
                'required',
                'email:strict'
            ]
        ]);
        if (User::query()->where('name', $newUser['name'])
            ->get()
            ->count()) {
            return response()->json([
                'msg' => 'такой работник уже сушествует'
            ]);
        }
        User::query()->create([
            'name' => $newUser['name'],
            'password' => Hash::make($newUser['password']),
            'email' => $newUser['email'],
            'role' => 2
        ]);
        return response()->json([
            'msg' => 'работник добавлен',
            'status' => 'ok'
        ]);
    }

    public function addPost(Request $request, Auth $user)
    {
        if (! $user::check()) {
            return back()->withErrors([
                'msg' => 'Необходима авторизация'
            ]);
        }
        $newPost = $request->validate([
            'name' => [
                'required'
            ],
            'img' => [
                'required'
            ],
            'category' => [
                'required',
                'integer'
            ]
        ]);
        if (Post::query()->where('name', $newPost['name'])
            ->get()
            ->count()) {
            return response()->json([
                'msg' => 'такая запись уже сушествует'
            ]);
        }
        Post::query()->create([
            'name' => $newPost['name'],
            'img' => base64_encode(file_get_contents($newPost['img'])),
            'category' => $newPost['category'],
            'user' => $user::user()->id
        ]);
        return response()->json([
            'msg' => 'запись добавлена',
            'status' => 'ok'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Auth $user)
    {
        if (! $user::check() && $user::user()->role != 1) {
            return response()->json([
                'msg' => 'Необходима авторизация'
            ], 400);
        } else {
            return response()->json([
                User::query()->get()
                    ->all()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
