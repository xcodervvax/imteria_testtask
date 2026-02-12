<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Jobs\FetchYandexReviewsJob;
use App\Models\Account;

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

        // 🔥 Создаём или обновляем Account
        $account = Account::updateOrCreate(
            ['user_id' => $user->id],
            [
                'yandex_url' => $url,
                'yandex_org_id' => $orgId
            ]
        );

        FetchYandexReviewsJob::dispatch($account);

        return response()->json([
            'message' => 'Ссылка успешно сохранена',
            'org_id' => $orgId
        ]);
    }

    private function extractOrgId(string $url): ?string
    {
        preg_match('/\/org\/[^\/]+\/(\d+)/', $url, $matches);

        return $matches[1] ?? null;
    }
}
