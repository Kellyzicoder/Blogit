import Navbar from "@/components/Navbar";
import { PasswordForm } from "@/components/AuthForms";
import { requireUser } from "@/lib/auth";

export const metadata = { title: "Change Password | BLOGit" };

export default async function PasswordPage() {
  await requireUser();

  return (
    <>
      <Navbar
        links={[
          { href: "/topics", label: "Home" },
          { href: "/account", label: "Personal Info" },
        ]}
      />
      <div className="outer-container">
        <div className="container">
          <div className="form">
            <i className="fa-solid fa-user" />
            <h2 className="text-primary">Change Password</h2>
            <PasswordForm />
          </div>
        </div>
      </div>
    </>
  );
}
