import { notFound } from "next/navigation";
import Navbar from "@/components/Navbar";
import Flash from "@/components/Flash";
import EntryForm from "@/components/EntryForm";
import { requireUser } from "@/lib/auth";
import { getTopicForUser } from "@/lib/data";
import { todayIso } from "@/lib/format";
import { idParam, param, type SearchParams } from "@/lib/params";
import { createEntry } from "@/app/actions/blog";

export const metadata = { title: "New Entry | BLOGit" };

export default async function NewEntryPage({ searchParams }: { searchParams: SearchParams }) {
  const sp = await searchParams;
  const user = await requireUser();
  const blogid = idParam(sp, "topic");
  const topic = blogid ? await getTopicForUser(blogid, user.userid) : null;
  if (!topic) notFound();

  return (
    <>
      <Navbar links={[{ href: "/topics", label: "Home" }]} />
      <Flash err={param(sp, "err")} />
      <div className="container3">
        <div className="content-2">
          <EntryForm
            heading={`Creating New Entry in "${topic.bgname}"`}
            backHref={`/topics/${topic.blogid}`}
            action={createEntry}
            hidden={{ blogid: topic.blogid }}
            defaultDate={todayIso()}
            buttons={[
              { intent: "draft", label: "Draft", className: "btn3", icon: true },
              { intent: "publish", label: "Publish", className: "btn2" },
            ]}
          />
        </div>
      </div>
    </>
  );
}
