export type SearchParams = Promise<Record<string, string | string[] | undefined>>;

/** Read one ?name=value from the URL as text. */
export function param(all: Record<string, string | string[] | undefined>, name: string) {
  const value = all[name];
  return Array.isArray(value) ? value[0] : value;
}

/** Read one ?name=123 from the URL as a number id, or null. */
export function idParam(all: Record<string, string | string[] | undefined>, name: string) {
  const n = Number(param(all, name));
  return Number.isInteger(n) && n > 0 ? n : null;
}
