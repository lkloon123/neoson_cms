<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/11/2019
 * Time: 11:16 AM.
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class BaseRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->ability('superadmin', 'login_admin-view');
    }

    public function rules()
    {
        return [];
    }

    protected function failedAuthorization()
    {
        throw new AccessDeniedHttpException('You are unauthorized to do this');
    }
}
