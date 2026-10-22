import "server-only";
import pg from "pg";

// Return DATE columns as plain "YYYY-MM-DD" text instead of JS Date objects,
// so dates never shift because of time zones.
pg.types.setTypeParser(1082, (value: string) => value);

declare global {
  // Re-use one pool while developing, so hot reload doesn't open new ones.
  var blogitPool: pg.Pool | undefined;
}

function makePool() {
  if (!process.env.DATABASE_URL) {
    throw new Error("DATABASE_URL is not set");
  }
  return new pg.Pool({
    connectionString: process.env.DATABASE_URL,
    max: 5,
  });
}

// Made on first use (not when the file loads), so `next build` works
// even before the database is connected.
function getPool() {
  globalThis.blogitPool ??= makePool();
  return globalThis.blogitPool;
}

/** Run a query and get all rows back. Always pass values in `params`, never inside the SQL text. */
export async function query<T extends pg.QueryResultRow>(
  text: string,
  params: unknown[] = [],
): Promise<T[]> {
  const result = await getPool().query<T>(text, params);
  return result.rows;
}

/** Run a query and get the first row back (or null). */
export async function queryOne<T extends pg.QueryResultRow>(
  text: string,
  params: unknown[] = [],
): Promise<T | null> {
  const rows = await query<T>(text, params);
  return rows[0] ?? null;
}
