# BLOGit

A multi-user blog. People sign up, create **topics**, write **entries** inside them,
save entries as **drafts** or **publish** them, and everyone's published entries show
on the **Community** page. Admins get a **Users** page to edit, reset or remove users.

Built with **Next.js + TypeScript**, a **Neon Postgres** database, and hosted on **Vercel**.
(The first version was PHP + MySQL; that is still in the git history.)

## How it fits together

| Part | Where |
| --- | --- |
| Pages | `app/` (one folder per page) |
| Backend (saving, deleting, login) | `app/actions/` — server actions that run on Vercel |
| Database code | `lib/db.ts`, `lib/data.ts` |
| Login cookie | `lib/session.ts`, `lib/auth.ts` |
| Database tables | `db/schema.sql` |
| Old stylesheet (kept so the site looks the same) | `app/style.css` |

## Run it on your computer

1. Make a free Neon database at [neon.tech](https://neon.tech), or connect Neon to the
   project in Vercel (**Storage** tab → **Neon**) and copy its `DATABASE_URL`.
2. Copy `.env.example` to `.env.local` and fill in `DATABASE_URL` and `SESSION_SECRET`
   (make a secret with `openssl rand -base64 32`).
3. Install and create the tables:
   ```bash
   npm install
   npm run db:setup
   ```
4. Start it: `npm run dev`, then open http://localhost:3000

## Make yourself an admin

Sign up on the site first, then run:

```bash
npm run make-admin -- you@example.com
```

## Put it on Vercel

1. In the Vercel project, connect Neon (**Storage** → **Neon**). This adds `DATABASE_URL`.
2. Add `SESSION_SECRET` under **Settings → Environment Variables**.
3. Run `npm run db:setup` once on your computer with the same `DATABASE_URL` to create the tables.
4. Deploy.
