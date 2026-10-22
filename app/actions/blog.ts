"use server";

import { redirect } from "next/navigation";
import { query, queryOne } from "@/lib/db";
import { requireUser } from "@/lib/auth";
import { getEntryForUser, getTopicForUser } from "@/lib/data";
import { field, idField, isIsoDate, withMessage } from "@/lib/forms";
import { STATUS, type From } from "@/lib/types";

/** Where each list lives, so we can send the user back to it. */
function listPath(from: From, blogid: number) {
  if (from === "drafts") return "/drafts";
  if (from === "published") return "/published";
  return `/topics/${blogid}`;
}

function readFrom(form: FormData): From {
  const from = field(form, "from");
  return from === "drafts" || from === "published" ? from : "topic";
}

function readTopicFields(form: FormData) {
  const bgname = field(form, "bgname");
  const bgdescript = field(form, "bgdescript");
  const bgdate = field(form, "bgdate");
  const ok =
    bgname.length > 0 && bgname.length <= 150 && bgdescript.length <= 200 && isIsoDate(bgdate);
  return { bgname, bgdescript, bgdate, ok };
}

function readEntryFields(form: FormData) {
  const entname = field(form, "entname");
  const enttext = field(form, "enttext");
  const entdate = field(form, "entdate");
  const ok =
    entname.length > 0 && entname.length <= 150 && enttext.length <= 2000 && isIsoDate(entdate);
  return { entname, enttext, entdate, ok };
}

const TOPIC_RULES = "Error: The topic needs a name (150 characters max), a date, and a description of 200 characters max.";
const ENTRY_RULES = "Error: The entry needs a name (150 characters max), a date, and text of 2000 characters max.";

// ---------- Topics ----------

export async function createTopic(form: FormData) {
  const user = await requireUser();
  const t = readTopicFields(form);
  if (!t.ok) redirect(withMessage("/topics", "err", TOPIC_RULES));

  await query("INSERT INTO blog (bgname, bgdescript, bgdate, userid) VALUES ($1, $2, $3, $4)", [
    t.bgname,
    t.bgdescript,
    t.bgdate,
    user.userid,
  ]);
  redirect(withMessage("/topics", "ok", "The topic has been successfully saved"));
}

export async function updateTopic(form: FormData) {
  const user = await requireUser();
  const blogid = idField(form, "blogid");
  const t = readTopicFields(form);
  if (!blogid || !t.ok) redirect(withMessage("/topics", "err", TOPIC_RULES));

  const updated = await query(
    `UPDATE blog SET bgname = $1, bgdescript = $2, bgdate = $3
     WHERE blogid = $4 AND userid = $5 RETURNING blogid`,
    [t.bgname, t.bgdescript, t.bgdate, blogid, user.userid],
  );
  redirect(
    updated.length
      ? withMessage("/topics", "ok", "The topic has been successfully saved")
      : withMessage("/topics", "err", "Error: That topic could not be found"),
  );
}

export async function deleteTopic(form: FormData) {
  const user = await requireUser();
  const blogid = idField(form, "blogid");
  // Its entries are removed too (ON DELETE CASCADE in the database).
  const deleted = blogid
    ? await query("DELETE FROM blog WHERE blogid = $1 AND userid = $2 RETURNING blogid", [
        blogid,
        user.userid,
      ])
    : [];
  redirect(
    deleted.length
      ? withMessage("/topics", "ok", "The topic was successfully deleted")
      : withMessage("/topics", "err", "Error: That topic could not be found"),
  );
}

// ---------- Entries ----------

/** New entry from the "Add Entry" page. The button pressed decides Draft or Publish. */
export async function createEntry(form: FormData) {
  const user = await requireUser();
  const blogid = idField(form, "blogid");
  const topic = blogid ? await getTopicForUser(blogid, user.userid) : null;
  if (!topic) redirect(withMessage("/topics", "err", "Error: That topic could not be found"));

  const e = readEntryFields(form);
  if (!e.ok) redirect(withMessage(`/topics/${topic.blogid}/new`, "err", ENTRY_RULES));

  const publish = field(form, "intent") === "publish";
  await query(
    "INSERT INTO entry (entname, enttext, entdate, blogid, statusid) VALUES ($1, $2, $3, $4, $5)",
    [e.entname, e.enttext, e.entdate, topic.blogid, publish ? STATUS.published : STATUS.draft],
  );
  redirect(
    publish
      ? withMessage("/published", "ok", "The new entry has been successfully published")
      : withMessage("/drafts", "ok", "The entry has been successfully saved as draft"),
  );
}

/**
 * Save an edited entry. The button pressed decides what happens:
 *  - "keep":    save and keep it as it is (draft stays draft, published stays published)
 *  - "draft":   save and move it to Drafts
 *  - "publish": save and publish it
 */
export async function saveEntry(form: FormData) {
  const user = await requireUser();
  const from = readFrom(form);
  const entryid = idField(form, "entryid");
  const existing = entryid ? await getEntryForUser(entryid, user.userid) : null;
  if (!existing) redirect(withMessage("/topics", "err", "Error: That entry could not be found"));

  const e = readEntryFields(form);
  if (!e.ok) {
    redirect(withMessage(`/entries/${existing.entryid}/edit?from=${from}`, "err", ENTRY_RULES));
  }

  const intent = field(form, "intent");
  const statusid =
    intent === "publish" ? STATUS.published : intent === "draft" ? STATUS.draft : existing.statusid;

  await queryOne(
    "UPDATE entry SET entname = $1, enttext = $2, entdate = $3, statusid = $4 WHERE entryid = $5",
    [e.entname, e.enttext, e.entdate, statusid, existing.entryid],
  );

  if (intent === "publish") {
    redirect(withMessage("/published", "ok", "The entry has been successfully published"));
  }
  if (intent === "draft") {
    redirect(withMessage("/drafts", "ok", "The entry has been successfully saved as draft"));
  }
  redirect(withMessage(listPath(from, existing.blogid), "ok", "The entry was successfully updated"));
}

export async function deleteEntry(form: FormData) {
  const user = await requireUser();
  const from = readFrom(form);
  const entryid = idField(form, "entryid");
  const existing = entryid ? await getEntryForUser(entryid, user.userid) : null;
  if (!existing) redirect(withMessage("/topics", "err", "Error: That entry could not be found"));

  await query("DELETE FROM entry WHERE entryid = $1", [existing.entryid]);
  redirect(withMessage(listPath(from, existing.blogid), "ok", "The entry was deleted successfully"));
}
