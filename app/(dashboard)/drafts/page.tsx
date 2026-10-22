import StatusList from "@/components/StatusList";
import type { SearchParams } from "@/lib/params";

export const metadata = { title: "Drafts | BLOGit" };

export default async function DraftsPage({ searchParams }: { searchParams: SearchParams }) {
  return <StatusList kind="drafts" sp={await searchParams} />;
}
