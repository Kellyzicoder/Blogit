"use server";

import { redirect } from "next/navigation";
import { query, queryOne } from "@/lib/db";
import { checkPassword, hashPassword, requireUser } from "@/lib/auth";
import { createSession, deleteSession } from "@/lib/session";
import { emailTaken } from "@/lib/data";
import { field, isEmail, MIN_PASSWORD, withMessage, type FormState } from "@/lib/forms";

export async function login(_prev: FormState, form: FormData): Promise<FormState> {
  const email = field(form, "email");
  const password = form.get("password");
  const bad: FormState = {
    error: "The email/password is incorrect. Please try again.",
    badFields: ["email", "password"],
    values: { email },
  };
  if (!email || typeof password !== "string" || !password) return bad;

  const user = await queryOne<{ userid: number; password: string }>(
    "SELECT userid, password FROM users WHERE lower(email) = lower($1)",
    [email],
  );
  if (!user || !(await checkPassword(password, user.password))) return bad;

  await query("UPDATE users SET online = now() WHERE userid = $1", [user.userid]);
  await createSession(user.userid);
  redirect("/topics");
}

export async function register(_prev: FormState, form: FormData): Promise<FormState> {
  const firstname = field(form, "firstname");
  const lastname = field(form, "lastname");
  const email = field(form, "email");
  const password = String(form.get("password") ?? "");
  const confirm = String(form.get("confirmpassword") ?? "");
  const values = { firstname, lastname, email };

  if (!firstname || !lastname || !isEmail(email)) {
    return { error: "Please fill in your name and a valid email.", values };
  }
  if (firstname.length > 150 || lastname.length > 150 || email.length > 150) {
    return { error: "Names and email must be 150 characters or less.", values };
  }
  if (password !== confirm) {
    return { error: "Passwords do not match. Please try again", badFields: ["password"], values };
  }
  if (password.length < MIN_PASSWORD) {
    return {
      error: `Password must be at least ${MIN_PASSWORD} characters`,
      badFields: ["password"],
      values,
    };
  }
  if (await emailTaken(email)) {
    return { error: "Email is already used. Please try again.", badFields: ["email"], values };
  }

  await query(
    "INSERT INTO users (firstname, lastname, email, password) VALUES ($1, $2, $3, $4)",
    [firstname, lastname, email, await hashPassword(password)],
  );
  redirect("/login?registered=1");
}

export async function logout() {
  await deleteSession();
  redirect("/");
}

export async function updateAccount(_prev: FormState, form: FormData): Promise<FormState> {
  const user = await requireUser();
  const firstname = field(form, "firstname");
  const lastname = field(form, "lastname");
  const email = field(form, "email");
  const values = { firstname, lastname, email };

  if (!firstname || !lastname || !isEmail(email)) {
    return { error: "Please fill in your name and a valid email.", values };
  }
  if (firstname.length > 150 || lastname.length > 150 || email.length > 150) {
    return { error: "Names and email must be 150 characters or less.", values };
  }
  if (await emailTaken(email, user.userid)) {
    return { error: "Email is already used. Please try again.", badFields: ["email"], values };
  }

  await query("UPDATE users SET firstname = $1, lastname = $2, email = $3 WHERE userid = $4", [
    firstname,
    lastname,
    email,
    user.userid,
  ]);
  redirect(withMessage("/topics", "ok", "Your personal information was successfully changed"));
}

export async function changePassword(_prev: FormState, form: FormData): Promise<FormState> {
  const user = await requireUser();
  const current = String(form.get("currentpassword") ?? "");
  const next = String(form.get("newpassword") ?? "");
  const confirm = String(form.get("confirmnewpassword") ?? "");
  const bad = ["password"];

  const row = await queryOne<{ password: string }>("SELECT password FROM users WHERE userid = $1", [
    user.userid,
  ]);
  if (!row || !(await checkPassword(current, row.password))) {
    return { error: "Current password does not match. Please try again", badFields: bad };
  }
  if (next !== confirm) {
    return { error: "Passwords do not match. Please try again", badFields: bad };
  }
  if (next.length < MIN_PASSWORD) {
    return { error: `Password entered must be at least ${MIN_PASSWORD} characters`, badFields: bad };
  }
  if (await checkPassword(next, row.password)) {
    return { error: "You typed in an old password. Please try again", badFields: bad };
  }

  await query("UPDATE users SET password = $1 WHERE userid = $2", [
    await hashPassword(next),
    user.userid,
  ]);
  redirect(withMessage("/account", "ok", "Your password has been changed successfully"));
}
