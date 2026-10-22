import Link from "next/link";
import IconButton from "./IconButton";
import ConfirmDelete from "./ConfirmDelete";
import { shortDate } from "@/lib/format";
import { STATUS, type Entry, type From } from "@/lib/types";
import { deleteEntry } from "@/app/actions/blog";

/** One entry row in a list (topic entries, Drafts or Published). */
export default function EntryRow({
  entry,
  from,
  listPath,
  deleting,
  showStatus = false,
}: {
  entry: Entry;
  from: From;
  /** The page this row is on, used for ?delete= and Cancel. */
  listPath: string;
  deleting: boolean;
  showStatus?: boolean;
}) {
  const isDraft = entry.statusid === STATUS.draft;

  return (
    <div>
      <div className="displayentrydetails">
        <form>
          <input className="entname" value={entry.entname} readOnly />
          <input className="enttext" value={entry.enttext} readOnly />
          <input className="entdate" value={shortDate(entry.entdate)} readOnly />
          {showStatus && (
            <input
              className={isDraft ? "statustypered" : "statustypeblue"}
              value={isDraft ? "Draft" : "Published"}
              readOnly
            />
          )}
        </form>
        <IconButton
          action={`/entries/${entry.entryid}/edit`}
          hidden={{ from }}
          icon="edit"
          title="Edit this entry"
        />
        <IconButton action={listPath} hidden={{ delete: entry.entryid }} icon="delete" title="Delete this entry" />
        <form>
          <Link className="btn" href={`/entries/${entry.entryid}?from=${from}`}>
            Preview
          </Link>
        </form>
      </div>

      {deleting && (
        <ConfirmDelete
          what="entry"
          action={deleteEntry}
          hidden={{ entryid: entry.entryid, from }}
          cancelHref={listPath}
        />
      )}
    </div>
  );
}
