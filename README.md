# ValenTINE's Proposal

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
│   ├── bootstrap/
│   │   └── app.php                       # CORS & middleware config
│   ├── config/
│   │   └── cors.php                      # CORS settings
│   ├── database/
│   │   ├── migrations/
│   │   │   └── 2024_02_01_000001_create_proposal_choices_table.php
│   │   └── database.sqlite               # SQLite database (create this)
│   ├── routes/
│   │   └── api.php                       # API routes
│   ├── .env                              # Environment variables
│   ├── .env.example                      # Environment template
│   └── composer.json                     # PHP dependencies
│
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
│   ├── .env                              # Frontend environment variables
│   ├── nuxt.config.ts
│   ├── package.json
│   └── tailwind.config.js
│
├── README.md
├── QUICK_START.md
├── NUXT_GUIDE.md
├── ENV_SETUP.md
├── GITIGNORE_GUIDE.md
└── .gitignore
```

## Setup Instructions

### Prerequisites

- PHP 8.2+
- Composer
- Node.js 18+
- npm or yarn

### Backend Setup (Laravel)

```bash
cd backend

# 1. Install PHP dependencies
composer install

# 2. Setup environment file
cp .env.example .env

# 3. Generate application key
php artisan key:generate

# 4. Create SQLite database file
touch database/database.sqlite

# 5. Run database migrations
php artisan migrate

# 6. Start Laravel server
php artisan serve  # Runs on http://localhost:8000
```

### Frontend Setup (Nuxt 3)

```bash
cd frontend

# 1. Install JavaScript dependencies
npm install

# 2. Start development server
npm run dev  # Runs on http://localhost:3000
```

### Important Files to Create/Check

**Backend:**

- `backend/database/database.sqlite` - Create with `touch` command
- `backend/.env` - Copy from `.env.example` and run `php artisan key:generate`
- `backend/bootstrap/app.php` - CORS configuration (included)
- `backend/config/cors.php` - CORS allowed origins (included)
- `backend/database/migrations/*` - Database schema (included)

**Frontend:**

- `frontend/.env` - Already included with `NUXT_PUBLIC_API_URL`

## Features

1. **Envelope Opening Animation**: CSS-powered fold/unfold effect
2. **Drag-and-Drop Puzzle**: Arrange pieces in correct order to form "Will You Be My MVP This Valentine's?"
   - Must be placed in exact order: Will → You → Be → My → MVP → This → Valentine's?
   - Click placed pieces to remove and rearrange
3. **Emoji Input Choice**: Type 🧸 for YES or 🍅 for NO
   - YES triggers confetti + teddy bear celebration
   - NO shows tomato + retry option
4. **Restaurant Booking Surprise**: (Only appears after YES)
   - Fake restaurant selection (all lead to Pat & Pat!)
   - Digital signature pad for confirmation
   - Pre-booked surprise at Pat & Pat Restaurant, Quezon City
5. **API Logging**: Saves choice and reservation signature to database

## Complete Files List

### Backend Files (Laravel)

- `app/Http/Controllers/ProposalController.php` - API endpoints
- `app/Models/ProposalChoice.php` - Database model
- `bootstrap/app.php` - Application bootstrap & CORS middleware
- `config/cors.php` - CORS configuration
- `routes/api.php` - API routes definition
- `database/migrations/2024_02_01_000001_create_proposal_choices_table.php` - Database schema
- `.env.example` - Environment template
- `.env` - Environment variables (create from .env.example)
- `composer.json` - PHP dependencies
- `database/database.sqlite` - with `touch database/database.sqlite`

### Frontend Files (Nuxt 3)

- `components/EnvelopeOpen.vue` - Opening animation
- `components/PuzzleGame.vue` - Drag-drop puzzle
- `components/FinalChoice.vue` - YES/NO buttons with confetti
- `components/RestaurantBooking.vue` - Restaurant reservation with signature pad
- `pages/index.vue` - Home page
- `assets/css/main.css` - Global styles with Tailwind
- `app.vue` - Root component
- `nuxt.config.ts` - Nuxt configuration
- `tailwind.config.js` - Tailwind configuration
- `.env` - Environment variables with API URL
- `package.json` - JavaScript dependencies
- `.gitignore` - Nuxt-specific ignore rules

### Documentation Files

- `README.md`

## Development Notes

- API endpoint: `POST /api/proposal/choice`
- CORS configured for localhost:3000 (Nuxt default)
- Uses SQLite for easy setup
- Nuxt uses file-based routing in `/pages` directory
- Tailwind CSS for styling and animations
- Confetti effect implemented with CSS animations