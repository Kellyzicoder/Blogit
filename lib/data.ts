import "server-only";
import { query, queryOne } from "./db";
import type { Entry, EntryWithTopic, Topic, User } from "./types";

// Every "for user" query checks the owner in SQL, so nobody can see or
// change someone else's topics or entries by guessing an id.

const ENTRY_WITH_TOPIC = `
  SELECT e.entryid, e.entname, e.enttext, e.blogid, e.statusid, e.entdate,
         b.bgname, b.userid, u.firstname, u.lastname
  FROM entry e
  JOIN blog b ON b.blogid = e.blogid
  JOIN users u ON u.userid = b.userid`;

export function getTopicsForUser(userid: number) {
  return query<Topic>(
    "SELECT * FROM blog WHERE userid = $1 ORDER BY bgdate DESC, blogid DESC",
    [userid],
  );
}

export function getTopicForUser(blogid: number, userid: number) {
  return queryOne<Topic>("SELECT * FROM blog WHERE blogid = $1 AND userid = $2", [blogid, userid]);
}

export function getEntriesForTopic(blogid: number) {
  return query<Entry>(
    "SELECT * FROM entry WHERE blogid = $1 ORDER BY entdate DESC, entryid DESC",
    [blogid],
  );
}

export function getEntryForUser(entryid: number, userid: number) {
  return queryOne<EntryWithTopic>(`${ENTRY_WITH_TOPIC} WHERE e.entryid = $1 AND b.userid = $2`, [
    entryid,
    userid,
  ]);
}

export function getEntriesForUserByStatus(userid: number, statusid: number) {
  return query<EntryWithTopic>(
    `${ENTRY_WITH_TOPIC} WHERE b.userid = $1 AND e.statusid = $2
     ORDER BY e.entdate DESC, e.entryid DESC`,
    [userid, statusid],
  );
}

/** Every published entry from every user, for the Community page. */
export function getAllPublishedEntries() {
  return query<EntryWithTopic>(
    `${ENTRY_WITH_TOPIC} WHERE e.statusid = 1 ORDER BY e.entdate DESC, e.entryid DESC`,
  );
}

export function getAllUsers() {
  return query<User>(
    `SELECT userid, firstname, lastname, email, usertype, userdate, online
     FROM users ORDER BY userid`,
  );
}

export async function emailTaken(email: string, exceptUserid?: number) {
  const row = await queryOne<{ userid: number }>(
    "SELECT userid FROM users WHERE lower(email) = lower($1) AND userid <> $2",
    [email, exceptUserid ?? 0],
  );
  return row !== null;
}
