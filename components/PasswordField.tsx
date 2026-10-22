"use client";

import { useState } from "react";

/** Password box with the eye icon to show/hide what you typed. */
export default function PasswordField({
  name,
  placeholder,
  bad,
  required = true,
}: {
  name: string;
  placeholder: string;
  bad?: boolean;
  required?: boolean;
}) {
  const [show, setShow] = useState(false);
  return (
    <div className="input-field">
      <input
        type={show ? "text" : "password"}
        className={`password${bad ? " active" : ""}`}
        placeholder={placeholder}
        name={name}
        required={required}
        autoComplete={name === "currentpassword" || name === "password" ? "current-password" : "new-password"}
      />
      <i className="uil uil-lock icon" />
      <i
        className={`uil ${show ? "uil-eye" : "uil-eye-slash"} showHidePw`}
        onClick={() => setShow((s) => !s)}
        role="button"
        aria-label={show ? "Hide password" : "Show password"}
      />
    </div>
  );
}
