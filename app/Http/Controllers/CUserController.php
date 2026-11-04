<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\c_user;
use Illuminate\Http\Request;

class CUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = c_user::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $request->status === 'banned'
                ? $query->where('is_banned', true)
                : $query->where('is_banned', false);
        }

        $index = 10;
        if ($request->filled('index') && $request->index >= 10 && $request->index <= 20) {
            $index = $request->index;
        }

        $users = $query->latest()->paginate($index)->withQueryString();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $c_user1 = c_user::create($request->validated());

        return redirect()->route('users.index')->with('success', 'User ' . $c_user1->name . ' created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = c_user::find($id);
        if (!$user) {
            return response()->view('users.err404', [], 404);
        }
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(c_user $c_user)
    {
        return view('users.edit', compact('c_user'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UserRequest $request, c_user $c_user)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $c_user->update($data);

        return redirect()->route('users.index')->with('success', 'User ' . $c_user->name . ' updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = c_user::findOrFail($id);
            $userName = $user->name;
            $user->delete();

            return redirect()->route('users.index')->with('success', 'User "' . $userName . '" deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    /**
     * /show ban form
     * @param c_user $c_user
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showBanForm(c_user $c_user)
    {
        if ($c_user->is_banned) {
            return redirect()->route('users.index');
        }

        return view('users.ban', compact('c_user'));
    }

    /**
     * /to ban user
     * @param Request $request
     * @param c_user $c_user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ban(Request $request, c_user $c_user)
    {
        if ($c_user->is_banned) {
            return redirect()->route('users.index')
                ->with('error', "User {$c_user->name} is already banned.");
        }

        $request->validate([
            'ban_reason' => ['required', 'string', 'max:500'],
        ]);


        $c_user->update([
            'is_banned' => true,
            'ban_reason' => $request->ban_reason,
        ]);

        return redirect()->route('users.index')->with('success', 'User ' . $c_user->name . ' has been banned successfully.');
    }

    /**
     * /to unban user
     * @param c_user $c_user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unban(c_user $c_user)
    {
        if ($c_user->is_banned) {
            return redirect()->route('users.index')
                ->with('error', "User {$c_user->name} is already unbanned.");
        }
        $c_user->update([
            'is_banned' => false,
            'ban_reason' => null,
            'banned_until' => null,
        ]);

        return redirect()->route('users.index')->with('success', 'User ' . $c_user->name . ' has been unbanned successfully.');
    }
}