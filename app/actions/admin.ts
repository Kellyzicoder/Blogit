"use server";

import { redirect } from "next/navigation";
import { query } from "@/lib/db";
import { hashPassword, requireAdmin } from "@/lib/auth";
import { emailTaken } from "@/lib/data";
import { field, idField, isEmail, MIN_PASSWORD, withMessage } from "@/lib/forms";
import { USER_TYPE } from "@/lib/types";

export async function updateUser(form: FormData) {
  const admin = await requireAdmin();
  const userid = idField(form, "userid");
  const firstname = field(form, "firstname");
  const lastname = field(form, "lastname");
  const email = field(form, "email");
  const usertype = field(form, "status") === "2" ? USER_TYPE.admin : USER_TYPE.normal;

  if (!userid || userid === admin.userid) {
    redirect(withMessage("/users", "err", "Error: User update was not a success"));
  }
  if (!firstname || !lastname || !isEmail(email) || Math.max(firstname.length, lastname.length, email.length) > 150) {
    redirect(withMessage(`/users?edit=${userid}`, "err", "Error: Please fill in a name and a valid email"));
  }
  if (await emailTaken(email, userid)) {
    redirect(
      withMessage(`/users?edit=${userid}&dupe=1`, "err", "Error: User was not updated. Make sure email is not a duplicate"),
    );
  }

  const updated = await query(
    `UPDATE users SET firstname = $1, lastname = $2, email = $3, usertype = $4
     WHERE userid = $5 RETURNING userid`,
    [firstname, lastname, email, usertype, userid],
  );
  redirect(
    updated.length
      ? withMessage("/users", "ok", "User update was a success")
      : withMessage("/users", "err", "Error: User update was not a success"),
  );
}

export async function deleteUser(form: FormData) {
  const admin = await requireAdmin();
  const userid = idField(form, "userid");
  // Their topics and entries are removed too (ON DELETE CASCADE).
  const deleted =
    userid && userid !== admin.userid
      ? await query("DELETE FROM users WHERE userid = $1 RETURNING userid", [userid])
      : [];
  redirect(
    deleted.length
      ? withMessage("/users", "ok", "The user was deleted successfully")
      : withMessage("/users", "err", "The user was not deleted"),
  );
}

/** Lets an admin set a new password for a user who forgot theirs. */
export async function setUserPassword(form: FormData) {
  await requireAdmin();
  const userid = idField(form, "userid");
  const next = String(form.get("newpassword") ?? "");
  const confirm = String(form.get("confirmnewpassword") ?? "");
  if (!userid) redirect(withMessage("/users", "err", "Error: The password of the user failed to update"));

  const back = `/users?password=${userid}`;
  if (!next || !confirm) redirect(withMessage(back, "err", "Please fill in both password boxes"));
  if (next !== confirm) redirect(withMessage(back, "err", "Passwords do not match. Please try again"));
  if (next.length < MIN_PASSWORD) {
    redirect(withMessage(back, "err", `Password must be at least ${MIN_PASSWORD} characters`));
  }

  const updated = await query("UPDATE users SET password = $1 WHERE userid = $2 RETURNING userid", [
    await hashPassword(next),
    userid,
  ]);
  redirect(
    updated.length
      ? withMessage("/users", "ok", "The password of the user has been changed successfully")
      : withMessage("/users", "err", "Error: The password of the user failed to update"),
  );
}
