<?php

namespace App\Http\Requests\Shop;

use App\Helpers\ValidatorHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use App\Enums\Banner\EBannerActionType;

class SaveBannerRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $data = request()->all();
        return [
            'mobileFile' => !empty($data['isEdit']) && !empty($data['mobileEdit']) || 
                empty($data['isEdit']) ? function($attribute, $value, $fail) use ($data) {
                if (empty($data['mobileBannerId'])
                    && (empty($value) || !($value instanceof UploadedFile)) && empty($data['webFile']) && empty($data['mobileFile'])) {
                    $fail(__('validation.custom.pick_required', [
                        'attribute' => __('back/banner.msg.file')
                    ]));
                }
            } : '',
            'webFile' => !empty($data['isEdit']) && !empty($data['webEdit']) || 
                empty($data['isEdit']) ? function($attribute, $value, $fail) use ($data) {
                if (empty($data['webBannerId'])
                    && (empty($value) || !($value instanceof UploadedFile)) && empty($data['webFile']) && empty($data['mobileFile'])) {
                    $fail(__('validation.custom.pick_required', [
                        'attribute' => __('back/banner.msg.file')
                    ]));
                }
            } : '',
            'mobileBlob' => '',
            'webBlob' => '',
            'link' => $data['actionType'] == EBannerActionType::OPEN_WEBSITE ? 'required|url' : '',
            'type' => 'required',
            'webRatio' => 'required',
            'mobileRatio' => 'required',
            'actionType' => '',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [
            'link' => '???????ng d???n',
            'type' => 'Lo???i banner',
            'webRatio' => 'T??? l??? banner web',
            'mobileRatio' => 'T??? l??? banner mobile',
            'mobileFile' => 'Vui l??ng ch???n banner',
            'webFile' => 'Vui l??ng ch???n banner',
        ];
    }
}
