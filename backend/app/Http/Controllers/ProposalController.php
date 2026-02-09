<?php

namespace App\Http\Controllers;

use App\Models\ProposalChoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProposalController extends Controller
{
    /**
     * 
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeChoice(Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'choice' => 'required|in:yes,no'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid choice',
                'errors' => $validator->errors()
            ], 422);
        }

        // save choice
        $choice = ProposalChoice::create([
            'choice' => $request->choice,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Choice recorded successfully',
            'data' => [
                'choice' => $choice->choice,
                'timestamp' => $choice->created_at
            ]
        ], 201);
    }

    /**
     *
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChoices()
    {
        $choices = ProposalChoice::latest()->get();
        
        return response()->json([
            'success' => true,
            'data' => $choices
        ]);
    }
}