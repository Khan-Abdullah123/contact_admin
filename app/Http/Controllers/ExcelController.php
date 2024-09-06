<?php

namespace App\Http\Controllers;
class ExcelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getContactHeaders()
    {
        try {
            $headers = ['Name', 'Gender', 'Capacity', 'Email', 'Phone', 'Experties', 'Address','Tag'];
            return response()->json(['success' => true, 'headers' => $headers]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
        }
    }





}
