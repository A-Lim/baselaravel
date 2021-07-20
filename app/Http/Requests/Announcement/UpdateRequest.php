<?php

namespace App\Http\Requests\Announcement;

use App\Http\Requests\CustomFormRequest;

use App\Announcement;

class UpdateRequest extends CustomFormRequest {

    public function __construct() {
        parent::__construct();
    }
    
    public function authorize() {
        return true;
    }

    protected function prepareForValidation()   {
        $this->merge([
            'has_content' => filter_var($this->has_content, FILTER_VALIDATE_BOOLEAN),
            'push_notification' => filter_var($this->push_notification, FILTER_VALIDATE_BOOLEAN),
        ]);
    }

    public function rules() {
        return [
            'action' => 'required|in:'.implode(',', Announcement::ACTIONS),
            'title' => 'required|string',
            'description' => 'required|string',
            'audience' => 'required|in:'.implode(',', Announcement::AUDIENCES),
            'audience_data_id' => 'required_unless:audience,'.Announcement::AUDIENCE_ALL,
            'push_notification' => 'nullable|boolean',
            'has_content' => 'required|boolean',
            'content' => 'required_if:has_content,true',
            'scheduled_publish_date' => 'nullable|after:today|date_format:Y-m-d\TH:i:s.v\Z'
        ];
    }
}
