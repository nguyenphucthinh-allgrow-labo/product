<?php


namespace App\Helpers;


use App\Enums\EDateFormat;
use App\Rules\ValidPhoneNumber;
//use App\Rules\ValidVietnamPBXNumber;
use App\Rules\ValidVietnamPhoneNumber;
use Illuminate\Support\Arr;

class ValidatorHelper {
    private static function requireRule($option) {
        $required = Arr::get($option, 'required', false);
        if (!$required) {
        	$required = in_array('required', $option);
		}
        $requiredIf = Arr::get($option, 'required_if', null);
        $requiredWith = (array)Arr::get($option, 'required_with', []);
        $requiredWithout = (array)Arr::get($option, 'required_without', []);
        $requiredWithoutAll = (array)Arr::get($option, 'required_without_all', []);
        if (!$required && empty($requiredWith) && empty($requiredWithOut)) {
        	return ['nullable'];
		}

        $result = [];
        if (!empty($requiredIf)) {
        	$result[] = "required_if:$requiredIf";
		}
        if (!empty($requiredWith)) {
			$result[] = 'required_with:' . implode(',', $requiredWith);
		}
        if (!empty($requiredWithout)) {
			$result[] = 'required_without:' . implode(',', $requiredWithout);
		}
		if (!empty($requiredWithoutAll)) {
			$result[] = 'required_without_all:' . implode(',', $requiredWithoutAll);
		}
		if (!empty($result)) {
			return $result;
		}

		return ['required'];
    }

    public static function nameRule(array $option = []) {
        $maxLength = Arr::get($option, 'max', 60);
        return [
            'bail',
            ...self::requireRule($option),
            "max:$maxLength",
            function($attribute,$value, $fail) {
/*                $regex = '/[\'\\\^£$%&*()}{@#~?>!<>,|\[\]\/\"\.=_+¬-]/';*/
                $regex = '/[^A-Za-z0-9ÁÀẠÃẢĂẮẰẶẴẲÂẤẦẬẪẨĐEÉÈẸẼẺÊẾỀỆỄỂÍÌỊĨỈÓÒỌÕỎÔỐỒỘỖỔƠỚỜỢỠỞÚÙỤŨỦƯỨỪỰỮỬÝỲỴỸỶáàạãảắằặẵẳấầậẫẩéèẹẽẻếềệễểíìịĩỉóòọõỏốồộỗổớờợỡởúùụũủứừựữửýỳỵỹỷ ]/';
                if (preg_match($regex, $value)) {
                    $fail(__('validation.custom.name'));
                }
            },
        ];

    }

    public static function affiliateCodeRule(array $option = []) {
        return [
            'bail',
            ...self::requireRule($option),
            function($attribute,$value, $fail) {
                if(strlen($value) !== 7) {
                    $fail(__('validation.custom.affiliate_code'));
                }
            },
        ];

    }
    public static function emailRule(array $option = []) {
        $maxLength = Arr::get($option, 'max', 60);
        return [
            'bail',
            ...self::requireRule($option),
            'email:rfc,dns',
            "max:$maxLength",
        ];
    }

    public static function dateOfBirthRule(array $option = []) {
        return [
            'bail',
            ...self::requireRule($option),
            'date_format:' . Arr::get($option, 'format', EDateFormat::STANDARD_DATE_FORMAT),
            'before_or_equal:' . now()->timezone(config('app.timezone'))
                ->format(EDateFormat::STANDARD_DATE_FORMAT),
        ];
    }

    public static function dateRule(array $option = []) {
        return [
            'bail',
            ...self::requireRule($option),
            'date_format:' . Arr::get($option, 'format', EDateFormat::STANDARD_DATE_FORMAT),
        ];
    }

    public static function standardDateRule(array $option = []) {
        return self::dateOfBirthRule($option);
    }

    public static function phoneRule(array $option = []) {
        return [
            'bail',
            ...self::requireRule($option),
            new ValidPhoneNumber(),
        ];
    }

    public static function numberRule(array $option = []) {
        $rules = [
            'bail',
            ...self::requireRule($option),
            'numeric',
        ];

        $min = Arr::get($option, 'min');
        if (!is_null($min)) {
            $rules[] = "min:$min";
        }

        $max = Arr::get($option, 'max');
        if (!is_null($max)) {
            $rules[] = "max:$max";
        }
        return $rules;
    }

    public static function imageRule(array $option = []) {
        return [
            'bail',
            ...self::requireRule($option),
            'file',
            'mimes:jpeg,bmp,png',
            'dimensions:min_width=100,min_height=100',
        ];
    }

    public static function descriptionRule(array $option = []) {
        return [
            'bail',
            ...self::requireRule($option),
        ];
    }

    public static function timeRule(array $option = []) {
        return [
            'bail',
            ...self::requireRule($option),
            'date_format:' . Arr::get($option, 'format', 'H:i'),
        ];
    }

    public static function booleanRule(array $option = []) {
        return [
            'bail',
            ...self::requireRule($option),
            'boolean'
        ];
    }

    public static function arrayRule(array $option = []) {
        $result = [
            'bail',
            ...self::requireRule($option),
            'array'
        ];

		$maxLength = Arr::get($option, 'max');
        if ($maxLength) {
			$result[] = "max:$maxLength";
		}

		$minLength = Arr::get($option, 'min');
		if ($minLength) {
			$result[] = "min:$minLength";
		}

		return $result;
    }

    public static function commissionContentRule(array $option = []) {
        $maxLength = Arr::get($option, 'max', 512);
        return [
            'bail',
            ...self::requireRule($option),
            "max:$maxLength"
        ];
    }

    public static function address(array $option = []) {
        $maxLength = Arr::get($option, 'max', 60);
        return [
            'bail',
            ...self::requireRule($option),
            "max:$maxLength",
        ];
    }

    public static function codeRule(array $option = []) {
        $minLength = Arr::get($option, 'min', 5);
        return [
            'bail',
            ...self::requireRule($option),
            "min:$minLength",
        ];
    }

    public static function passwordRule(array $option = []) {
        $maxLength = Arr::get($option, 'max', 32);
        $minLength = Arr::get($option, 'min', 6);
        $result = [
            'bail',
            self::requireRule($option),
            "max:$maxLength",
            "min:$minLength",
            "string",
            function($attribute, $value, $fail) {
                $regex = '/.*[A-Z].*/';
                if (!preg_match($regex, $value)) {
                    $fail(__('validation.custom.password'));
                }
            },
        ];
        if (Arr::get($option, 'confirmed', false)) {
        	$result[] = 'confirmed';
		}
        return $result;
    }
}
