<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RatingDate;
use Throwable;

class RatingsDatesController extends Controller
{
    public function get(Request $request) {
        try {
            $id = $request->get('id', NULL);
            $date = $request->get('date', NULL);

            $ratings = new RatingDate();
            $ratings->id = $id;
            $ratings->date = $date;

        } catch (Throwable $error) {
            return response()->json([
                'status' => 'success',
                'message' => 'An internal error ocurred.'
            ]);
        }
    }

    public function create(Request $request) {
        try {

        } catch (Throwable $error) {
            return response()->json([
                'status' => 'success',
                'message' => 'An internal error ocurred.'
            ]);
        }
    }

    public function update(Request $request) {
        try {

        } catch (Throwable $error) {
            return response()->json([
                'status' => 'success',
                'message' => 'An internal error ocurred.'
            ]);
        }
    }

    public function delete(Request $request) {
        try {

        } catch (Throwable $error) {
            return response()->json([
                'status' => 'success',
                'message' => 'An internal error ocurred.'
            ]);
        }
    }
}
