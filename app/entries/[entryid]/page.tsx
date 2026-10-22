import Link from "next/link";
import { notFound } from "next/navigation";
import { requireUser } from "@/lib/auth";
import { getEntryForUser } from "@/lib/data";
import { shortDate } from "@/lib/format";
import { param, type SearchParams } from "@/lib/params";

export const metadata = { title: "Preview | BLOGit" };

/** Shows your entry the way it looks on the Community page. */
export default async function PreviewEntryPage({
  params,
  searchParams,
}: {
  params: Promise<{ entryid: string }>;
  searchParams: SearchParams;
}) {
  const [{ entryid }, sp] = await Promise.all([params, searchParams]);
  const user = await requireUser();
  const id = Number(entryid);
  const entry = Number.isInteger(id) ? await getEntryForUser(id, user.userid) : null;
  if (!entry) notFound();

  const from = param(sp, "from");
  const backHref = from === "drafts" || from === "published" ? `/${from}` : `/topics/${entry.blogid}`;

  return (
    <section className="publishedinfo">
      <div className="container4">
        <div className="name">
          <Link href={backHref} aria-label="Back">
            <i className="fa-sharp fa-solid fa-arrow-left" />
          </Link>
          <h1>Preview</h1>
        </div>
        <div className="displaypreviewdetails">
          <div className="publishedheader">
            <div className="topicname">
              <h3 className="blogname">{entry.bgname}</h3>
              <i className="fa-solid fa-circle" />
              <h3 className="entryname">{entry.entname}</h3>
            </div>
            <div className="authordate">
              <p className="authorname">
                @{entry.firstname} {entry.lastname}
              </p>
              <p className="publisheddate">{shortDate(entry.entdate)}</p>
            </div>
          </div>
          <div className="previewinfo">{entry.enttext}</div>
        </div>
      </div>
    </section>
  );
}
