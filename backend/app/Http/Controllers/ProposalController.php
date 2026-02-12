<?php

namespace App\Http\Controllers;

use App\Models\ProposalChoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProposalController extends Controller
{
    /**
     * Store (YES or NO)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeChoice(Request $request)
    {
        // Validate incoming data
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

        // Save choice to database
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
     * Store restaurant reservation confirmation
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeReservation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'restaurant' => 'required|string',
            'location' => 'required|string',
            'signature' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid reservation data',
                'errors' => $validator->errors()
            ], 422);
        }

        // Here you could save to database or send notification
        // For now, just return success
        return response()->json([
            'success' => true,
            'message' => 'Reservation confirmed!',
            'data' => [
                'restaurant' => $request->restaurant,
                'location' => $request->location,
                'timestamp' => now()
            ]
        ], 201);
    }

    /**
     * Get all choices (for proposer to view)
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