import { notFound } from "next/navigation";
import Navbar from "@/components/Navbar";
import Flash from "@/components/Flash";
import EntryForm from "@/components/EntryForm";
import { requireUser } from "@/lib/auth";
import { getEntryForUser } from "@/lib/data";
import { param, type SearchParams } from "@/lib/params";
import { STATUS, type From } from "@/lib/types";
import { saveEntry } from "@/app/actions/blog";

export const metadata = { title: "Edit Entry | BLOGit" };

export default async function EditEntryPage({
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

  const fromParam = param(sp, "from");
  const from: From = fromParam === "drafts" || fromParam === "published" ? fromParam : "topic";
  const backHref = from === "topic" ? `/topics/${entry.blogid}` : `/${from}`;
  const isDraft = entry.statusid === STATUS.draft;

  // Same buttons as the old site: a draft can be published, a published entry can go back to drafts.
  const buttons = isDraft
    ? [
        { intent: "keep", label: "Update Draft", className: "btn" },
        { intent: "publish", label: "Publish", className: "btn2" },
      ]
    : [
        { intent: "keep", label: "Update Entry", className: "btn" },
        { intent: "draft", label: "Draft", className: "btn3", icon: true },
      ];

  return (
    <>
      <Navbar links={[{ href: "/topics", label: "Home" }]} />
      <Flash err={param(sp, "err")} />
      <div className="container3">
        <div className="content-2">
          <EntryForm
            heading={`Editing Entry in "${entry.bgname}"`}
            backHref={backHref}
            action={saveEntry}
            hidden={{ entryid: entry.entryid, from }}
            entry={entry}
            buttons={buttons}
          />
        </div>
      </div>
    </>
  );
}
