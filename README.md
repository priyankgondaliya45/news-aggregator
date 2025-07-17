
# Project Title

A brief description of what this project does and who it's for

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
git clone https://github.com/yourname/news-aggregator.git
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
APP_NAME=Laravel
APP_URL=http://127.0.0.1:8000
DB_DATABASE=news_aggregator
DB_USERNAME=root
DB_PASSWORD=
NEWSAPI_KEY=your_newsapi_key
GUARDIAN_KEY=your_guardian_key
NYT_KEY=your_nyt_key
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
### 7. API Usage
Endpoint
```bash
GET /api/articles
```
```css
Query Parameters
Param	        Description
category_id	    Filter by news category
author_id	    Filter by author
provider_id	    Filter by provider
source_id	    Filter by source
published_from	Start date (YYYY-MM-DD)
published_to	End date (YYYY-MM-DD)
```
```bash
GET /api/articles?category_id=3&author_id=5&published_from=2024-01-01
```
### 8. Project Structure
```css
app/
├── Console/
│   └── Commands/
│           ├── FetchNewsArticles.php
├── DTOs/
│       ├── Contracts/
|       |      ├── ArticleTransformerInterface.php
│       ├── Transformers
|       |      ├── GuardianTransformer.php
|       |      ├── NewsApiTransformer.php
|       |      ├── NewYorkTimesTransformer.php
|       ├── ArticleResponseDTO.php
├── Http/
│     ├── Controllers/
|     |      ├── ArticleController.php
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
│       │   ├── GuardianService.php
│       │   └── NYTimesService.php
|       |   └── NewsAggregatorService.php
├── Traits/
│   ├── ResolvesNewsProvider.php
routes/
├── api.php
```