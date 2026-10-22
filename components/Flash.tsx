"use client";

import { useEffect, useState } from "react";

/** The green/red pop-up message at the top. Disappears after 3 seconds, like before. */
export default function Flash({ ok, err }: { ok?: string; err?: string }) {
  const [visible, setVisible] = useState(true);

  useEffect(() => {
    setVisible(true);
    const timer = setTimeout(() => setVisible(false), 3000);
    return () => clearTimeout(timer);
  }, [ok, err]);

  if (!visible || (!ok && !err)) return null;
  return (
    <div className={ok ? "topentsuccess" : "topenterror"} role="status">
      <p>{ok ?? err}</p>
    </div>
  );
}
