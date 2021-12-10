<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return back()->withInput();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Fullname' => 'required|string',
            'kilometers' => 'required',
            'Phone' => 'required|regex:/(0)[0-9]{9}/',
            'Email' => 'required|email:rfc,dns',
            'Password' => 'required',
            'Payment_method' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'Fullname.required' => 'Vui lòng nhập họ tên người nhận hàng',
            'Fullname.string' => 'Định dạng tên không đúng, vui lòng nhập chính xác',
            'kilometers.required' => 'Thông tin địa chỉ không được xác thực, vui lòng nhập đúng và đầy đủ địa chỉ!',
            'Phone.required' => 'Vui lòng nhập SĐT!',
            'Phone.numeric' => 'Sai định dạng',
            'Phone.digits_between' => '',
            'Email.required' => 'Vui lòng nhập địa chỉ Email!',
            'Email.email' => 'Không đúng định dạng Email! Ví dụ: Example@domain.com',
            'Password.required' => 'Vui lòng nhập mật khẩu để xác thực tài khoản tạo đơn hàng',
            'Payment_method.required' => 'Vui lòng chọn hình thức thanh toán'
        ];
    }
}
