const MONTHS_SHORT = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
const MONTHS_LONG = [
  "January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December",
];

/** "2022-10-25" -> "Oct 25, 2022" (same as the old PHP "M j, Y"). */
export function shortDate(isoDate: string) {
  const [y, m, d] = isoDate.split("-").map(Number);
  if (!y || !m || !d) return isoDate;
  return `${MONTHS_SHORT[m - 1]} ${d}, ${y}`;
}

function ordinal(n: number) {
  const tens = n % 100;
  if (tens >= 11 && tens <= 13) return `${n}th`;
  return `${n}${["th", "st", "nd", "rd"][n % 10] ?? "th"}`;
}

/** Today's date as "YYYY-MM-DD", for date inputs. */
export function todayIso() {
  return new Date().toISOString().slice(0, 10);
}

/**
 * How long ago someone was last active, like the old gettime() in PHP:
 * "few seconds ago", "5 minutes ago", "3 hr, 10 min ago", "2 d, 4 hr ago",
 * or the full date after more than 2 days.
 */
export function timeAgo(when: Date | null) {
  if (!when) return "Unknown";
  const seconds = Math.max(0, Math.floor((Date.now() - when.getTime()) / 1000));
  const minutes = Math.floor(seconds / 60);
  const hours = Math.floor(minutes / 60);
  const days = Math.floor(hours / 24);

  if (days > 2) {
    return `${MONTHS_LONG[when.getUTCMonth()]} ${ordinal(when.getUTCDate())}, ${when.getUTCFullYear()}`;
  }
  if (days === 2) return `2 d, ${hours % 24} hr ago`;
  if (days === 1) return `1 d, ${hours % 24} hr ago`;
  if (hours > 1) return `${hours} hr, ${minutes % 60} min ago`;
  if (hours === 1) return "An hour ago";
  if (minutes > 1) return `${minutes} minutes ago`;
  if (minutes === 1) return "A minute ago";
  if (seconds >= 10) return `${seconds} seconds ago`;
  return "few seconds ago";
}
