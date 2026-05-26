# DhisProject

This project is a web application built with Vue 3 and Vite that is used to manage and analyze data for DHIS (District Health Information System).

## Project Structure

The project is structured as follows:

```
dhis-project/
├── public/
├── src/
│   ├── components/
│   ├── views/
│   ├── App.vue
│   └── main.js
├── .env
├── index.html
├── package.json
└── vite.config.js
```

## Environment Variables

The project uses the following environment variables, which are defined in the `.env` file:

| Variable | Description | |
|----------|-------------|-------|
| `VITE_SUPABASE_URL` | Supabase URL | |
| `VITE_SUPABASE_ANON_KEY` | Supabase Anon Key | |
| `VITE_MANAGEMENT_KEYWORD` | Management Keyword | |

## Getting Started

To get started with the project, follow these steps:

1. Clone the repository:
```bash
git clone <repository-url>
```

2. Install dependencies:
```bash
npm install
```

3. Run the development server:
```bash
npm run dev
```
