# Valentine's Proposal Website

A romantic, interactive proposal app with envelope opening animation, puzzle game, and choice tracking.

## Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Vue 3 (Composition API) + Tailwind CSS
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
├── frontend/             # Vue 3 SPA
│   ├── src/
│   │   ├── components/
│   │   │   ├── EnvelopeOpen.vue
│   │   │   ├── PuzzleGame.vue
│   │   │   └── FinalChoice.vue
│   │   ├── App.vue
│   │   └── main.js
│   ├── public/
│   └── package.json
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
npm run dev  # Runs on http://localhost:5173
```

## Features

1. **Envelope Opening Animation**: CSS-powered fold/unfold effect
2. **Drag-and-Drop Puzzle**: Arrange paper scraps to reveal message
3. **Final Choice**: YES (confetti + 🐻) or NO (🍅 + retry)
4. **API Logging**: Saves choice to database

## Development Notes

- API endpoint: `POST /api/proposal/choice`
- CORS configured for localhost:5173
- Uses SQLite for easy setup (no MySQL required)
