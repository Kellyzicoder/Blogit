import Link from "next/link";
import type { Entry } from "@/lib/types";

type Button = { intent: string; label: string; className: string; icon?: boolean };

/** The big entry editor used for both "Creating New Entry" and "Editing Entry". */
export default function EntryForm({
  heading,
  backHref,
  action,
  hidden,
  buttons,
  entry,
  defaultDate,
}: {
  heading: string;
  backHref: string;
  action: (form: FormData) => Promise<void>;
  hidden: Record<string, string | number>;
  buttons: Button[];
  entry?: Entry;
  defaultDate?: string;
}) {
  return (
    <div className="updateentrycontainer">
      <div className="entry-heading">
        <Link href={backHref} aria-label="Back">
          <i className="fa-sharp fa-solid fa-arrow-left" />
        </Link>
        <h3>{heading}</h3>
      </div>
      <form action={action} className="entryupdate" autoComplete="off">
        <div className="buttonnav">
          {buttons.map((b) => (
            <button key={b.intent} className={b.className} type="submit" name="intent" value={b.intent}>
              {b.label} {b.icon && <i className="fa-sharp fa-solid fa-floppy-disk" />}
            </button>
          ))}
        </div>
        {Object.entries(hidden).map(([k, v]) => (
          <input key={k} type="hidden" name={k} value={v} />
        ))}
        <div className="groupnamedate">
          <div>
            <label htmlFor="entname">Entry name</label>
            <input
              id="entname"
              type="text"
              name="entname"
              placeholder="School is inevitable"
              defaultValue={entry?.entname}
              maxLength={150}
              required
            />
          </div>
          <div>
            <label htmlFor="entdate">Date of Creation:</label>
            <input id="entdate" type="date" name="entdate" defaultValue={entry?.entdate ?? defaultDate} required />
          </div>
        </div>
        <label htmlFor="enttext">Description</label>
        <textarea id="enttext" name="enttext" defaultValue={entry?.enttext} maxLength={2000} />
      </form>
    </div>
  );
}
