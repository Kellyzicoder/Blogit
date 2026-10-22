"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { useState } from "react";
import { createTopic } from "@/app/actions/blog";

/** Left menu with the "Compose Topic" pop-up. */
export default function SideNav({ isAdmin }: { isAdmin: boolean }) {
  const pathname = usePathname();
  const [composing, setComposing] = useState(false);

  const links = [
    { href: "/topics", label: "My Topics", icon: "fa-bars" },
    { href: "/drafts", label: "Drafts", icon: "fa-bookmark" },
    { href: "/published", label: "Published", icon: "fa-circle-check" },
    ...(isAdmin ? [{ href: "/users", label: "Users", icon: "fa-user-lock" }] : []),
  ];

  return (
    <>
      <section className="left-navigations">
        <button className="composeblog btn" type="button" onClick={() => setComposing(true)}>
          COMPOSE TOPIC
        </button>
        {links.map((l) => (
          <Link
            key={l.href}
            href={l.href}
            className={pathname === l.href || pathname.startsWith(`${l.href}/`) ? "current" : undefined}
          >
            <i className={`fa-solid ${l.icon}`} /> {l.label}
          </Link>
        ))}
      </section>

      <div className={`bg-modal${composing ? "" : " no-modal"}`}>
        <div className="modal-content">
          <h3>Compose Topic</h3>
          <form action={createTopic} className="addblog">
            <div className="groupnamedate">
              <div>
                <label htmlFor="new-bgname">Topic Name</label>
                <input
                  id="new-bgname"
                  type="text"
                  name="bgname"
                  placeholder="Houses in New Zealand"
                  maxLength={150}
                  required
                />
              </div>
              <div>
                <label htmlFor="new-bgdate">Date</label>
                <input id="new-bgdate" type="date" name="bgdate" required />
              </div>
            </div>
            <label htmlFor="new-bgdescript">Description</label>
            <textarea id="new-bgdescript" name="bgdescript" maxLength={200} />
            <div className="doublebuttons">
              <button className="btn" type="submit">
                Create Topic
              </button>
              <button className="btn4" type="button" onClick={() => setComposing(false)}>
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>
    </>
  );
}
