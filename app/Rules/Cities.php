<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Province;

class Cities implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $province_id = '';
    protected $district_id = '';
    protected $ward_id = '';
    public function __construct($request)
    {
        $this->province_id = $request->province_id;
        $this->district_id = $request->district_id;
        $this->ward_id = $request->ward_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $province = Province::find($this->province_id);
        if (!$province) {
            return false;
        }
        $district = $province->districts()->find($this->district_id);
        if (!$district) {
            return false;
        }
        $wards = $district->wards()->find($this->ward_id);
        if (!$wards) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Giá trị không hợp lệ';
    }
}
