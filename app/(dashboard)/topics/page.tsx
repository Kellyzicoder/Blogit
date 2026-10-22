import Link from "next/link";
import Flash from "@/components/Flash";
import IconButton from "@/components/IconButton";
import ConfirmDelete from "@/components/ConfirmDelete";
import { requireUser } from "@/lib/auth";
import { getTopicsForUser } from "@/lib/data";
import { shortDate } from "@/lib/format";
import { idParam, param, type SearchParams } from "@/lib/params";
import { deleteTopic, updateTopic } from "@/app/actions/blog";

export const metadata = { title: "Homepage | My Topics" };

export default async function TopicsPage({ searchParams }: { searchParams: SearchParams }) {
  const sp = await searchParams;
  const user = await requireUser();
  const topics = await getTopicsForUser(user.userid);
  const editing = idParam(sp, "edit");
  const deleting = idParam(sp, "delete");

  return (
    <>
      <Flash ok={param(sp, "ok")} err={param(sp, "err")} />
      <div className="content">
        <div className="name">
          <h1>
            Welcome, {user.firstname} {user.lastname}
          </h1>
        </div>

        {topics.length === 0 && (
          <div className="noblogentry">
            <div>
              <p>There are no topics currently created</p>
            </div>
          </div>
        )}

        {topics.map((t) => (
          <div key={t.blogid}>
            <div className="displayblogdetails">
              <form>
                <input type="text" className="inputname" value={t.bgname} readOnly />
                <input type="text" className="inputdescript" value={t.bgdescript} readOnly />
                <input type="text" className="inputdate" value={shortDate(t.bgdate)} readOnly />
              </form>
              <IconButton action="/topics" hidden={{ edit: t.blogid }} icon="edit" title="Edit this topic" />
              <IconButton action="/topics" hidden={{ delete: t.blogid }} icon="delete" title="Delete this topic" />
              <form>
                <Link className="btn" href={`/topics/${t.blogid}`}>
                  View Entries
                </Link>
              </form>
            </div>

            {deleting === t.blogid && (
              <ConfirmDelete
                what="topic"
                action={deleteTopic}
                hidden={{ blogid: t.blogid }}
                cancelHref="/topics"
              />
            )}

            {editing === t.blogid && (
              <div className="updateblogcontainer">
                <div className="blog-heading">
                  <h3>Editing Topic</h3>
                </div>
                <form action={updateTopic} className="blogupdate" autoComplete="off">
                  <input type="hidden" name="blogid" value={t.blogid} />
                  <div className="groupnamedate">
                    <div>
                      <label htmlFor="edit-bgname">Topic name</label>
                      <input id="edit-bgname" type="text" name="bgname" defaultValue={t.bgname} maxLength={150} required />
                    </div>
                    <div>
                      <label htmlFor="edit-bgdate">Date of Creation:</label>
                      <input id="edit-bgdate" type="date" name="bgdate" defaultValue={t.bgdate} required />
                    </div>
                  </div>
                  <label htmlFor="edit-bgdescript">Description</label>
                  <textarea id="edit-bgdescript" name="bgdescript" defaultValue={t.bgdescript} maxLength={200} />
                  <div className="doublebuttons">
                    <button className="btn" type="submit">
                      Update Topic
                    </button>
                    <Link className="btn" href="/topics">
                      Cancel
                    </Link>
                  </div>
                </form>
              </div>
            )}
          </div>
        ))}
      </div>
    </>
  );
}
