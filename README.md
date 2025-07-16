# 📰 Laravel News Aggregator

A modular, extensible Laravel-based news aggregator that fetches, transforms, and stores articles from multiple providers like **NewsAPI**, **The Guardian**, and **The New York Times**.

Articles are normalized using DTOs and stored in a relational structure with support for filtering, pagination, and future scaling.

---

## 🚀 Features

- ✅ Multi-provider integration (NewsAPI, Guardian, NYT)
- ✅ Clean, paginated article ingestion using API pagination
- ✅ DTO-based article transformation
- ✅ Stores authors, sources, categories, and providers in separate tables
- ✅ Real-time command output with page-wise logging
- ✅ REST API to filter articles by category, author, provider, source, and publish date

---

## 🏗️ Tech Stack

- Laravel 11
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
