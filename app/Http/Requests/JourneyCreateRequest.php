<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JourneyCreateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'headline' => ['bail', 'required', 'string'],
            'start_day' => 'required|date|after:now',
            'last_day' => 'required|date|after:start_date',
            'description' => ['required'],
            'journey_charg' => ['required', 'numeric', 'min:0'],
            'max_number' => ['required', 'numeric', 'min:5'],
            'points' => 'required|array|min:1',
            'points.*.point_description' => 'required|string',
            'points.*.latitude' => 'required| numeric',
            'points.*.longitude' => 'required| numeric',
            'points.*.image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,JPG|max:2048'
        ];
    }

    public function messages() : array
    {
        return [
            'headline.required' => 'The headline is required.',
            'headline.string' => 'The headline must be a string.',

            'start_day.required' => 'The start day is required.',
            'start_day.date' => 'The start day must be a valid date.',
            'start_day.after' => 'The start day must be in the future.',
            'last_day.required' => 'The last day is required.',
            'last_day.date' => 'The last day must be a valid date.',
            'last_day.after' => 'The last day must be after the start day.',

            'description.required' => 'The description is required.',

            'journey_charg.required' => 'The journey charge is required.',
            'journey_charg.numeric' => 'The journey charge must be a number.',
            'journey_charg.min' => 'The journey charge must be at least 0.',

            'max_number.required' => 'The maximum number of participants is required.',
            'max_number.numeric' => 'The maximum number of participants must be a number.',
            'max_number.min' => 'The maximum number of participants must be at least 5.',

            'points.required' => 'You should at least add one point.',
            'points.array' => 'The points field must be an array.',
            'points.min' => 'You must provide at least one point.',

            'points.*.point_description.required' => 'Each point must have a description.',
            'points.*.point_description.string' => 'Each point description must be a string.',

            'points.*.latitude.required' => 'Each point must have a latitude.',
            'points.*.latitude.numeric' => 'Each point latitude must be a number.',

            'points.*.longitude.required' => 'Each point must have a longitude.',
            'points.*.longitude.numeric' => 'Each point longitude must be a number.',

            'points.*.image.mimes' => 'Each point image must be a file of type: jpeg, png, jpg, gif, svg.',
            'points.*.image.max' => 'Each point image must not exceed 2048 kilobytes.',
        ];

    }
}
