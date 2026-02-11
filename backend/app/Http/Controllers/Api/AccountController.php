<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function saveYandex(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => [
                'required',
                'url',
                'regex:/^https:\/\/(www\.)?yandex\.ru\/maps\/org\/.+$/'
            ]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Неверная ссылка',
                'errors' => $validator->errors()
            ], 422);
        }

        $url = $request->input('url');

        // 🔥 Извлекаем org_id
        $orgId = $this->extractOrgId($url);

        if (!$orgId) {
            return response()->json([
                'message' => 'Не удалось определить ID организации'
            ], 422);
        }

        $user = $request->user();

        $user->update([
            'yandex_url' => $url,
            'yandex_org_id' => $orgId
        ]);

        return response()->json([
            'message' => 'Ссылка успешно сохранена',
            'org_id' => $orgId
        ]);
    }
}
