import Link from "next/link";
import Flash from "@/components/Flash";
import IconButton from "@/components/IconButton";
import ConfirmDelete from "@/components/ConfirmDelete";
import { requireAdmin } from "@/lib/auth";
import { getAllUsers } from "@/lib/data";
import { shortDate, timeAgo } from "@/lib/format";
import { idParam, param, type SearchParams } from "@/lib/params";
import { USER_TYPE } from "@/lib/types";
import { deleteUser, setUserPassword, updateUser } from "@/app/actions/admin";

export const metadata = { title: "Users | BLOGit" };

/** Admin page: see everyone, edit their details or type, reset passwords, delete users. */
export default async function UsersPage({ searchParams }: { searchParams: SearchParams }) {
  const sp = await searchParams;
  const admin = await requireAdmin();
  const users = (await getAllUsers()).filter((u) => u.userid !== admin.userid);

  const editing = idParam(sp, "edit");
  const deleting = idParam(sp, "delete");
  const changingPassword = idParam(sp, "password");
  const dupeEmail = param(sp, "dupe") === "1";
  const err = param(sp, "err");

  return (
    <>
      <Flash ok={param(sp, "ok")} err={changingPassword ? undefined : err} />
      <div className="content">
        <div className="name">
          <h1>Administration</h1>
        </div>

        {users.length === 0 && (
          <div className="noblogentry">
            <div>
              <p>There are no other users yet</p>
            </div>
          </div>
        )}

        {users.map((u) => {
          const typeLabel = u.usertype === USER_TYPE.admin ? "An Admin" : "A Normal User";
          return (
            <div key={u.userid}>
              <div className="displayblogdetails">
                <form>
                  <input type="text" className="inputname" value={`${u.firstname} ${u.lastname}`} readOnly />
                  <input type="text" className="userdate" value={`Signed Up: ${shortDate(u.userdate)}`} readOnly />
                  <input type="text" className="inputstatus" value={`Active: ${timeAgo(u.online)}`} readOnly />
                  <input type="text" className="usertype" value={`Description: ${typeLabel}`} readOnly />
                </form>
                <IconButton action="/users" hidden={{ edit: u.userid }} icon="edit" title="Edit this user" />
                <IconButton action="/users" hidden={{ delete: u.userid }} icon="delete" title="Delete this user" />
              </div>

              {deleting === u.userid && (
                <ConfirmDelete
                  what="user (and all their topics and entries)"
                  action={deleteUser}
                  hidden={{ userid: u.userid }}
                  cancelHref="/users"
                />
              )}

              {editing === u.userid && (
                <div className="updateblogcontainer">
                  <div className="blog-heading">
                    <h3>Editing User</h3>
                  </div>
                  <form action={updateUser} className="blogupdate" autoComplete="off">
                    <input type="hidden" name="userid" value={u.userid} />
                    <div className="groupnamedate">
                      <div>
                        <label htmlFor="u-first">First name</label>
                        <input id="u-first" type="text" name="firstname" defaultValue={u.firstname} maxLength={150} required />
                        <label htmlFor="u-last">Last name</label>
                        <input id="u-last" type="text" name="lastname" defaultValue={u.lastname} maxLength={150} required />
                        <label htmlFor="u-email">Email</label>
                        <input
                          id="u-email"
                          type="email"
                          className={dupeEmail ? "active" : ""}
                          name="email"
                          defaultValue={u.email}
                          maxLength={150}
                          required
                        />
                      </div>
                    </div>
                    <fieldset className="status-type">
                      <legend>User Type</legend>
                      <span className="radio-item">
                        <label htmlFor="type-1">A Normal User</label>
                        <input type="radio" id="type-1" name="status" value="1" defaultChecked={u.usertype !== USER_TYPE.admin} />
                      </span>
                      <span className="radio-item">
                        <label htmlFor="type-2">An Admin</label>
                        <input type="radio" id="type-2" name="status" value="2" defaultChecked={u.usertype === USER_TYPE.admin} />
                      </span>
                    </fieldset>
                    <Link className="btn" href={`/users?password=${u.userid}`}>
                      Click to change Password
                    </Link>
                    <div className="doublebuttons">
                      <button className="btn" type="submit">
                        Update User Info
                      </button>
                      <Link className="btn" href="/users">
                        Cancel
                      </Link>
                    </div>
                  </form>
                </div>
              )}

              {changingPassword === u.userid && (
                <div className="bgmodalpassword">
                  <div className="modalcontentpassword">
                    <h3>Change Password</h3>
                    <form action={setUserPassword} autoComplete="off">
                      <input type="hidden" name="userid" value={u.userid} />
                      <div>
                        <label htmlFor="admin-newpw">New Password</label>
                        <input
                          id="admin-newpw"
                          type="password"
                          placeholder="Enter new password"
                          className={`password${err ? " active" : ""}`}
                          name="newpassword"
                          autoComplete="new-password"
                        />
                      </div>
                      <div>
                        <label htmlFor="admin-confirmpw">Confirm Password</label>
                        <input
                          id="admin-confirmpw"
                          type="password"
                          placeholder="Confirm new password"
                          className={`password${err ? " active" : ""}`}
                          name="confirmnewpassword"
                          autoComplete="new-password"
                        />
                      </div>
                      {err && <div className="inputerror">{err}</div>}
                      <div className="doublebuttons">
                        <button className="btn" type="submit">
                          Change Password
                        </button>
                        <Link className="btn4" href="/users">
                          Cancel
                        </Link>
                      </div>
                    </form>
                  </div>
                </div>
              )}
            </div>
          );
        })}
      </div>
    </>
  );
}
