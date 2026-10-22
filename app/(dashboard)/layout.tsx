import Navbar from "@/components/Navbar";
import SideNav from "@/components/SideNav";
import { isAdmin, requireUser } from "@/lib/auth";

/** Shared frame for the logged-in pages: top bar, left menu, white content area. */
export default async function DashboardLayout({ children }: { children: React.ReactNode }) {
  const user = await requireUser();

  return (
    <>
      <Navbar links={[{ href: "/community", label: "Community" }]} />
      <div className="container1">
        <SideNav isAdmin={isAdmin(user)} />
        <section className="main-content">{children}</section>
      </div>
    </>
  );
}
