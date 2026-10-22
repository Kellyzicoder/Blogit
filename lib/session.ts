import "server-only";
import { cookies } from "next/headers";
import { SignJWT, jwtVerify } from "jose";

const COOKIE_NAME = "blogit_session";
const ONE_WEEK_SECONDS = 60 * 60 * 24 * 7;

function secretKey() {
  const secret = process.env.SESSION_SECRET;
  if (!secret || secret.length < 16) {
    throw new Error("SESSION_SECRET is missing or too short (use 32+ random characters)");
  }
  return new TextEncoder().encode(secret);
}

/** Log a user in by saving a signed cookie with their id. */
export async function createSession(userid: number) {
  const token = await new SignJWT({ userid })
    .setProtectedHeader({ alg: "HS256" })
    .setIssuedAt()
    .setExpirationTime(`${ONE_WEEK_SECONDS}s`)
    .sign(secretKey());

  const store = await cookies();
  store.set(COOKIE_NAME, token, {
    httpOnly: true,
    secure: process.env.NODE_ENV === "production",
    sameSite: "lax",
    path: "/",
    maxAge: ONE_WEEK_SECONDS,
  });
}

/** Read the logged-in user's id from the cookie, or null if not logged in. */
export async function getSessionUserId(): Promise<number | null> {
  const store = await cookies();
  const token = store.get(COOKIE_NAME)?.value;
  if (!token) return null;
  try {
    const { payload } = await jwtVerify(token, secretKey());
    return typeof payload.userid === "number" ? payload.userid : null;
  } catch {
    return null;
  }
}

export async function deleteSession() {
  const store = await cookies();
  store.delete(COOKIE_NAME);
}
