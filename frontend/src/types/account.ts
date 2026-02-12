export interface AccountResponse {
    yandex_url: string | null;
    rating: number | null;
    reviews_count: number | null;
}

export interface SaveYandexPayload {
    url: string;
}