<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatisticRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust based on your authentication logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'timeFilter' => 'sometimes|string|in:today,month,year,week,custom',
            'startDate' => 'sometimes|date|before_or_equal:endDate',
            'endDate' => 'sometimes|date|after_or_equal:startDate',
            'limit' => 'sometimes|integer|min:1|max:100',
            'page' => 'sometimes|integer|min:1',
            'productType' => 'sometimes|integer|exists:product_types,id',
            'status' => 'sometimes|array',
            'status.*' => 'integer|in:1,2,3,4,5',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'timeFilter.in' => 'Bộ lọc thời gian phải là một trong: today, month, year, week, custom',
            'startDate.date' => 'Ngày bắt đầu phải có định dạng hợp lệ',
            'endDate.date' => 'Ngày kết thúc phải có định dạng hợp lệ',
            'startDate.before_or_equal' => 'Ngày bắt đầu phải trước hoặc bằng ngày kết thúc',
            'endDate.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu',
            'limit.max' => 'Số lượng tối đa là 100 bản ghi',
            'productType.exists' => 'Loại sản phẩm không tồn tại',
            'status.*.in' => 'Trạng thái đơn hàng không hợp lệ',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'timeFilter' => 'bộ lọc thời gian',
            'startDate' => 'ngày bắt đầu',
            'endDate' => 'ngày kết thúc',
            'limit' => 'số lượng',
            'page' => 'trang',
            'productType' => 'loại sản phẩm',
            'status' => 'trạng thái',
        ];
    }
}