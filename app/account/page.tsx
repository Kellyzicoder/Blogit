import Navbar from "@/components/Navbar";
import Flash from "@/components/Flash";
import { AccountForm } from "@/components/AuthForms";
import { requireUser } from "@/lib/auth";
import { param, type SearchParams } from "@/lib/params";

export const metadata = { title: "Account | BLOGit" };

export default async function AccountPage({ searchParams }: { searchParams: SearchParams }) {
  const sp = await searchParams;
  const user = await requireUser();

  return (
    <>
      <Navbar links={[{ href: "/topics", label: "Home" }]} />
      <div className="outer-container">
        <Flash ok={param(sp, "ok")} err={param(sp, "err")} />
        <div className="container">
          <div className="form signup">
            <i className="fa-solid fa-user" />
            <h2 className="text-primary">Personal Info</h2>
            <AccountForm user={{ firstname: user.firstname, lastname: user.lastname, email: user.email }} />
          </div>
        </div>
      </div>
    </>
  );
}
