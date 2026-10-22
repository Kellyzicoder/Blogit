import Link from "next/link";
import { redirect } from "next/navigation";
import Navbar from "@/components/Navbar";
import Flash from "@/components/Flash";
import { LoginForm } from "@/components/AuthForms";
import { getCurrentUser } from "@/lib/auth";
import { param, type SearchParams } from "@/lib/params";

export const metadata = { title: "Login | BLOGit" };

export default async function LoginPage({ searchParams }: { searchParams: SearchParams }) {
  if (await getCurrentUser()) redirect("/topics");
  const sp = await searchParams;

  return (
    <>
      <Navbar links={[{ href: "/", label: "Home" }]} />
      <div className="outer-container">
        <Flash
          ok={param(sp, "registered") ? "Your account has been created. You can log in now." : undefined}
        />
        <div className="container">
          <div className="form">
            <i className="fa-solid fa-user" />
            <h2 className="text-primary">Account Login</h2>
            <LoginForm />
          </div>
        </div>
        <Link className="login-now-1" href="/privacy">
          Click to view our Privacy Policy
        </Link>
      </div>
    </>
  );
}
