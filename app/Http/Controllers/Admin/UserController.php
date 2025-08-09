<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.admin.users.index');
    }

    public function users(Request $request)
    {
        $pageNumber = ($request->start / $request->length) + 1;
        $pageLength = $request->length;
        $skip = ($pageNumber - 1) * $pageLength;

        $orderColumnIndex = $request->order[0]['column'] ?? '0';
        $orderBy = $request->order[0]['dir'] ?? 'desc';

        $query = User::where('role', '!=', 'admin')->where('status', 'active');

        $search = $request->search['value'] ?? null;
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $orderByName = match ($orderColumnIndex) {
            0 => 'name',
            1 => 'email',
            2 => 'created_at',
            default => 'name'
        };

        $query->orderBy($orderByName, $orderBy);

        $recordTotal = User::where('role', '!=', 'admin')->count();
        $filterRecords = $query->count();

        $users = $query->skip($skip)->take($pageLength)->get();

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $recordTotal,
            'recordsFiltered' => $filterRecords,
            'data' => $users
        ]);
    }

    public function inActiveUser($id)
    {
        $user = User::where('id', $id)->first();

        if(!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ]);
        }

        $user->status = 'inactive';
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User inactive successfully'
        ]);
    }

}
