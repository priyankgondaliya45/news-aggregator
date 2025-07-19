# Laravel News Aggregator

A modular, extensible Laravel-based news aggregator that fetches, transforms, and stores articles from multiple providers like **NewsAPI**, **The Guardian**, and **The New York Times**.

Articles are normalized using DTOs and stored in a relational structure with support for filtering, pagination, and future scaling.

---

## Features

- ✅ Multi-provider integration (NewsAPI, Guardian, NYT)
- ✅ Clean, paginated article ingestion using API pagination
- ✅ DTO-based article transformation
- ✅ Stores authors, sources, categories, and providers in separate tables
- ✅ Real-time command output with page-wise logging
- ✅ REST API to filter articles by category, author, provider, source, and publish date

---

## Tech Stack

- Laravel 12
- PHP 8.2+
- MySQL
- Laravel Scheduler
- DTOs & Service Layer Architecture
- Eloquent Relationships

---

## 🛠️ Setup Instructions

### 1. Clone the repository

```bash
git clone https://github.com/priyankgondaliya45/news-aggregator.git
cd news-aggregator
```
### 2. Install dependencies

```bash
composer install
```

### 3. Configure Environment

```bash
cp .env.example .env
```
Then update the .env file with your values:
```bash
NEWSAPI_KEY=your_newsapi_key
GUARDIAN_KEY=your_guardian_key
NYT_KEY=your_nyt_key
PAGINATION_LIMIT=set_api_response_limit
```
### 4. Generate Application Key
```bash
php artisan key:generate
```
### 5. Run Migrations
```bash
php artisan migrate
```
### 6. Seed Database (Optional)
```bash
php artisan db:seed
```
🧠 How It Works

Run the following command to fetch and store articles from all providers:
```bash
php artisan news:fetch-articles
```
```css
Fetches in pages (10 per request)
Applies transformers for normalization
Saves article, author, source, category, and provider
```
## 7. API Reference

#### Get all articles

```http
  GET /api/articles
```

| Parameter     | Type     | Description                |
| :--------     | :------- | :------------------------- |
| `category_id` | `int` | Filter by News Category |
| `provider_id` | `int` | Filter by Provider |
| `source_id` | `int` | Filter by Source |
| `author_id` | `int` | Filter by Author |
| `published_from` | `date` | Start date (YYYY-MM-DD) |
| `published_to` | `date` | End date (YYYY-MM-DD) |

#### Get all authors
```http
  GET /api/authors
```

| Parameter     | Type     | Description                |
| :--------     | :------- | :------------------------- |
| `name` | `string` | Filter by Author |
| `provider_id` | `int` | Filter by Provider |

#### Get all news categories
```http
  GET /api/news-categories
```

| Parameter     | Type     | Description                |
| :--------     | :------- | :------------------------- |
| `name` | `string` | Filter by Category |
| `provider_id` | `int` | Filter by Provider |

#### Get all news sources
```http
  GET /api/news-sources
```

| Parameter     | Type     | Description                |
| :--------     | :------- | :------------------------- |
| `name` | `string` | Filter by Source |
| `provider_id` | `int` | Filter by Provider |

#### Get all news providers
```http
  GET /api/news-providers
```

| Parameter     | Type     | Description                |
| :--------     | :------- | :------------------------- |
| `name` | `string` | Filter by Provider |

### 8. Project Structure
```css
app/
├── Console/
│   └── Commands/
│       ├── FetchNewsArticles.php
├── DTOs/
│       ├── Contracts/
|       |      ├── ArticleTransformerInterface.php
│       ├── Transformers
|       |      ├── GuardianTransformer.php
|       |      ├── NewsApiTransformer.php
|       |      ├── NewYorkTimesTransformer.php
|       ├── ArticleResponseDTO.php
├── Http/
│       ├── Controllers/
|       |      ├── ArticleController.php
|       |      ├── AuthorController.php
|       |      ├── NewsCategoryController.php
|       |      ├── NewsProviderController.php
|       |      ├── NewsSourcesController.php
│       ├── Requests/
|       |      ├── ArticleFilterRequest.php
|       |      ├── AuthorFilterRequest.php
|       |      ├── CategoryFilterRequest.php
|       |      ├── ProviderFilterRequest.php
|       |      ├── SourceFilterRequest.php
│       ├── Resources/
|       |      ├── ArticleResource.php
|       |      ├── AuthorResource.php
|       |      ├── NewsCategoryResource.php
|       |      ├── NewsProviderResource.php
|       |      ├── NewsSourceResource.php
├── Models/
│   ├── Article.php
│   ├── Author.php
│   ├── NewsProvider.php
│   ├── NewsSource.php
│   └── NewsCategory.php
├── Services/
│   └── News/
│       ├── Integrations/
│       │   ├── NewsApiService.php
│       │   ├── GuardianApiService.php
│       │   └── NewYorkTimesApiService.php
|       |   └── NewsAggregatorService.php
├── Traits/
│   ├── ResolvesNewsProvider.php
routes/
├── api.php
```
