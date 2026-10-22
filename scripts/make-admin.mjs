// Makes an existing user an admin, so they can see the Users page.
// Run with:  npm run make-admin -- you@example.com
import pg from "pg";

const email = process.argv[2];
if (!email) {
  console.error("Usage: npm run make-admin -- you@example.com");
  process.exit(1);
}
if (!process.env.DATABASE_URL) {
  console.error("DATABASE_URL is not set. Put it in .env.local first.");
  process.exit(1);
}

const client = new pg.Client({ connectionString: process.env.DATABASE_URL });
await client.connect();
try {
  const result = await client.query(
    "UPDATE users SET usertype = 2 WHERE lower(email) = lower($1)",
    [email],
  );
  console.log(
    result.rowCount ? `${email} is now an admin.` : `No user found with email ${email}.`,
  );
} finally {
  await client.end();
}
