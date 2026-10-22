import Flash from "./Flash";
import EntryRow from "./EntryRow";
import { requireUser } from "@/lib/auth";
import { getEntriesForUserByStatus } from "@/lib/data";
import { idParam, param } from "@/lib/params";
import { STATUS } from "@/lib/types";

/** The Drafts page and the Published page are the same list with a different status. */
export default async function StatusList({
  kind,
  sp,
}: {
  kind: "drafts" | "published";
  sp: Record<string, string | string[] | undefined>;
}) {
  const user = await requireUser();
  const entries = await getEntriesForUserByStatus(
    user.userid,
    kind === "drafts" ? STATUS.draft : STATUS.published,
  );
  const deleting = idParam(sp, "delete");
  const listPath = `/${kind}`;

  return (
    <>
      <Flash ok={param(sp, "ok")} err={param(sp, "err")} />
      <div className="content">
        <div className="name">
          <h1>{kind === "drafts" ? "Drafts" : "Published"}</h1>
        </div>

        {entries.length === 0 && (
          <div className="noblogentry">
            <div>
              <p>{kind === "drafts" ? "There are no drafts currently saved" : "There are no entries currently published"}</p>
            </div>
          </div>
        )}

        {entries.map((e) => (
          <EntryRow
            key={e.entryid}
            entry={e}
            from={kind}
            listPath={listPath}
            deleting={deleting === e.entryid}
            showStatus
          />
        ))}
      </div>
    </>
  );
}
