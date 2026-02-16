export interface AccountResponse {
    yandex_url: string | null;
    rating: number | null;
    reviews_count: number | null;
}

export interface SaveYandexPayload {
    url: string;
}

export interface Account {
    id: number;
    organization_name: string | null;
    yandex_url: string | null;
    rating: number | null;
    reviews_count: number | null;
}

export interface Review {
    id: number;
    author: string;
    rating: number;
    text: string;
    review_date: string;
}

export interface AccountResponse {
    account: Account;
    reviews: Review[];
    user: {
        id: number;
        name: string;
        email: string;
        phone: string;
    };
}