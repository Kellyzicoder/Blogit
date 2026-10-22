import Navbar from "@/components/Navbar";
import { getCurrentUser } from "@/lib/auth";
import { getAllPublishedEntries } from "@/lib/data";
import { shortDate } from "@/lib/format";

export const metadata = { title: "Community | BLOGit" };
export const dynamic = "force-dynamic";

/** Everyone's published entries. Anyone can read this page, logged in or not. */
export default async function CommunityPage() {
  const [user, entries] = await Promise.all([getCurrentUser(), getAllPublishedEntries()]);

  return (
    <>
      <Navbar links={[{ href: user ? "/topics" : "/", label: "Home" }]} />
      <div className="container3">
        <section className="publishedinfo">
          <div className="container2">
            {entries.length === 0 && (
              <div className="noblogentry">
                <div>
                  <p>There are no entries currently published</p>
                </div>
              </div>
            )}
            {entries.map((e) => (
              <div className="displaypublishdetails" key={e.entryid}>
                <div className="publishedheader">
                  <div className="topicname">
                    <h3 className="blogname">{e.bgname}</h3>
                    <i className="fa-solid fa-circle" />
                    <h3 className="entryname">{e.entname}</h3>
                  </div>
                  <div className="authordate">
                    <p className="authorname">
                      @{e.firstname} {e.lastname}
                    </p>
                    <p className="publisheddate">{shortDate(e.entdate)}</p>
                  </div>
                </div>
                <div className="publishedinfo">{e.enttext}</div>
              </div>
            ))}
          </div>
        </section>
      </div>
    </>
  );
}
