import "server-only";
import { cache } from "react";
import { redirect } from "next/navigation";
import bcrypt from "bcryptjs";
import { queryOne } from "./db";
import { getSessionUserId } from "./session";
import { USER_TYPE, type User } from "./types";

const USER_COLUMNS = "userid, firstname, lastname, email, usertype, userdate, online";

/** The logged-in user, or null. Cached so one page load only asks the database once. */
export const getCurrentUser = cache(async (): Promise<User | null> => {
  const userid = await getSessionUserId();
  if (!userid) return null;
  return queryOne<User>(`SELECT ${USER_COLUMNS} FROM users WHERE userid = $1`, [userid]);
});

/** Use on pages and actions that need a logged-in user. Sends others to the login page. */
export async function requireUser(): Promise<User> {
  const user = await getCurrentUser();
  if (!user) redirect("/login");
  return user;
}

/** Use on admin-only pages and actions. */
export async function requireAdmin(): Promise<User> {
  const user = await requireUser();
  if (user.usertype !== USER_TYPE.admin) redirect("/topics");
  return user;
}

export function hashPassword(password: string) {
  return bcrypt.hash(password, 10);
}

export function checkPassword(password: string, hash: string) {
  // Passwords saved by the old PHP site start with "$2y$". It is the same
  // bcrypt format, so swap the prefix so bcryptjs can read it.
  return bcrypt.compare(password, hash.replace(/^\$2y\$/, "$2b$"));
}

export function isAdmin(user: User) {
  return user.usertype === USER_TYPE.admin;
}
