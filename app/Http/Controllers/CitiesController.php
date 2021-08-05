<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use HoangPhi\VietnamMap\Models\District;
use HoangPhi\VietnamMap\Models\Province;

class CitiesController extends Controller
{
    public function getDistricts($id)
    {
        $Province = Province::findOrFail($id);
        if ($Province) {
            $Districts = $Province->districts()->get(['id', 'name']);
            return response()->json($Districts);
        } else {
            return response()->json([
                'id' => 0,
                'name' => 'Vui lòng lựa chọn'
            ]);
        }
    }
    public function getWards($id)
    {
        $Districts = District::findOrFail($id);
        if ($Districts) {
            $Wards = $Districts->wards()->get(['id', 'name']);
            return response()->json($Wards);
        } else {
            return response()->json([
                'id' => 0,
                'name' => 'Vui lòng lựa chọn'
            ]);
        }
    }
    public function fixnull()
    {
        return response()->json([
            'id' => 0,
            'name' => 'Vui lòng lựa chọn'
        ]);
    }
}
