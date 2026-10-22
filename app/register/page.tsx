import Link from "next/link";
import { redirect } from "next/navigation";
import Navbar from "@/components/Navbar";
import { RegisterForm } from "@/components/AuthForms";
import { getCurrentUser } from "@/lib/auth";

export const metadata = { title: "Signup | BLOGit" };

export default async function RegisterPage() {
  if (await getCurrentUser()) redirect("/topics");

  return (
    <>
      <Navbar links={[{ href: "/", label: "Home" }]} />
      <div className="outer-container height">
        <div className="container">
          <div className="form">
            <i className="fa-solid fa-user" />
            <h2 className="text-primary">Registration</h2>
            <RegisterForm />
          </div>
        </div>
        <Link className="login-now-1" href="/privacy">
          Click to view our Privacy Policy
        </Link>
      </div>
    </>
  );
}
