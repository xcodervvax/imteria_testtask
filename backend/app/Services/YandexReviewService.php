<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Review;

class YandexReviewService
{
    public function fetch(Account $account): void
    {
        $mockReviews = [
            [
                'author' => 'Иван',
                'rating' => 5,
                'text' => 'Отличное место!',
                'review_date' => now()->subDays(1),
            ],
            [
                'author' => 'Мария',
                'rating' => 4,
                'text' => 'Хороший сервис',
                'review_date' => now()->subDays(2),
            ],
        ];

        // удаляем старые отзывы
        $account->reviews()->delete();

        foreach ($mockReviews as $review) {
            Review::create([
                'account_id' => $account->id,
                ...$review,
            ]);
        }

        $account->update([
            'rating' => collect($mockReviews)->avg('rating'),
            'reviews_count' => count($mockReviews),
        ]);
    }
}
