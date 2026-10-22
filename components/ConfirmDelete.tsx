import Link from "next/link";

/** The "Are you sure you want to delete this ...?" box under a row. */
export default function ConfirmDelete({
  what,
  action,
  hidden,
  cancelHref,
}: {
  what: string;
  action: (form: FormData) => Promise<void>;
  hidden: Record<string, string | number>;
  cancelHref: string;
}) {
  return (
    <div className="deletingblog">
      <div className="deletingblogcontent">
        <div>
          <form action={action} autoComplete="off">
            {Object.entries(hidden).map(([k, v]) => (
              <input key={k} type="hidden" name={k} value={v} />
            ))}
            <h3>Are you sure you want to delete this {what}?</h3>
            <div className="doublebuttons">
              <button className="btn4" type="submit">
                Confirm delete
              </button>
              <Link className="btn" href={cancelHref} scroll={false}>
                No, cancel
              </Link>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
}
