"use client";

import Link from "next/link";
import { useActionState } from "react";
import PasswordField from "./PasswordField";
import { changePassword, login, register, updateAccount } from "@/app/actions/auth";
import type { FormState } from "@/lib/forms";

const empty: FormState = {};
const isBad = (s: FormState, name: string) => s.badFields?.includes(name) ?? false;

function SubmitButton({ label, pending }: { label: string; pending: boolean }) {
  return (
    <div className="input-field button">
      <input type="submit" value={pending ? "Please wait..." : label} disabled={pending} />
    </div>
  );
}

export function LoginForm() {
  const [state, action, pending] = useActionState(login, empty);
  return (
    <form action={action}>
      <div className="input-field">
        <input
          type="email"
          placeholder="Enter your email"
          className={isBad(state, "email") ? "active" : ""}
          name="email"
          defaultValue={state.values?.email}
          autoComplete="email"
          required
        />
        <i className="uil uil-envelope icon" />
      </div>
      <PasswordField name="password" placeholder="Enter your password" bad={isBad(state, "password")} />
      <SubmitButton label="Login" pending={pending} />
      {state.error && <div className="inputerror">{state.error}</div>}
    </form>
  );
}

export function RegisterForm() {
  const [state, action, pending] = useActionState(register, empty);
  return (
    <form action={action} autoComplete="off">
      <div className="input-field">
        <input type="text" placeholder="Enter your first name" name="firstname" defaultValue={state.values?.firstname} maxLength={150} required />
        <i className="uil uil-user icon" />
      </div>
      <div className="input-field">
        <input type="text" placeholder="Enter your last name" name="lastname" defaultValue={state.values?.lastname} maxLength={150} required />
        <i className="uil uil-user icon" />
      </div>
      <div className="input-field">
        <input
          type="email"
          className={isBad(state, "email") ? "active" : ""}
          placeholder="Enter your email"
          name="email"
          defaultValue={state.values?.email}
          maxLength={150}
          required
        />
        <i className="uil uil-envelope icon" />
      </div>
      <PasswordField name="password" placeholder="Create a password" bad={isBad(state, "password")} />
      <PasswordField name="confirmpassword" placeholder="Confirm a password" bad={isBad(state, "password")} />
      {state.error && <div className="inputerror">{state.error}</div>}
      <SubmitButton label="Signup" pending={pending} />
    </form>
  );
}

export function AccountForm({ user }: { user: { firstname: string; lastname: string; email: string } }) {
  const [state, action, pending] = useActionState(updateAccount, empty);
  const v = state.values ?? user;
  return (
    <form action={action} autoComplete="off">
      <div className="input-field">
        <input type="text" placeholder="Enter your first name" name="firstname" defaultValue={v.firstname} maxLength={150} required />
        <i className="uil uil-user icon" />
      </div>
      <div className="input-field">
        <input type="text" placeholder="Enter your last name" name="lastname" defaultValue={v.lastname} maxLength={150} required />
        <i className="uil uil-user icon" />
      </div>
      <div className="input-field">
        <input
          type="email"
          className={isBad(state, "email") ? "active" : ""}
          placeholder="Enter your email"
          name="email"
          defaultValue={v.email}
          maxLength={150}
          required
        />
        <i className="uil uil-envelope icon" />
      </div>
      {state.error && <div className="inputerror">{state.error}</div>}
      <div className="input-field button">
        <Link href="/account/password" className="password2">
          Click to change Password
        </Link>
      </div>
      <SubmitButton label="Update Info" pending={pending} />
    </form>
  );
}

export function PasswordForm() {
  const [state, action, pending] = useActionState(changePassword, empty);
  const bad = isBad(state, "password");
  return (
    <form action={action}>
      <PasswordField name="currentpassword" placeholder="Enter current password" bad={bad} />
      <PasswordField name="newpassword" placeholder="Enter new password" bad={bad} />
      <PasswordField name="confirmnewpassword" placeholder="Confirm new password" bad={bad} />
      {state.error && <div className="inputerror">{state.error}</div>}
      <SubmitButton label="Update Password" pending={pending} />
    </form>
  );
}
