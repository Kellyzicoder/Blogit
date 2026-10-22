import Link from "next/link";
import { getCurrentUser } from "@/lib/auth";
import { logout } from "@/app/actions/auth";

/** Top bar. Shows Account + Logout when logged in, Login + Signup when not. */
export default async function Navbar({ links = [] }: { links?: { href: string; label: string }[] }) {
  const user = await getCurrentUser();

  return (
    <nav id="navbar">
      <div className="nav-logo">
        <h1>
          BLOG<span className="text-primary">it.</span>
        </h1>
      </div>
      <div id="nav-menu">
        {links.map((l) => (
          <Link key={l.href} href={l.href}>
            {l.label}
          </Link>
        ))}
        {user ? (
          <div className="LogInOut">
            <Link className="navloggedIn" href="/account">
              Account
            </Link>
            <form action={logout} className="signoutform">
              <input className="btn" type="submit" value="Logout" />
            </form>
          </div>
        ) : (
          <>
            <Link href="/login" className="btn">
              Login
            </Link>
            <Link href="/register" className="btn">
              Signup
            </Link>
          </>
        )}
      </div>
    </nav>
  );
}
