/** What a form action sends back to the page when something is wrong. */
export type FormState = {
  error?: string;
  /** Which fields to outline in red. */
  badFields?: string[];
  /** What the user typed, so the form isn't wiped after an error. */
  values?: Record<string, string>;
};

/** Read a text field from a form, trimmed. */
export function field(form: FormData, name: string) {
  const value = form.get(name);
  return typeof value === "string" ? value.trim() : "";
}

/** Read a field that must be a whole number id. Returns null if it isn't. */
export function idField(form: FormData, name: string) {
  const n = Number(field(form, name));
  return Number.isInteger(n) && n > 0 ? n : null;
}

/** A page path with a success or error message on it, shown as the pop-up banner. */
export function withMessage(path: string, kind: "ok" | "err", message: string) {
  const joiner = path.includes("?") ? "&" : "?";
  return `${path}${joiner}${kind}=${encodeURIComponent(message)}`;
}

/** True for a real calendar date like "2026-10-22" (not "2026-02-30"). */
export const isIsoDate = (value: string) => {
  if (!/^\d{4}-\d{2}-\d{2}$/.test(value)) return false;
  const d = new Date(`${value}T00:00:00Z`);
  return !Number.isNaN(d.getTime()) && d.toISOString().slice(0, 10) === value;
};

export const isEmail = (value: string) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);

export const MIN_PASSWORD = 8;
