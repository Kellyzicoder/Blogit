import Link from "next/link";
import { notFound } from "next/navigation";
import Flash from "@/components/Flash";
import EntryRow from "@/components/EntryRow";
import { requireUser } from "@/lib/auth";
import { getEntriesForTopic, getTopicForUser } from "@/lib/data";
import { idParam, param, type SearchParams } from "@/lib/params";

export const metadata = { title: "Entries | BLOGit" };

export default async function TopicEntriesPage({
  params,
  searchParams,
}: {
  params: Promise<{ blogid: string }>;
  searchParams: SearchParams;
}) {
  const [{ blogid }, sp] = await Promise.all([params, searchParams]);
  const user = await requireUser();
  const id = Number(blogid);
  const topic = Number.isInteger(id) ? await getTopicForUser(id, user.userid) : null;
  if (!topic) notFound();

  const entries = await getEntriesForTopic(topic.blogid);
  const deleting = idParam(sp, "delete");
  const listPath = `/topics/${topic.blogid}`;

  return (
    <>
      <Flash ok={param(sp, "ok")} err={param(sp, "err")} />
      <div className="content">
        <div className="name">
          <h1>
            Entry <div className="blogname2">{topic.bgname}</div>
          </h1>
        </div>

        {entries.length === 0 && (
          <div className="noblogentry">
            <div>
              <p>There are no entries currently created</p>
            </div>
          </div>
        )}

        {entries.map((e) => (
          <EntryRow
            key={e.entryid}
            entry={e}
            from="topic"
            listPath={listPath}
            deleting={deleting === e.entryid}
          />
        ))}

        <div id="add-entry">
          <Link href={`/entries/new?topic=${topic.blogid}`}>
            <span className="btn">+ Add Entry</span>
          </Link>
        </div>
      </div>
    </>
  );
}
