<?php

namespace App\Services;

use App\Models\Account;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

class YandexReviewService
{
    public function fetch(Account $account): void
    {
        try {
            $account->update(['status' => 'processing']);

            $url = "https://yandex.ru/maps/org/{$account->yandex_org_id}/reviews/";

            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'Accept-Language' => 'ru',
            ])->get($url);

            if (!$response->successful()) {
                throw new \Exception('Yandex page load failed');
            }

            $html = $response->body();

            $crawler = new Crawler($html);

            $organizationPhone = null;

            if ($crawler->filter('[itemprop="telephone"]')->count()) {
                $organizationPhone = trim(
                    $crawler->filter('[itemprop="telephone"]')->first()->text()
                );
            }

            if (!$organizationPhone && $crawler->filter('a[href^="tel:"]')->count()) {
                $organizationPhone = trim(
                    $crawler->filter('a[href^="tel:"]')->first()->text()
                );
            }

            // 🔥 Название организации
            $organizationName = null;
            if ($crawler->filter('h1')->count()) {
                $organizationName = trim($crawler->filter('h1')->first()->text());
            }

            // 🔥 Рейтинг
            $rating = null;
            if ($crawler->filter('[itemprop="ratingValue"]')->count()) {
                $rating = (float) $crawler
                    ->filter('[itemprop="ratingValue"]')
                    ->first()
                    ->attr('content');
            }

            // 🔥 Количество отзывов
            $reviewsCount = null;
            if ($crawler->filter('[itemprop="reviewCount"]')->count()) {
                $reviewsCount = (int) $crawler
                    ->filter('[itemprop="reviewCount"]')
                    ->first()
                    ->attr('content');
            }

            // 🔥 Отзывы
            $reviews = [];

            $crawler->filter('[itemprop="review"]')->each(function (Crawler $node) use (&$reviews) {

                $author = $node->filter('[itemprop="author"]')->count()
                    ? trim($node->filter('[itemprop="author"]')->text())
                    : 'Аноним';

                $rating = $node->filter('[itemprop="ratingValue"]')->count()
                    ? (int) $node->filter('[itemprop="ratingValue"]')->attr('content')
                    : 0;

                $text = $node->filter('[itemprop="reviewBody"]')->count()
                    ? trim($node->filter('[itemprop="reviewBody"]')->text())
                    : '';

                $date = $node->filter('meta[itemprop="datePublished"]')->count()
                    ? $node->filter('meta[itemprop="datePublished"]')->attr('content')
                    : now();

                $reviews[] = [
                    'author' => $author,
                    'rating' => $rating,
                    'text' => $text,
                    'review_date' => $date,
                ];
            });

            DB::transaction(function () use ($account, $organizationName,
                $organizationPhone, $rating, $reviewsCount, $reviews) {

                $account->reviews()->delete();

                foreach ($reviews as $review) {
                    $account->reviews()->create($review);
                }

                $account->update([
                    'organization_name' => $organizationName,
                    'organization_phone' => $organizationPhone,
                    'rating' => $rating,
                    'reviews_count' => $reviewsCount ?? count($reviews),
                    'status' => 'ready',
                ]);
            });

        } catch (\Throwable $e) {

            $account->update(['status' => 'failed']);

            throw $e;
        }
    }
}
