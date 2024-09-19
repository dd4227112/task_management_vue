<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{

    public function index()
    {
        $members = Member::with('memberTask')->paginate(10);

        $code = 200;
        $data = [];
        if (!$members->isEmpty()) {
            $data = $members;
        } else {
            $message = 'Member Not Found';
        }
        return response()->json(['data' => $data], $code);
    }
    public function create(Request $request)
    {

        $validatedData = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'min:3'],
                'email' => ['required', 'email'],
            ]
        );
        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(), 422);
        }
        $data = [
            'name' => $request->name,
            'email' => $request->email
        ];
        if (Member::create($data)) {
            $code = 200;
            $message = 'Member created successfully';
        } else {
            $code = 500;
            $message = 'Failed to create new Member';
        }
        return response()->json(['message' => $message], $code);
    }
    public function update(Request $request, $id)
    {

        $validatedData = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'min:3'],
                'email' => ['required', 'email'],
            ]
        );
        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(), 422);
        }
        $data = [
            'name' => $request->name,
            'email' => $request->email
        ];
        $member  = Member::find($id);
        if (!empty($member)) {
            $member->update($data);
            $code = 200;
            $message = 'Member updated successfully';
        } else {
            $code = 404;
            $message = 'Can\'t update. Member not found';
        }
        return response()->json(['message' => $message], $code);
    }
}
