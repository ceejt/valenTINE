# Valentine's Proposal SPA

A romantic, interactive proposal app with envelope opening animation, puzzle game, and choice tracking.

## Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Nuxt 3 (Vue 3 Composition API) + Tailwind CSS
- **Database**: SQLite (for simplicity)

## Project Structure

```
valentine-proposal/
├── backend/              # Laravel API
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   └── ProposalController.php
│   │   └── Models/
│   │       └── ProposalChoice.php
│   ├── database/
│   │   └── migrations/
│   ├── routes/
│   │   └── api.php
│   └── ...
├── frontend/             # Nuxt 3 SPA
│   ├── components/
│   │   ├── EnvelopeOpen.vue
│   │   ├── PuzzleGame.vue
│   │   └── FinalChoice.vue
│   ├── pages/
│   │   └── index.vue
│   ├── assets/
│   │   └── css/
│   │       └── main.css
│   ├── app.vue
│   ├── nuxt.config.ts
│   ├── package.json
│   └── tailwind.config.js
└── README.md
```

## Setup Instructions

### Prerequisites

- PHP 8.2+
- Composer
- Node.js 18+
- npm or yarn

### Backend Setup

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve  # Runs on http://localhost:8000
```

### Frontend Setup

```bash
cd frontend
npm install
npm run dev  # Runs on http://localhost:3000
```

## Features

1. **Envelope Opening Animation**: CSS-powered fold/unfold effect
2. **Drag-and-Drop Puzzle**: Arrange paper scraps to reveal message
3. **Final Choice**: YES (confetti + 🐻) or NO (🍅 + retry)
4. **API Logging**: Saves choice to database

## Development Notes

- API endpoint: `POST /api/proposal/choice`
- CORS configured for localhost:3000 (Nuxt default)
- Uses SQLite for easy setup (no MySQL required)
- Nuxt uses file-based routing in `/pages` directory
